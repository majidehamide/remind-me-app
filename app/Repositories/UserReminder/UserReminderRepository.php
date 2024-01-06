<?php

namespace App\Repositories;

use App\Models\UserReminder;

class UserReminderRepository
{
    public function getById($id)
    {
        return UserReminder::findOrFail($id);
    }

    public function getAll()
    {
        return UserReminder::all();
    }

    public function create($data)
    {
        return UserReminder::create($data);
    }

    public function update($id, $data)
    {
        $reminder= UserReminder::findOrFail($id);
        $reminder->update($data);
        return $reminder;
    }

    public function delete($id)
    {
        $reminder= UserReminder::findOrFail($id);
        $reminder->delete();
    }
}
