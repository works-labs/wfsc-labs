<?php

namespace App\Http\Controllers;

use App\Models\Doctor;

class PublicDoctorController extends Controller
{
    public function show(Doctor $doctor)
    {
        abort_unless($doctor->is_active, 404);

        return view('public.doctors.show', [
            'doctor' => $doctor,
        ]);
    }
}