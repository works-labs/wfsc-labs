<?php

namespace Database\Seeders;

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TreatmentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = TreatmentCategory::pluck('id', 'slug');

        $treatments = [
            // ==========================================
            // SKIN QUALITY
            // ==========================================
            [
                'category' => 'skin-quality',
                'name' => 'Luxury Salmon DNA',
                'short_description' => 'Injeksi skin booster Polynucleotide (PN/PDRN) dari ikan salmon untuk regenerasi alami dan elastisitas kulit.',
                'description' => "Injeksi skin booster yang mengandung Polynucleotide (PN) atau Polydeoxyribonucleotide (PDRN), yaitu fragmen DNA murni yang berasal dari ikan salmon. Kandungan ini membantu memperbaiki kualitas kulit dengan merangsang proses regenerasi alami dan pembentukan kolagen, sehingga kulit menjadi lebih sehat, kenyal, dan bercahaya.\n\nManfaat Luxury Salmon DNA:\n• Merangsang produksi kolagen dan elastin.\n• Meningkatkan hidrasi kulit dari dalam.\n• Mempercepat regenerasi dan perbaikan jaringan kulit.\n• Menghaluskan tekstur kulit dan membantu menyamarkan bekas jerawat.\n• Mengurangi garis halus dan tanda-tanda penuaan dini.\n• Meningkatkan elastisitas sehingga kulit tampak lebih kencang.\n• Membantu memperkuat skin barrier dan mengurangi kemerahan akibat kulit.",
                'is_featured' => true,
                'related' => ['Magic Exoskin Booster', 'Luxury Vampire Treatment (PRP)', 'Magic Stamp Ellisys Sense'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Magic Exoskin Booster',
                'short_description' => 'Treatment regeneratif berbasis exosome dan growth factor untuk merangsang perbaikan dan kekenyalan kulit.',
                'description' => "Treatment regeneratif yang menggunakan exosome. Exosome mengandung berbagai molekul bioaktif seperti growth factor, protein, peptida, lipid, dan RNA, yang membantu merangsang proses perbaikan dan regenerasi kulit.\n\nManfaat Magic Exoskin Booster:\n• Merangsang produksi kolagen & elastin.\n• Menghidrasi kulit secara mendalam.\n• Mempercepat regenerasi sel kulit.\n• Menghaluskan tekstur dan menyamarkan garis halus.\n• Mencerahkan serta meratakan warna kulit.\n• Membuat kulit lebih kenyal, sehat, dan glowing alami.\n• Membantu memperkuat skin barrier.",
                'is_featured' => true,
                'related' => ['Luxury Salmon DNA', 'Magic Stamp Ellisys Sense', 'Plasma Pro'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Magic Stamp Ellisys Sense',
                'short_description' => 'Peremajaan kulit menggabungkan microneedling dan energi Radio Frequency (RF) untuk bopeng dan pori-pori.',
                'description' => "Treatment peremajaan kulit yang menggabungkan microneedling (jarum mikro) dengan energi Radio Frequency (RF). Jarum mikro menghantarkan energi RF langsung ke lapisan dermis sehingga merangsang produksi kolagen dan elastin tanpa merusak permukaan kulit secara berlebihan.\n\nManfaat Magic Stamp Ellisys Sense:\n• Memperbaiki acne scars / bopeng bekas jerawat.\n• Memperbaiki tekstur kulit dan mengecilkan pori-pori.\n• Meratakan warna kulit dan membuat kulit tampak lebih cerah.\n• Merangsang produksi kolagen dan elastin.\n• Meningkatkan elastisitas kulit.\n• Mengurangi garis halus dan kerutan.",
                'is_featured' => true,
                'related' => ['Subcision', 'Luxury Vampire Treatment (PRP)', 'Luxury Salmon DNA'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Luxury Vampire Treatment (PRP)',
                'short_description' => 'Perawatan PRP menggunakan plasma darah kaya platelet dan faktor pertumbuhan untuk peremajaan kulit murni.',
                'description' => "PRP adalah plasma darah yang kaya akan platelet dan mengandung berbagai macam faktor pertumbuhan (Growth Factor) yang berperan dalam proses perbaikan (regenerasi) dan penyembuhan jaringan rusak. Proses pembuatan PRP: darah diambil dari pembuluh darah vena lalu diproses sentrifuge untuk memisahkan plasma darah murni.\n\nManfaat Luxury Vampire Treatment (PRP):\n• Menghaluskan, melembabkan, dan mencerahkan kulit wajah.\n• Peremajaan kulit wajah, mengencangkan dan mengurangi keriput.\n• Menyamarkan bopeng bekas jerawat dan mengecilkan pori-pori.\n• Menyamarkan flek dan noda hitam (bekas luka).\n• Mengurangi lingkaran hitam dan keriput di sekitar mata, leher, dan tangan.\n• Mengurangi stretchmark.\n• Mengobati kebotakan (alopesia) serta merangsang pertumbuhan rambut baru.",
                'is_featured' => true,
                'related' => ['Subcision', 'Magic Stamp Ellisys Sense', 'Hair Restoration'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Magic Black Doll Laser',
                'short_description' => 'Laser masker karbon untuk membersihkan pori-pori mendalam, mengurangi komedo, dan membuat wajah glowing.',
                'description' => "Merupakan perawatan mengunakan masker karbon terlebih dahulu pada wajah, lalu dilanjutkan dengan proses laser, dengan tujuan mengangkat sel-sel kulit mati bersamaan dengan karbon yang diaplikasikan pada kulit. Karbon berfungsi membersihkan kulit wajah hingga ke pori-pori.\n\nManfaat Magic Black Doll Laser:\n• Mencerahkan dan menjadikan kulit lebih glowing.\n• Meremajakan kulit / rejuvenation.\n• Mengecilkan pori-pori.\n• Menyamarkan noda hitam, bekas jerawat, dan flek.\n• Mengurangi komedo & kadar minyak.\n• Membuat kulit menjadi lebih halus dan mengurangi kerutan.",
                'is_featured' => false,
                'related' => ['Glass Skin IPL', 'Plasma Pro', 'Underarm Carboxy Combo'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Plasma Pro',
                'short_description' => 'Peremajaan kulit mutakhir dengan teknologi Fractional, Single, dan Cold Plasma.',
                'description' => "Treatment peremajaan kulit yang menggunakan teknologi plasma untuk memperbaiki kualitas kulit, merangsang regenerasi, dan membantu mengatasi berbagai masalah kulit dengan waktu pemulihan yang relatif singkat.\n\nManfaat Plasma Pro:\n• Mencerahkan dan meremajakan kulit.\n• Menghaluskan tekstur kulit dan mengecilkan pori-pori.\n• Membantu mengatasi jerawat aktif dan bekas jerawat.\n• Mengurangi garis halus dan kerutan.\n• Membantu mengangkat skin tag dan lesi kulit tertentu.\n• Mempercepat regenerasi kulit dan membantu penyerapan serum.",
                'is_featured' => false,
                'related' => ['Magic Black Doll Laser', 'Electrocauter', 'Acne Injection'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Glass Skin IPL',
                'short_description' => 'Metode perawatan berbasis energi cahaya untuk mencerahkan, meredakan jerawat, dan menghilangkan flek.',
                'description' => "Merupakan metode perawatan kulit yang prinsip kerjanya merubah gelombang cahaya yang dipancarkan menjadi energi panas untuk merusak sel target (akar rambut, pigmen, dan pembuluh darah) pada lapisan dermis.\n\nManfaat Glass Skin IPL:\n• Mencerahkan warna kulit.\n• Membantu meredakan dan menghilangkan jerawat yang meradang.\n• Mengurangi kerutan dan meremajakan kulit.\n• Memudarkan melasma / flek-flek pada kulit.\n• Menghilangkan rambut di bagian tubuh yang tidak diinginkan.\n• Mengurangi tampilan pembuluh darah permukaan kulit yang melebar.",
                'is_featured' => false,
                'related' => ['Magic Black Doll Laser', 'Hair Removal', 'Acne Injection'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Electrocauter',
                'short_description' => 'Tindakan bedah mikro jarum listrik halus untuk menghilangkan kutil, milia, syringoma, dan tahi lalat.',
                'description' => "Tindakan bedah mikro menggunakan jarum kecil yang dialiri arus listrik dengan tujuan menghilangkan kelainan kulit berupa tumor jinak (tonjolan-tonjolan pada kulit) yang mengganggu penampilan.\n\nIndikasi & Manfaat Electrocauter:\n• Kutil.\n• Milia (penumpukan keratin pada saluran kelenjar minyak).\n• Hyperplasia kelenjar sebacea (pembesaran kelenjar minyak).\n• Syringoma (sumbatan saluran kelenjar keringat).\n• Menghilangkan komedo yang membandel (closed comedo).\n• Keratosis seboroik, nevus (tahi lalat), dan skin tag.",
                'is_featured' => false,
                'related' => ['Plasma Pro', 'Acne Injection'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Subcision',
                'short_description' => 'Prosedur pemutusan jaringan parut di bawah kulit untuk mengangkat bopeng bekas jerawat cekung (rolling scars).',
                'description' => "Prosedur medis untuk mengatasi bekas jerawat cekung (atrophic acne scars) dan beberapa jenis cekungan pada kulit. Treatment dilakukan dengan memasukkan jarum khusus di bawah permukaan kulit untuk memutus jaringan parut (fibrotic bands) yang menarik kulit ke bawah.\n\nManfaat Subcision:\n• Mengangkat bekas jerawat cekung (rolling scars).\n• Merangsang produksi kolagen alami.\n• Memperbaiki tekstur dan kerataan kulit.\n• Membuat bekas jerawat tampak lebih samar.\n• Meningkatkan efektivitas treatment lain seperti RF Microneedling, laser, atau skin booster.",
                'is_featured' => false,
                'related' => ['Magic Stamp Ellisys Sense', 'Luxury Vampire Treatment (PRP)', 'Luxury Salmon DNA'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Keloid Injection',
                'short_description' => 'Penyuntikan obat anti-inflamasi langsung ke jaringan keloid untuk mengecilkan dan melunakkan keloid.',
                'description' => "Prosedur medis untuk membantu mengurangi ukuran, ketebalan, dan kekerasan keloid dengan menyuntikkan obat langsung ke jaringan keloid.\n\nManfaat Keloid Injection:\n• Mengurangi ukuran dan ketebalan keloid.\n• Membantu melunakkan jaringan parut.\n• Mengurangi rasa gatal dan nyeri pada keloid.\n• Meratakan permukaan kulit.\n• Membantu mencegah keloid membesar atau kambuh.",
                'is_featured' => false,
                'related' => ['Magic Stamp Ellisys Sense for Body', 'Acne Injection'],
            ],
            [
                'category' => 'skin-quality',
                'name' => 'Acne Injection',
                'short_description' => 'Injeksi anti inflamasi langsung ke jerawat meradang besar untuk mempercepat penyembuhan.',
                'description' => "Treatment yang dilakukan dengan menyuntikkan obat anti inflamasi langsung ke jerawat yang meradang, terutama jerawat besar, merah, dan nyeri (seperti jerawat nodul atau kista).\n\nManfaat Acne Injection:\n• Mengurangi peradangan dan kemerahan.\n• Membantu mengecilkan jerawat lebih cepat.\n• Mengurangi rasa nyeri pada jerawat.\n• Mempercepat proses penyembuhan.\n• Membantu menurunkan risiko terbentuknya bekas jerawat.",
                'is_featured' => false,
                'related' => ['Glass Skin IPL', 'Plasma Pro', 'Keloid Injection'],
            ],

            // ==========================================
            // ANTI AGING & CONTOURING
            // ==========================================
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Botox',
                'short_description' => 'Injeksi Botulinum Toxin A untuk merelaksasi otot wajah, menghilangkan kerutan, dan meniruskan rahang.',
                'description' => "Perawatan estetika non-bedah yang menggunakan suntikan Botox (botulinum toxin tipe A) untuk merelaksasi otot-otot tertentu secara sementara. Dengan otot menjadi lebih rileks, kerutan akibat ekspresi wajah akan tampak lebih halus dan kulit terlihat lebih muda.\n\nManfaat Botox:\n• Menyamarkan efek penuaan.\n• Mengurangi kerutan di dahi, sekitar mata, sekitar bibir, dan dagu.\n• Mengurangi ukuran cuping hidung & koreksi tinggi alis.\n• Koreksi bentuk rahang (meniruskan pipi).\n• Mengurangi produksi keringat berlebihan (hiperhidrosis).\n• Mengecilkan pori-pori (micro botox).",
                'is_featured' => true,
                'related' => ['Dermal Filler', 'Premium Korean V-Shape', 'Ultra HIFU for Face'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Premium Korean V-Shape',
                'short_description' => 'Teknik induksi kolagen dan pengangkatan garis kontur wajah secara instan untuk tampilan v-shape sempurna.',
                'description' => "Korean V-Shape adalah teknik menstimulasi produksi kolagen serta mengangkat garis kontur wajah maupun tubuh secara instan. Kolagen yang dihasilkan merupakan hasil induksi dari dalam tubuh itu sendiri pada dermis.\n\nManfaat Premium Korean V-Shape:\n• Memberikan efek lifting seketika pada kulit.\n• Merangsang & meningkatkan sintesis kolagen pada dermis.\n• Menjadikan kulit wajah lebih kencang dan tampak lebih muda.\n• Menjadikan wajah lebih tirus (V-shape).\n• Mengurangi kantung mata dan mengecilkan pori-pori.\n• Meninggikan alis yang turun.",
                'is_featured' => true,
                'related' => ['Botox', 'Dermal Filler', 'Volumizing Thread'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'L-Shape Nose Lift',
                'short_description' => 'Pembentukan hidung tanpa operasi menggunakan benang Elasty LSCO untuk batang, columella, dan nose tip.',
                'description' => "Prosedur estetika non-bedah untuk pembentukan hidung tanpa operasi yang menggunakan benang khusus Elasty LSCO yang dapat mengkoreksi 3 area sekaligus (batang hidung, columella, dan nose tip) sehingga menghasilkan tampilan hidung yang lebih tinggi dan proporsional.\n\nManfaat L-Shape Nose Lift:\n• Hidung lebih mancung dengan hasil natural.\n• Membuat batang hidung jadi lebih tegas & nose tip lebih tinggi.\n• Membentuk hidung lebih proporsional & harmonis.\n• Merangsang produksi kolagen penopang.\n• Waktu pemulihan relatif lebih cepat dibandingkan operasi.",
                'is_featured' => true,
                'related' => ['Korean Nose Lift', 'Dermal Filler', 'Volumizing Thread'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Korean Nose Lift',
                'short_description' => 'Tindakan threadlift benang COG cannula khusus hidung untuk meninggikan hidung dan mempertegas kontur.',
                'description' => "Threadlift menggunakan benang COG canulla khusus untuk hidung, berfungsi mempertegas bentuk hidung dan mengecilkan lubang hidung.\n\nManfaat Korean Nose Lift:\n• Membuat hidung tampak lebih tinggi dan mancung.\n• Membentuk ujung hidung lebih tegas dan proporsional.\n• Menyeimbangkan kontur wajah secara natural.\n• Prosedur cepat dengan downtime minimal.",
                'is_featured' => false,
                'related' => ['L-Shape Nose Lift', 'Dermal Filler'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Volumizing Thread',
                'short_description' => 'Treatment benang khusus untuk efek lifting sekaligus menambah volume pada area wajah yang cekung.',
                'description' => "Treatment estetika yang menggunakan benang khusus untuk memberikan efek lifting sekaligus menambah volume pada area wajah yang tampak cekung atau kehilangan kekenyalan.\n\nManfaat Volumizing Thread:\n• Mengembalikan volume wajah yang berkurang & mengisi area cekung.\n• Mengencangkan kulit yang mulai kendur.\n• Merangsang produksi kolagen alami.\n• Membuat kontur wajah lebih proporsional, fresh, dan awet muda.",
                'is_featured' => false,
                'related' => ['Premium Korean V-Shape', 'Dermal Filler', 'Ultra HIFU for Face'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Dermal Filler',
                'short_description' => 'Injeksi Hyaluronic Acid untuk menambah volume bibir, dagu, garis senyum, dan kantung mata secara instan.',
                'description' => "Tindakan menyuntikkan Zat Hyaluronic Acid ke dalam lapisan kulit untuk menambah volume, membentuk kontur wajah, dan menyamarkan garis atau kerutan.\n\nManfaat Dermal Filler:\n• Menyempurnakan bentuk bibir, dagu, dahi, dan temple.\n• Menyamarkan lingkaran hitam & kantung mata (tear trough).\n• Menyamarkan garis senyum (smile line & marionette line).\n• Memberikan efek lifting dan meniruskan wajah (V-Shape).\n• Menyamarkan bopeng bekas jerawat & menghidrasi kulit.\n• Menyamarkan keriput pada punggung tangan (hand rejuvenation).",
                'is_featured' => true,
                'related' => ['Botox', 'Premium Korean V-Shape', 'L-Shape Nose Lift'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Ultra HIFU for Face',
                'short_description' => 'Pengencangan wajah non-bedah dengan energi High-Intensity Focused Ultrasound hingga ke lapisan SMAS.',
                'description' => "Treatment pengencangan wajah non-bedah yang menggunakan teknologi High-Intensity Focused Ultrasound (HIFU) untuk menghantarkan energi ultrasound terfokus ke jaringan lapisan SMAS dan lemak dibawah kulit.\n\nManfaat Ultra HIFU for Face:\n• Mengencangkan kulit wajah yang mulai kendur.\n• Memberikan efek lifting yang natural.\n• Mengurangi double chin & menyamarkan kerutan.\n• Membantu mempertegas kontur rahang dan wajah.\n• Tanpa operasi & tanpa downtime.",
                'is_featured' => false,
                'related' => ['Mesolipolysis for Face', 'Botox', 'Ultra HIFU for Body'],
            ],
            [
                'category' => 'anti-aging-contouring',
                'name' => 'Mesolipolysis for Face',
                'short_description' => 'Injeksi bahan aktif pemecah lemak wajah untuk meniruskan pipi, rahang, dan mengurangi double chin.',
                'description' => "Treatment non-bedah yang menggunakan injeksi bahan aktif untuk membantu mengurangi lemak pada area wajah tertentu, seperti pipi, double chin, atau garis rahang.\n\nManfaat Mesolipolysis for Face:\n• Membantu mengurangi lemak di area wajah.\n• Membentuk kontur wajah lebih tirus dan tegas.\n• Mengurangi tampilan double chin.\n• Membuat wajah terlihat lebih proporsional.",
                'is_featured' => false,
                'related' => ['Ultra HIFU for Face', 'Botox', 'Mesolipolysis for Body'],
            ],

            // ==========================================
            // BODY & HAIR TREATMENT
            // ==========================================
            [
                'category' => 'body-hair-treatment',
                'name' => 'Ultra HIFU for Body',
                'short_description' => 'Perawatan kontur tubuh dan pengencangan kulit kendur dengan teknologi ultrasound terfokus.',
                'description' => "Perawatan pembentukan kontur tubuh dan pengencangan kulit yang menggunakan teknologi High-Intensity Focused Ultrasound (HIFU) pada lapisan SMAS dan lemak di bawah kulit.\n\nManfaat Ultra HIFU for Body:\n• Membantu mengurangi lemak membandel pada area tubuh.\n• Mengencangkan kulit kendur pasca penurunan berat badan/melahirkan.\n• Membentuk kontur tubuh agar tampak lebih proporsional.\n• Merangsang produksi kolagen tanpa operasi & tanpa downtime.",
                'is_featured' => true,
                'related' => ['Mesolipolysis for Body', 'Magic Stamp Ellisys Sense for Body', 'Ultra HIFU for Face'],
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Magic Stamp Ellisys Sense for Body',
                'short_description' => 'Kombinasi microneedling dan RF untuk mengencangkan kulit tubuh, menyamarkan stretch mark & selulit.',
                'description' => "Perawatan non-bedah yang menggabungkan teknologi microneedling dan Radio Frequency (RF) untuk merangsang pembentukan kolagen hingga lapisan kulit tubuh yang lebih dalam.\n\nManfaat Magic Stamp Ellisys Sense for Body:\n• Mengencangkan kulit yang kendur.\n• Membantu menyamarkan stretch marks & selulit.\n• Mengurangi bekas luka dan memperbaiki tekstur kulit yang kasar.",
                'is_featured' => false,
                'related' => ['Magic CO2 Carboxy for Body', 'Ultra HIFU for Body', 'Magic Stamp Ellisys Sense'],
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Hair Restoration',
                'short_description' => 'Perawatan non-bedah untuk merangsang pertumbuhan rambut baru, menutrisi folikel, dan mencegah kebotakan.',
                'description' => "Perawatan yang bertujuan untuk membantu mengurangi kerontokan rambut, merangsang pertumbuhan rambut baru, serta meningkatkan kesehatan kulit kepala dan folikel rambut.\n\nManfaat Hair Restoration:\n• Membantu mengurangi kerontokan rambut.\n• Merangsang pertumbuhan rambut baru & meningkatkan kepadatan.\n• Menyehatkan kulit kepala dan membuat rambut lebih kuat.",
                'is_featured' => true,
                'related' => ['Luxury Vampire Treatment (PRP)', 'Hair Removal'],
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Hair Removal',
                'short_description' => 'Penghilangan bulu tubuh permanen dengan energi cahaya terkontrol pada akar rambut.',
                'description' => "Metode menghilangkan rambut yang tidak diinginkan (kumis, rambut kaki, tangan, ketiak) menggunakan energi cahaya yang diserap oleh pigmen rambut dan menghentikan pertumbuhan akar secara alami.\n\nManfaat Hair Removal:\n• Mengurangi pertumbuhan rambut yang tidak diinginkan secara permanen.\n• Membuat kulit terasa lebih halus dan lembut.\n• Mengurangi risiko ingrown hair & iritasi shaving/waxing.",
                'is_featured' => false,
                'related' => ['Underarm Carboxy Combo', 'Glass Skin IPL'],
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Magic CO2 Carboxy for Body',
                'short_description' => 'Treatment carboxy non-invasif untuk mencerahkan lipatan ketiak/selangkangan, memudarkan stretch mark & slimming.',
                'description' => "Merupakan treatment non-invasif yang mengembalikan elastisitas kulit, memudarkan stretch marks, mencerahkan area lipatan gelap (ketiak, siku, selangkangan, lutut), serta melancarkan sirkulasi limfatik.\n\nManfaat Magic CO2 Carboxy for Body:\n• Menjadikan kulit lebih cerah, halus, dan glowing.\n• Mengurangi jeradangan pada jerawat punggung.\n• Memudarkan stretch marks & mengurangi selulit.\n• Mencerahkan area lipatan tubuh yang gelap.\n• Melancarkan aliran limfatik & menjadikan tubuh lebih ramping.",
                'is_featured' => false,
                'related' => ['Underarm Carboxy Combo', 'Magic Stamp Ellisys Sense for Body'],
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Underarm Carboxy Combo',
                'short_description' => 'Kombinasi 3-in-1 Underarm Carboxy, Hair Removal IPL, dan Brightening Laser untuk ketiak mulus & cerah.',
                'description' => "Kombinasi 3 treatment sekaligus untuk mengatasi ketiak hitam & menghilangkan rambut ketiak:\n1. Underarm Carboxy\n2. Underarm Hair Removal (IPL)\n3. Magic Black Doll Laser / Brightening Laser\n\nManfaat Underarm Carboxy Combo:\n• Brightening effect mencerahkan kulit ketiak.\n• Melancarkan aliran limfatik & sirkulasi darah.\n• Menghilangkan & memperlambat pertumbuhan rambut ketiak.\n• Mengangkat sel kulit mati & menghaluskan kulit ketiak.",
                'is_featured' => true,
                'related' => ['Hair Removal', 'Magic CO2 Carboxy for Body', 'Magic Black Doll Laser'],
            ],
            [
                'category' => 'body-hair-treatment',
                'name' => 'Mesolipolysis for Body',
                'short_description' => 'Injeksi bahan aktif pemecah lemak lokal tubuh untuk mengecilkan lingkar perut, paha, atau lengan.',
                'description' => "Perawatan non-bedah yang menggunakan injeksi zat aktif ke lapisan lemak untuk membantu memecah lemak lokal yang sulit dihilangkan melalui diet dan olahraga.\n\nManfaat Mesolipolysis for Body:\n• Membantu mengurangi lemak membandel pada area tertentu.\n• Membentuk kontur tubuh agar lebih proporsional.\n• Membantu mengecilkan lingkar tubuh pada area yang dirawat.",
                'is_featured' => false,
                'related' => ['Ultra HIFU for Body', 'Mesolipolysis for Face'],
            ],
        ];

        // Step 1: Create or update all treatments
        foreach ($treatments as $data) {
            Treatment::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'category_id' => $categories[$data['category']] ?? null,
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'short_description' => $data['short_description'],
                    'description' => $data['description'],
                    'cover_image' => null,
                    'is_featured' => $data['is_featured'],
                    'is_active' => true,
                ]
            );
        }

        // Step 2: Attach related treatments
        $allTreatments = Treatment::pluck('id', 'name');

        foreach ($treatments as $data) {
            if (!empty($data['related'])) {
                $treatment = Treatment::where('name', $data['name'])->first();

                if ($treatment) {
                    $relatedIds = collect($data['related'])
                        ->map(fn($name) => $allTreatments[$name] ?? null)
                        ->filter()
                        ->toArray();

                    $treatment->relatedTreatments()->sync($relatedIds);
                }
            }
        }
    }
}