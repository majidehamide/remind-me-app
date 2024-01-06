<?php

namespace App\Http\Controllers\Api;

use App\Models\UserReminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserReminderResource;
use Illuminate\Support\Facades\Validator;

class UserReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string',
            'description'     => 'required|string',
            'remind_at'  => 'required|integer',
            'event_at'  => 'required|integer',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors'    => $validator->errors(), 
                ], 422);
        }

        //create reminder
        $input = $request->all();
        $input['user_id'] = $request->user()->id;
        $userReminder = UserReminder::create($input);
        return response()->json([
            "ok" => true,
            "data" => new UserReminderResource($userReminder)
        ]);
    }

    /**
     * Display the resource.
     */
    public function getListReminder(Request $request)
    {
        
        //$reminders = User
        return response()->json([
            "ok" => true,
            "data" => new UserReminderResource($userReminder)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserReminder $userReminder)
    {
        return response()->json([
            "ok" => true,
            "data" => new UserReminderResource($userReminder)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserReminder $userReminder)
    {
        return response()->json([
            "ok" => true,
            "data" => new UserReminderResource($userReminder)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReminder $userReminder)
    {
        return response()->json([
            "ok" => true,
            "data" => new UserReminderResource($userReminder)
        ]);
    }
}
