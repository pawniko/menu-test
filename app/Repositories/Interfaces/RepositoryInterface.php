<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function all(array $columns);

    public function find(int $id);

    public function findBy(array $data, array $columns = ['*']);

    public function create(array $data);
}
