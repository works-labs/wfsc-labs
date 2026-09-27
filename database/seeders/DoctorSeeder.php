<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorHomeSection;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name'           => 'dr. Amanda Wijaya',
                'slug'           => 'dr-amanda-wijaya',
                'title'          => 'Aesthetic Doctor',
                'photo'          => null,
                'short_bio'      => 'Dokter estetika yang berfokus pada perawatan anti aging, facial contouring, dan rejuvenasi kulit untuk membantu pasien tampil lebih percaya diri.',
                'bio'            => 'dr. Amanda Wijaya memiliki pengalaman lebih dari 8 tahun di bidang estetika medis. Beliau menangani berbagai treatment anti aging, skin rejuvenation, facial contouring, serta perawatan non-bedah yang mengutamakan hasil natural dan keamanan pasien',
                'specialization' => 'Aesthetic Medicine & Anti Aging Treatment',
                'education'      => "Doctor of Medicine, Universitas Airlangga\nAdvanced Training in Aesthetic Medicine",
                'certifications' => "Certified Aesthetic Medicine Practitioner\nAdvanced Botox & Dermal Filler Certification\nCertified Thread Lift Training",
                'experience'     => '8+ Years Experience',
                'is_active'      => true,
            ],
            [
                'name'           => 'dr. Michael Santoso',
                'slug'           => 'dr-michael-santoso',
                'title'          => 'Senior Aesthetic Doctor',
                'photo'          => null,
                'short_bio'      => 'Dokter estetika yang memiliki fokus pada pembentukan kontur wajah, peremajaan kulit, dan treatment berbasis teknologi modern.',
                'bio'            => 'dr. Michael Santoso telah berpengalaman lebih dari 10 tahun dalam bidang estetika medis. Beliau menangani berbagai prosedur facial contouring, anti aging, skin tightening, dan perawatan wajah non-invasif dengan pendekatan yang personal untuk setiap pasien.',
                'specialization' => 'Facial Contouring & Skin Rejuvenation',
                'education'      => "Doctor of Medicine, Universitas Indonesia\nDiploma in Aesthetic Medicine",
                'certifications' => "Certified HIFU Practitioner\nAdvanced Facial Contouring Certification\nInternational Aesthetic Medicine Training Program",
                'experience'     => '10+ Years Experience',
                'is_active'      => false,
            ],
            [
                'name'           => 'dr. Yuly Lie Jaya',
                'slug'           => 'dr-yuly-lie-jaya',
                'title'          => 'M. Biomed (AAM)',
                'photo'          => null,
                'short_bio'      => 'Mendirikan WFSC Clinic: Memulai klinik estetika independen yang awalnya berkembang pesat di Tanjung Redeb, Berau, Kalimantan Timur, sebelum akhirnya membuka cabang premium di kawasan elite Citraland, Surabaya Barat.',
                'bio'            => "Pendidikan Kedokteran Umum: Menyelesaikan gelar profesi Dokter Kedokteran (dr.) untuk memperoleh lisensi klinis dasar.\nGelar Magister Biomedik (M.Biomed): Mengambil program pascasarjana Magister Biomedik dengan peminatan khusus Anti-Aging Medicine (AAM). Ilmu ini mendalami proses penuaan dari level seluler dan hormonal untuk memperpanjang keremajaan kulit serta organ tubuh.",
                'specialization' => 'Anti-Aging Medicine',
                'education'      => ' Meraih gelar S2 pascasarjana dari Program Studi Ilmu Biomedik, Fakultas Kedokteran Universitas Udayana.',
                'certifications' => "Advanced Certified Injector\nCadaver Anatomy Course Certifications",
                'experience'     => '-',
                'is_active'      => true,
            ],
        ];

        foreach ($doctors as $data) {
            Doctor::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }

        // Doctor Home Sections
        $amandaId  = Doctor::where('slug', 'dr-amanda-wijaya')->value('id');
        $michaelId = Doctor::where('slug', 'dr-michael-santoso')->value('id');
        $yulyId    = Doctor::where('slug', 'dr-yuly-lie-jaya')->value('id');

        $sections = [
            // hero section
            ['doctor_id' => $yulyId,    'section' => 'hero',    'sort_order' => 0, 'is_active' => true],
            ['doctor_id' => $michaelId, 'section' => 'hero',    'sort_order' => 1, 'is_active' => false],
            // doctors section
            ['doctor_id' => $yulyId,    'section' => 'doctors', 'sort_order' => 2, 'is_active' => true],
            ['doctor_id' => $amandaId,  'section' => 'doctors', 'sort_order' => 3, 'is_active' => true],
            ['doctor_id' => $michaelId, 'section' => 'doctors', 'sort_order' => 3, 'is_active' => true],
        ];

        foreach ($sections as $section) {
            DoctorHomeSection::firstOrCreate(
                ['doctor_id' => $section['doctor_id'], 'section' => $section['section']],
                $section
            );
        }
    }
}