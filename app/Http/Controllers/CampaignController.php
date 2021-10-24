<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Repositories\CampaignRepository;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CampaignCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Http\Requests\UpdateCampaignRequest;
use App\Http\Requests\StoreCampaignRequest;

class CampaignController extends Controller
{
    /**
     * @var CampaignRepository
     */
    private $campaignRepo;

    /**
     * CampaignController constructor.
     * @param CampaignRepository $campaignRepo
     */
    public function __construct(CampaignRepository $campaignRepo)
    {
        $this->campaignRepo = $campaignRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\ResourceCollection
     */
    public function index(): CampaignCollection
    {
        return $this->campaignRepo->listCampaigns();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCampaignRequest $request): JsonResponse
    {
        $creatives = $this->uploadFiles($request->creatives);

        $campaign = $this->campaignRepo->create([
            'name' => $request->name,
            'total_budget' => $request->total_budget,
            'daily_budget' => $request->daily_budget,
            'from' => $request->from,
            'to' => $request->to,
            'creatives' => $creatives
        ]);

        return response()->json([
            'message' => 'Campaign created successfully!',
            'data' => new CampaignResource($campaign)
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id): View
    {
        return view('edit', [
            'campaign' => $this->campaignRepo->findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateCampaignRequest $request, int $id): JsonResponse
    {
        $campaign = $this->campaignRepo->findOrFail($id);

        $uploads = [];

        if ($request->has('creatives')) {
            $uploads = $this->uploadFiles($request->creatives);

            //delete previous creatives
            foreach ($campaign->creatives as $creative) {
                Storage::disk('public')->delete($creative['file_path']);
            }
        }

        $campaign->update([
            'name' => $request->name,
            'total_budget' => $request->total_budget,
            'daily_budget' => $request->daily_budget,
            'from' => $request->from,
            'to' => $request->to,
            'creatives' => $request->has('creatives') ? $uploads : $campaign->creatives
        ]);

        return response()->json([
            'message' => 'Campaign updated successfully!',
            'data' => new CampaignResource($campaign)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id): JsonResponse
    {
        $this->campaignRepo->findOrFail($id)->delete();

        return response()->json([
            'message' => "Campaign deleted successfully!"
        ], 200);
    }

    /**
     * Upload creatives
     * 
     * @param array $creatives
     * @return array
     */
    private function uploadFiles($creatives): array
    {
        $uploads = [];

        foreach ($creatives as $creative) {
            $file_name = time() . '_' . $creative->getClientOriginalName();
            $file_path = $creative->storeAs('uploads', $file_name, 'public');

            $uploads[] = [
                'file_name' => $file_name,
                'file_path' => $file_path,
                'url' => Storage::disk('public')->url($file_path),
                'id' => uniqid()
            ];
        }

        return $uploads;
    }
}
