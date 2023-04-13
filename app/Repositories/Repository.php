<?php

namespace App\Repositories;

use App\Exceptions\RepositoryException;
use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    protected Model $modelInstance;

    private Builder $query;

    public function __construct()
    {
        $this->makeModel();
    }

    public function makeModel()
    {
        if (empty($this->model)) {
            throw new RepositoryException('The model class must be set on the repository.');
        }

        return $this->modelInstance = new $this->model;
    }

    public function getModel(): Model
    {
        return $this->modelInstance;
    }

    public function getNew(array $attributes = []): Model
    {
        return $this->modelInstance->newInstance($attributes);
    }

    public function newQuery()
    {
        $this->query = $this->getNew()->newQuery();

        return $this;
    }

    public function all(array $columns = ['*'])
    {
        return $this->modelInstance->newQuery()->get($columns);
    }

    public function find(int $id)
    {
        return $this->modelInstance->findOrFail($id);
    }

    public function findBy(array $data, array $columns = ['*'])
    {
        $this->newQuery();

        foreach ($data as $attribute => $value) {
            if (is_array($value)) {
                $this->query->whereIn($attribute, $value);
            } else {
                $this->query->where($attribute, '=', $value);
            }
        }

        return $this->query->get($columns);
    }

    public function create(array $data)
    {
        return $this->modelInstance::create($data);
    }
}
