<?php

namespace App\Models;

use App\Http\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory, UUID;

     /**
        * The attributes that are mass assignable.
        *
        * @var array<int, string>
        */
    protected $fillable = [
        'user_id',
        'healthcare_professional_id',
        'appointment_start_time',
        'appointment_end_time',
        'status',
    ];

    /**
     * Define the relationship with the Project model
     *
     * @return \App\Models\HealthcareProfessional  $healthcareProfessional
     */
    public function healthcareProfessional()
    {
        return $this->belongsTo(HealthcareProfessional::class);
    }

    /**
     * Define the relationship with the User model
     *
     * @return \App\Models\User  $user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
