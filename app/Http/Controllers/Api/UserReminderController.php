<?php

namespace App\Http\Controllers\Api;

use App\Models\UserReminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        //create user
        $userReminder = UserReminder::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(UserReminder $userReminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserReminder $userReminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserReminder $userReminder)
    {
        //
    }
}
