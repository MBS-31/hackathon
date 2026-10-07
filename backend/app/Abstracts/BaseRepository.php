<?php

namespace App\Abstracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * BaseRepository
 *
 * Abstract data-access base that all CRM Eloquent repositories extend.
 * Provides standard CRUD + pagination so domain repositories only need
 * to add domain-specific query methods.
 */
abstract class BaseRepository
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * Return all records.
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    /**
     * Paginate records.
     */
    public function paginate(int $perPage = 25, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->newQuery()->paginate($perPage, $columns);
    }

    /**
     * Find by primary key.
     */
    public function findById(int|string $id, array $columns = ['*']): ?Model
    {
        return $this->model->newQuery()->select($columns)->find($id);
    }

    /**
     * Find or throw ModelNotFoundException.
     */
    public function findOrFail(int|string $id): Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    /**
     * Create a new record.
     */
    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    /**
     * Update an existing record.
     */
    public function update(Model $model, array $data): Model
    {
        $model->fill($data)->save();
        return $model->fresh();
    }

    /**
     * Delete a record (hard delete).
     */
    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    /**
     * Count total records.
     */
    public function count(): int
    {
        return $this->model->newQuery()->count();
    }
}
