<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\ModelNotDefined;
use App\Repositories\Contracts\IBase;
use App\Repositories\Criteria\ICriteria;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

class BaseRepository implements IBase, ICriteria
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
    }

    protected function getModelClass()
    {
        if (!method_exists($this, 'model')) {
            throw new ModelNotDefined();
        }
        dd($this->model);
        return app()->make($this->model);
    }

    /**
     * @return mixed
     */
    public function all(): mixed
    {
        return $this->model->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findWhere($column, $value): mixed
    {
        return $this->model->where($column, $value)->get();
    }

    /**
     * @param $column
     * @param $value
     * @return mixed
     */
    public function findWhereFirst($column, $value): mixed
    {
        return $this->model->where($column, $value)->firstOrFail();
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 10): mixed
    {
        return $this->model->paginate($perPage);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        $record = $this->find($id);
        return $record->delete();
    }

    public function withCriteria(...$criteria): static
    {
        $criteria = Arr::flatten($criteria);
        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }
        return $this;
    }
}
