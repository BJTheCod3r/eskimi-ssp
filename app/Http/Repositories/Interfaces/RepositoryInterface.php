<?php

declare(strict_types=1);

namespace App\Http\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Model;

/**
 * Interface RepositoryInterface
 * @package App\Api\V1\Repositories\Interfaces
 */
interface RepositoryInterface
{
    /**
     * Create record
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
}
