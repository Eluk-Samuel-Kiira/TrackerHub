<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_first_name' => 'required|string|max:255',
            'user_last_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email',
            'user_role' => 'required',
            'user_department' => 'required',
        ]);

        $username = Str::lower(substr($request->user_first_name, 0, 1) . $request->user_last_name);
        $randomPassword = Str::random(10);
        $hashedPassword = Hash::make($randomPassword);

        $user = User::create([
            'name' => $username,
            'first_name' => $request->user_first_name,
            'last_name' => $request->user_last_name,
            'email' => $request->user_email,
            'role' => $request->user_role,
            'department_id' => $request->user_department,
            'password' => $hashedPassword,
        ]);

        Mail::to($user->email)->send(new NewUserMail(
            $user->first_name . ' ' . $user->last_name,
            $user->role,
            $user->department->name,
            $user->email,
            $randomPassword
        ));

        return response()->json(['success' => true, 'user' => $user]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
