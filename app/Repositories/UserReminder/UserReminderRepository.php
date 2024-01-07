<?php

namespace App\Repositories\UserReminder;

use App\Models\UserReminder;
use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Repositories\UserReminder\UserReminderRepositoryInterface;

class UserReminderRepository extends BaseRepository implements UserReminderRepositoryInterface
{
    private const LIMIT = 15;
    protected $model;

    public function __construct(UserReminder $model)
    {
        $this->model = $model;
    }
    public function getById($id): ?UserReminder
    {
        return UserReminder::findOrFail($id);
    }

    public function getAll(Request $request)
    {
        $limit = $request->limit ?? self::LIMIT;
        $data['reminders'] = UserReminder::simplePaginate($limit);
        $data['limit'] = $limit;
        return $data;
    }

    public function create($data) :?UserReminder
    {
        return UserReminder::create($data);
    }

    public function update($data, UserReminder $userReminder): ?UserReminder
    {
        $userReminder->update($data);
        return $userReminder;
    }

    public function delete(UserReminder $userReminder) : void
    {
        $userReminder->delete();
    }
}
