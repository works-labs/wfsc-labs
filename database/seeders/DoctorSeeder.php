<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::create([
            'name' => 'Amelia Putri',
            'slug' => 'amelia-putri',
            'title' => 'dr.',
            'photo' => null,
            'short_bio' => 'Dokter estetika dengan fokus pada perawatan kulit dan kecantikan.',
            'bio' => 'dr. Amelia Putri merupakan dokter estetika yang berfokus pada kesehatan kulit, perawatan wajah, dan aesthetic medicine.',
            'specialization' => 'Aesthetic Medicine',
            'education' => 'Universitas Airlangga',
            'certifications' => 'Certified Aesthetic Practitioner',
            'experience' => '8 tahun',
            'is_active' => true,
        ]);

        Doctor::create([
            'name' => 'Kevin Wijaya',
            'slug' => 'kevin-wijaya',
            'title' => 'dr.',
            'photo' => null,
            'short_bio' => 'Dokter dengan spesialisasi aesthetic medicine dan perawatan wajah.',
            'bio' => 'dr. Kevin Wijaya berfokus pada berbagai prosedur aesthetic medicine dan perawatan kesehatan kulit.',
            'specialization' => 'Aesthetic Medicine',
            'education' => 'Universitas Indonesia',
            'certifications' => 'Certified Aesthetic Practitioner',
            'experience' => '6 tahun',
            'is_active' => true,
        ]);

        Doctor::create([
            'name' => 'Nathania Prameswari',
            'slug' => 'nathania-prameswari',
            'title' => 'dr.',
            'photo' => null,
            'short_bio' => 'Dokter yang berfokus pada kesehatan kulit dan dermatological treatment.',
            'bio' => 'dr. Nathania Prameswari memiliki fokus pada kesehatan kulit serta berbagai treatment dermatologis dan estetika.',
            'specialization' => 'Dermatology',
            'education' => 'Universitas Gadjah Mada',
            'certifications' => 'Dermatology & Aesthetic Certification',
            'experience' => '7 tahun',
            'is_active' => true,
        ]);
    }
}