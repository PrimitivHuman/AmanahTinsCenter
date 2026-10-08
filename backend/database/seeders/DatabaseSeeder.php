<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\TeamMember;
use App\Models\Appointment;
use App\Models\ClinicSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@amanahtinscenter.com'],
            [
                'name' => 'Administrator ATC',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Clinic Settings
        ClinicSetting::updateOrCreate(
            ['id' => 1],
            [
                'clinic_name' => "Amanah Tin's Center",
                'tagline' => 'Pusat Terapi & Tumbuh Kembang Anak Terpadu',
                'phone' => '+62 717 9101234',
                'whatsapp' => '6282188899900',
                'email' => 'admin@amanahtinscenter.com',
                'address' => 'Jl. Jenderal Sudirman No. 88, Pangkalpinang, Kepulauan Bangka Belitung 33121',
                'maps_url' => 'https://maps.google.com/?q=Pangkalpinang',
                'weekday_hours' => 'Senin - Jumat: 08:00 - 17:00 WIB',
                'weekend_hours' => 'Sabtu: 08:00 - 15:00 WIB (Minggu Libur)',
                'instagram' => '@amanahtinscenter',
                'facebook' => 'Amanah Tins Center',
                'youtube' => 'Amanah Tins Center Official',
                'about_summary' => "Amanah Tin's Center hadir sebagai mitra terpercaya bagi orang tua dalam mengoptimalkan tumbuh kembang anak secara holistik melalui pendekatan terapis profesional berlisensi dan fasilitas berstandar klinis modern.",
            ]
        );

        // 3. Team Members
        $team = [
            [
                'name' => 'dr. Nurul Aini, Sp.A',
                'role' => 'Dokter Spesialis Anak & Konsultan Tumbuh Kembang',
                'specialization' => 'Tumbuh Kembang Pediatrik & Skrining Neurologi',
                'bio' => 'Berpengalaman lebih dari 12 tahun dalam menangani berbagai variasi perkembangan sensorik, motorik, dan komunikasi pada anak usia dini.',
                'experience_years' => '12+ Tahun',
                'certifications' => ['STR Dokter Spesialis', 'Anggota IDAI', 'Sertifikasi Denver II'],
                'image' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&q=80&w=600',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Rahmat Hidayat, S.Tr.Kes (TW)',
                'role' => 'Kepala Terapis Wicara',
                'specialization' => 'Speech Delay, Artikulasi & Gangguan Menelan (Disfagia)',
                'bio' => 'Spesialis terapi wicara anak dengan fokus stimulasi bahasa ekspresif-reseptif serta penanganan keterlambatan bicara berbasis pendekatan keluarga.',
                'experience_years' => '8+ Tahun',
                'certifications' => ['STR IKATWI', 'Certified PECS Level 1', 'Oral Placement Therapy'],
                'image' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&q=80&w=600',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Siti Maulida, S.St.OT',
                'role' => 'Terapis Okupasi & Sensori Integrasi',
                'specialization' => 'Sensory Processing, Kemandirian & Motorik Halus',
                'bio' => 'Terapis okupasi berdedikasi tinggi dengan keahlian dalam perancangan sensory diet dan stimulasi kemandirian aktivitas harian anak.',
                'experience_years' => '7+ Tahun',
                'certifications' => ['STR Ikatan Terapi Okupasi Indonesia', 'Sensory Integration Certified'],
                'image' => 'https://images.unsplash.com/photo-1594824813639-5095d3a51f7b?auto=format&fit=crop&q=80&w=600',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Bambang Prasetyo, S.Ft, Ftr',
                'role' => 'Fisioterapis Pediatrik',
                'specialization' => 'Motorik Kasar, Postur, & Rehabilitasi Fisik Anak',
                'bio' => 'Ahli fisioterapi anak dengan pengalaman rehabilitasi postur, koordinasi gerak, keseimbangan, serta stimulasi motorik kasar pasca fase bayi.',
                'experience_years' => '6+ Tahun',
                'certifications' => ['STR IFI Pediatri', 'Bobath Pediatric Certified'],
                'image' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&q=80&w=600',
                'order' => 4,
                'is_active' => true,
            ]
        ];

        foreach ($team as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }

        // 4. Articles
        $articles = [
            [
                'title' => 'Mengenal Tanda Speech Delay pada Anak Usia 1-3 Tahun',
                'slug' => 'mengenal-tanda-speech-delay-pada-anak-usia-1-3-tahun',
                'category' => 'Terapi Wicara',
                'excerpt' => 'Ketahui tonggak capaian bicara dan bahasa anak serta tanda bahaya (red flags) yang memerlukan evaluasi terapis wicara profesional.',
                'content' => "<p>Keterlambatan bicara atau <em>speech delay</em> adalah salah satu kondisi tumbuh kembang yang paling sering dikhawatirkan oleh orang tua. Mengetahui apakah seorang anak sekadar 'late bloomer' atau memang memerlukan intervensi terapi wicara sangat krusial untuk masa depan komunikasi anak.</p><h3>Kapan Orang Tua Perlu Waspada?</h3><p>Pada usia 12 bulan, anak umumnya sudah mampu mengoceh (babbling) dengan intonasi bervariasi dan menoleh saat namanya dipanggil. Bila anak belum menunjuk benda yang diinginkan pada usia 14-18 bulan, atau belum ada kata bermakna pada usia 2 tahun, konsultasi tumbuh kembang sangat disarankan.</p><p>Intervensi dini memberikan plastisitas otak terbaik sebelum usia 5 tahun. Di Amanah Tin's Center, kami menerapkan evaluasi menyeluruh mencakup fungsi sensori, pendengaran, dan oral-motorik.</p>",
                'author' => 'Rahmat Hidayat, S.Tr.Kes (TW)',
                'image' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&q=80&w=800',
                'read_time' => '5 Menit Baca',
                'is_published' => true,
                'views_count' => 142,
            ],
            [
                'title' => 'Apa Itu Sensori Integrasi dan Mengapa Penting bagi Perilaku Anak?',
                'slug' => 'apa-itu-sensori-integrasi-dan-pentingnya-bagi-anak',
                'category' => 'Sensori Integrasi',
                'excerpt' => 'Pernahkah anak Anda rewel saat mendengar suara blender atau tidak suka mengenakan tekstur baju tertentu? Bisa jadi itu sensivitas sensori.',
                'content' => "<p>Sensori Integrasi (SI) adalah proses neurologis di mana otak memproses dan mengorganisir informasi yang diterima dari panca indera ditambah indera vestibular (keseimbangan) dan proprioseptif (posisi tubuh).</p><p>Ketika anak mengalami kesulitan mengintegrasikan stimulus sensori, anak dapat bereaksi berlebihan (hypersensitive) seperti menutup telinga pada suara pelan, atau justru kurang peka (hyposensitive) sehingga terus bergerak tanpa henti.</p><p>Melalui terapi Sensori Integrasi di ruang sensori khusus berstandar klinis, anak dilatih merespon lingkungan secara adaptif dan terarah.</p>",
                'author' => 'Siti Maulida, S.St.OT',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&q=80&w=800',
                'read_time' => '6 Menit Baca',
                'is_published' => true,
                'views_count' => 98,
            ],
            [
                'title' => '5 Aktivitas di Rumah untuk Melatih Motorik Halus dan Kemandirian Anak',
                'slug' => '5-aktivitas-di-rumah-melatih-motorik-halus',
                'category' => 'Terapi Okupasi',
                'excerpt' => 'Latihan motorik halus tidak harus membosankan. Berikut cara seru melatih jemari si kecil menggunakan benda-benda sederhana di rumah.',
                'content' => "<p>Kekuatan otot tangan dan koordinasi jemari adalah modal penting sebelum anak siap menulis di sekolah. Selain itu, keterampilan ini menentukan apakah anak dapat memegang sendok, mengancing baju, dan mengikat tali sepatu secara mandiri.</p><ol><li><strong>Meremas Plastisin / Playdough:</strong> Meningkatkan kekuatan cengkeraman jari.</li><li><strong>Memindahkan Biji Menggunakan Jepitan:</strong> Melatih pincer grasp yang penting untuk memegang pensil.</li><li><strong>Meronce Manik-manik Besar:</strong> Mengasah koordinasi mata dan tangan.</li><li><strong>Menempel Stiker:</strong> Membiasakan isolasi jari telunjuk dan jempol.</li><li><strong>Membuka dan Menutup Toples:</strong> Memperkuat sendi pergelangan tangan.</li></ol>",
                'author' => 'Siti Maulida, S.St.OT',
                'image' => 'https://images.unsplash.com/photo-1596464716127-f2a829822301?auto=format&fit=crop&q=80&w=800',
                'read_time' => '4 Menit Baca',
                'is_published' => true,
                'views_count' => 215,
            ],
            [
                'title' => 'Fisioterapi Pediatrik: Membantu Anak Mencapai Tonggak Motorik Kasar',
                'slug' => 'fisioterapi-pediatrik-membantu-tonggak-motorik-kasar',
                'category' => 'Fisioterapi Pediatrik',
                'excerpt' => 'Pelajari bagaimana fisioterapi anak membantu si kecil yang terlambat tengkurap, merangkak, duduk, atau berjalan dengan latihan terukur.',
                'content' => "<p>Motorik kasar melibatkan otot-otot besar tubuh yang bertanggung jawab untuk mobilitas dasar: berguling, duduk tegak tanpa sandaran, merangkak, hingga berjalan dan berlari seimbang.</p><p>Fisioterapi pediatrik di Amanah Tin's Center dirancang dengan pendekatan bermain (play therapy) sehingga si kecil tidak merasa sedang berobat atau dipaksa, melainkan menikmati setiap fase eksplorasi geraknya.</p>",
                'author' => 'Bambang Prasetyo, S.Ft, Ftr',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&q=80&w=800',
                'read_time' => '5 Menit Baca',
                'is_published' => true,
                'views_count' => 76,
            ],
        ];

        foreach ($articles as $art) {
            Article::updateOrCreate(
                ['slug' => $art['slug']],
                $art
            );
        }

        // 5. Sample Appointments
        $appointments = [
            [
                'parent_name' => 'Bunda Anisa Fitri',
                'child_name' => 'Kenzi Alvaro',
                'child_age' => '2 Tahun 8 Bulan',
                'phone' => '081234567890',
                'email' => 'anisa.fitri@example.com',
                'service_type' => 'Terapi Wicara',
                'preferred_date' => now()->addDays(2)->format('Y-m-d'),
                'preferred_time' => 'Pagi (09:00 - 12:00)',
                'notes' => 'Anak belum bisa mengucapkan 2 kata berpola subjek predikat, sering tantrum jika keinginannya tidak dimengerti.',
                'status' => 'pending',
                'admin_notes' => null,
            ],
            [
                'parent_name' => 'Ayah Hendra Wijaya',
                'child_name' => 'Arkan Putra Wijaya',
                'child_age' => '4 Tahun',
                'phone' => '082198765432',
                'email' => 'hendra.w@example.com',
                'service_type' => 'Sensori Integrasi',
                'preferred_date' => now()->addDays(3)->format('Y-m-d'),
                'preferred_time' => 'Siang (13:00 - 17:00)',
                'notes' => 'Anak takut berjalan tanpa alas kaki di rumput/pasir dan hipersensitif terhadap suara keras.',
                'status' => 'confirmed',
                'admin_notes' => 'Sudah dijadwalkan dengan Terapis Siti Maulida pada jam 14:00.',
            ],
            [
                'parent_name' => 'Ibu Ratna Dewi',
                'child_name' => 'Ayla Shakila',
                'child_age' => '3 Tahun',
                'phone' => '085277889900',
                'email' => 'ratna.dewi@example.com',
                'service_type' => 'Terapi Okupasi',
                'preferred_date' => now()->subDays(1)->format('Y-m-d'),
                'preferred_time' => 'Pagi (09:00 - 12:00)',
                'notes' => 'Skrining kesiapan motorik halus dan koordinasi dua tangan.',
                'status' => 'completed',
                'admin_notes' => 'Asesmen awal telah selesai, rekomendasi paket terapi 8 sesi.',
            ],
        ];

        foreach ($appointments as $apt) {
            Appointment::updateOrCreate(
                ['child_name' => $apt['child_name']],
                $apt
            );
        }
    }
}
