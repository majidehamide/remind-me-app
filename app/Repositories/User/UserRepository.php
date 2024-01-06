<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model::findOrFail($id);
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function create($data): ?User
    {
        return $this->model::create($data);
    }

    public function update($id, $data): ?User
    {
        
        $user= $this->model::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user= $this->model::findOrFail($id);
        $user->delete();
    }
}
