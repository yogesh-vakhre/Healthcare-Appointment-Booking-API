<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ApiHelpers;
use App\Models\Appointment;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiHelpers; // Using the apiHelpers Trait


    /**
     * Store a newly registered resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
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
        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            $data['token'] =  $token;
            $data['user'] =  $user;
            return $this->onSuccess($data, 'User Created',201);
        }
    }

    /**
     * login a newly registered resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:50',
            'password' => 'required',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->onError(404,'Validation Error.',$errors);
        }
        // Return errors if details not valid.
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->onError(403,'Invalid login details');
        }
        $user = User::where('email', $request->username)->firstOrFail();


        $token = $user->createToken('auth_token')->plainTextToken;
        $data['token'] =  $token;
        $data['user'] =  $user;

        return $this->onSuccess($data, 'User Logged In Successfully');
    }

    /**
     * Current User detials resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request): JsonResponse
    {
        return $this->onSuccess($request->user(), 'Current User Retrieved');
    }

    /**
     * Current User logout resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->onSuccess($request->user(), 'User Logged Out Successfully');
    }

    /**
     * User can only change the status of the appointment assigned to them.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function cancelAppointment(Request $request, $appointmentId): JsonResponse
    {
        $appointment= Appointment::findOrFail($appointmentId);
        // Update appointment
        $appointment->where('user_id',$request->user()->id)->update(['status'=>'canceled']);
        return $this->onSuccess($appointment, 'Appointments is canceled');
    }

    /**
     * Get all appointment with their associated healthcareProfessional.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function viewAllAppointments(Request $request): JsonResponse
    {
       $userId= $request->user()->id;
       $appointments = Appointment::with(['healthcareProfessional'])->where('user_id',  $userId)->get();
       return $this->onSuccess($appointments, 'Appointments All Retrieved');
    }
}
