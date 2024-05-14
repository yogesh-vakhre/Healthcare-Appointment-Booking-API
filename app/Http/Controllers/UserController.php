<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiHelpers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    use ApiHelpers; // Using the apiHelpers Trait

    /**
     *  Get all users with their associated tasks and projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::get();
        return $this->onSuccess($users, 'User All Retrieved');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:10',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
           $errors = $validator->errors();
           return $this->onError(404,'Validation Error.',$errors);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        return $this->onSuccess($user, 'User Created',201);

    }

    /**
     * Get a specific user with their associated tasks and projects.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user): JsonResponse
    {
        return $this->onSuccess($user, 'User Retrieved');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user): JsonResponse
    {
        return $this->onSuccess($user, 'User Retrieved');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->all();

        // Validate request data
         $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'required|min:10',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->onError(400,'Validation Error.',$errors);
        }

        // Update user
        $user->update($data);

        return $this->onSuccess($user, 'User Updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete(); // Delete the specific user data
        return $this->onSuccess($user, 'User Deleted');
    }

}
