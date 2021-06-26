<?php

namespace App\Repositories\Concrete\Eloquent;

use App\Models\Auth\Role;
use App\Models\Log;
use App\Repositories\Concrete\ElBaseRepository;
use App\Repositories\Interfaces\KullaniciInterface;
use App\User;

class ElKullaniciDal implements KullaniciInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = app()->makeWith(ElBaseRepository::class, ['model' => $model]);
    }

    public function all($filter = null, $columns = ['*'], $relations = null)
    {
        return $this->model->all($filter, $columns, $relations)->get();
    }

    public function allWithPagination($filter = null, $columns = ['*'], $perPageItem = null, $relations = null)
    {
        return $this->model->allWithPagination($filter, $columns, $perPageItem);
    }

    public function getById($id, $columns = ['*'], $relations = null)
    {
        return $this->model->getById($id, $columns, $relations);
    }

    public function getByColumn(string $field, $value, $columns = ['*'], $relations = null)
    {
        return $this->model->getByColumn($field, $value, $columns, $relations);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->update($data, $id);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }

    public function with($relations, $filter = null, bool $paginate = null, int $perPageItem = null)
    {
        return $this->model->with($relations, $filter, $paginate, $perPageItem);
    }

    public function getAllRolesWithPagination()
    {
        return Role::orderByDesc('id')->simplePaginate();
    }

    public function getRoleById($id)
    {
        return Role::find($id);
    }

    public function createRole($data)
    {
        try {
            $record = Role::create($data);
            session()->flash('message', config('constants.messages.success_message'));

            return $record;
        } catch (\Exception $exception) {
            session()->flash('message_type', 'danger');
            session()->flash('message', $exception->getMessage());
            Log::addLog('role eklerken hata oluştu', $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    public function updateRole($id, $data)
    {
        try {
            $role = $this->getRoleById($id);
            if ($role) {
                $record = $role->update($data);
                session()->flash('message', config('constants.messages.success_message'));

                return $role;
            }
        } catch (\Exception $exception) {
            session()->flash('message_type', 'danger');
            session()->flash('message', $exception->getMessage());
            Log::addLog('role güncellerken hata oluştu', $exception, Log::TYPE_CREATE_OBJECT);
        }
    }

    public function deleteRole($id)
    {
        $role = Role::find($id);
        if (! $role) {
            return false;
        }

        $role->permissions()->detach();
        $role->delete();

        return true;
    }
}
