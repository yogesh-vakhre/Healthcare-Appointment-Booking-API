<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\HealthcareProfessional;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            'user_id' => 'uuid',
            'healthcare_professional_id' => 'uuid',
            'appointment_start_time' => 'date',
            'appointment_end_time' => 'date|after:appointment_start_time',
            'status' => 'nullable|in:booked,completed,cancelled,pending',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
           $errors = $validator->errors();
           return $this->onError(404,'Validation Error.',$errors);
        }

        // Return errors if healthcareProfessional not found error occur.
        $healthcareProfessional = HealthcareProfessional::find($request->healthcare_professional_id);
        if (empty($healthcareProfessional)) {
            return $this->onError(404,'Healthcare professional not found');
        }
        // Return errors if user not found error occur.
        $user = User::find($request->user_id);
        if (empty($user )) {
            return $this->onError(404,'User not found');
        }
        $task = Appointment::create($request->all());

        return $this->onSuccess($task, 'Book an appointment Created',201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
