<?php

declare(strict_types=1);


namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\Interfaces\RepositoryInterface;

/**
 * Class BaseRepository
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     * @param string $model
     */
    public function __construct(string $model)
    {
        $this->model = $model;
    }

    /**
     * Give us access to the model properties
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->model::$name(...$arguments);
    }

    /**
     * Create a record
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model::create($attributes);
    }
}
