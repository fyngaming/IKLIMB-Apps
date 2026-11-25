<?php

namespace Database\Seeders;

use App\Models\AgendaReuni;
use App\Models\AgendaRsvp;
use App\Models\AlumniEducation;
use App\Models\AlumniProfile;
use App\Models\DonasiPenyaluran;
use App\Models\DonasiProgram;
use App\Models\ForumAngkatan;
use App\Models\InfoLowonganUsaha;
use App\Models\KabarPondok;
use App\Models\KajianMateri;
use App\Models\Kunjungan;
use App\Models\MasterSantri;
use App\Models\PermohonanDokumen;
use App\Models\SaranMasukan;
use App\Models\TanyaUstaz;
use App\Models\TracerStudy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Master Santri Records
        $santri1 = MasterSantri::create([
            'nis' => 'PPIB-2015-089',
            'nama_lengkap' => 'Ahmad Rifai',
            'angkatan' => 'Angkatan 10 (2015)',
            'jenjang_pondok' => 'Madrasah Aliyah (MA)',
            'tahun_masuk' => 2012,
            'tahun_lulus' => 2015,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1997-05-14',
            'nama_wali' => 'H. Suryadi',
            'status_kelulusan' => 'Lulus',
            'is_registered' => true,
        ]);

        $santri2 = MasterSantri::create([
            'nis' => 'PPIB-2016-042',
            'nama_lengkap' => 'Rizky Santoso',
            'angkatan' => 'Angkatan 11 (2016)',
            'jenjang_pondok' => 'Madrasah Aliyah (MA)',
            'tahun_masuk' => 2013,
            'tahun_lulus' => 2016,
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1998-08-20',
            'nama_wali' => 'Drs. H. Mulyana',
            'status_kelulusan' => 'Lulus',
            'is_registered' => true,
        ]);

        // Unregistered santri records ready to test new registration
        MasterSantri::create([
            'nis' => 'PPIB-2018-102',
            'nama_lengkap' => 'Fadhil Al-Baqir',
            'angkatan' => 'Angkatan 13 (2018)',
            'jenjang_pondok' => 'Madrasah Aliyah (MA)',
            'tahun_masuk' => 2015,
            'tahun_lulus' => 2018,
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2000-01-12',
            'nama_wali' => 'H. Syamsuddin',
            'status_kelulusan' => 'Lulus',
            'is_registered' => false,
        ]);

        MasterSantri::create([
            'nis' => 'PPIB-2019-215',
            'nama_lengkap' => 'Muhammad Zaky Pratama',
            'angkatan' => 'Angkatan 14 (2019)',
            'jenjang_pondok' => 'Madrasah Tsanawiyah (MTs)',
            'tahun_masuk' => 2016,
            'tahun_lulus' => 2019,
            'tempat_lahir' => 'Semarang',
            'tanggal_lahir' => '2004-03-25',
            'nama_wali' => 'Bambang Irawan',
            'status_kelulusan' => 'Lulus',
            'is_registered' => false,
        ]);

        MasterSantri::create([
            'nis' => 'PPIB-2020-044',
            'nama_lengkap' => 'Syahrul Ramadhan',
            'angkatan' => 'Angkatan 15 (2020)',
            'jenjang_pondok' => 'Takhasus Tahfizh',
            'tahun_masuk' => 2017,
            'tahun_lulus' => 2020,
            'tempat_lahir' => 'Yogyakarta',
            'tanggal_lahir' => '2002-11-09',
            'nama_wali' => 'H. Muhsin',
            'status_kelulusan' => 'Lulus',
            'is_registered' => false,
        ]);

        // 2. Seed Users & Profiles
        // Super Admin
        $admin = User::create([
            'name' => 'KH. Abdullah Hakim (Admin PPIB)',
            'no_wa' => '081234567890',
            'email' => 'admin@ppib.org',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        // Koordinator IKLIMB
        $koordinator = User::create([
            'name' => 'Ust. Fikri Maulana, M.Pd.',
            'no_wa' => '081234567891',
            'email' => 'koordinator@ppib.org',
            'password' => Hash::make('password'),
            'role' => 'koordinator',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        AlumniProfile::create([
            'user_id' => $koordinator->id,
            'qr_identity_token' => 'IKLIMB-2026-KOORD01',
            'privacy_settings' => [
                'show_wa' => true,
                'show_address' => false,
                'show_job' => true,
                'show_education' => true,
            ],
        ]);

        // Keamanan Pos Satpam
        $keamanan = User::create([
            'name' => 'Pak Bambang (Pos Keamanan PPIB)',
            'no_wa' => '081234567892',
            'email' => 'satpam@ppib.org',
            'password' => Hash::make('password'),
            'role' => 'keamanan',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        // Alumni Baru (Menunggu Verifikasi)
        $alumniBaru = User::create([
            'name' => 'Rizky Santoso',
            'no_wa' => '081234567893',
            'email' => 'rizky@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
            'status' => 'menunggu_verifikasi',
            'is_first_login' => true,
        ]);

        AlumniProfile::create([
            'user_id' => $alumniBaru->id,
            'master_santri_id' => $santri2->id,
            'nis' => $santri2->nis,
            'qr_identity_token' => 'IKLIMB-2026-RIZKY01',
            'angkatan' => $santri2->angkatan,
            'jenjang_pondok' => $santri2->jenjang_pondok,
            'tempat_lahir' => $santri2->tempat_lahir,
            'tanggal_lahir' => $santri2->tanggal_lahir,
            'kabupaten_kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'negara' => 'Indonesia',
            'privacy_settings' => [
                'show_wa' => true,
                'show_address' => false,
                'show_job' => true,
                'show_education' => true,
            ],
        ]);

        // Alumni Aktif Terverifikasi & Sudah Onboarding
        $alumniAktif = User::create([
            'name' => 'Ahmad Rifai, S.Kom.',
            'no_wa' => '081234567894',
            'email' => 'ahmad.rifai@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
            'status' => 'aktif',
            'is_first_login' => false,
        ]);

        $profileAktif = AlumniProfile::create([
            'user_id' => $alumniAktif->id,
            'master_santri_id' => $santri1->id,
            'nis' => $santri1->nis,
            'qr_identity_token' => 'IKLIMB-2026-AHMAD01',
            'angkatan' => $santri1->angkatan,
            'jenjang_pondok' => $santri1->jenjang_pondok,
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1997-05-14',
            'status_pernikahan' => 'Menikah',
            'alamat_lengkap' => 'Jl. Tebet Timur Dalam No. 15, Jakarta Selatan',
            'kabupaten_kota' => 'Jakarta Selatan',
            'provinsi' => 'DKI Jakarta',
            'negara' => 'Indonesia',
            'latitude' => -6.2297,
            'longitude' => 106.8467,
            'pekerjaan_lembaga' => 'PT. Barakah Solusi Informatika',
            'pekerjaan_divisi' => 'Teknologi Informasi (IT)',
            'pekerjaan_jabatan' => 'Senior Frontend Architect',
            'bio' => 'Alumni angkatan 10 PPIB, aktif berkhidmat dalam jejaring teknologi santri.',
            'privacy_settings' => [
                'show_wa' => true,
                'show_address' => true,
                'show_job' => true,
                'show_education' => true,
            ],
        ]);

        AlumniEducation::create([
            'alumni_profile_id' => $profileAktif->id,
            'jenjang' => 'S1',
            'nama_universitas' => 'UIN Syarif Hidayatullah Jakarta',
            'program_studi' => 'Teknik Informatika',
            'tahun_masuk' => 2015,
            'tahun_lulus' => 2019,
            'gelar' => 'S.Kom.',
        ]);

        // 3. Seed Kunjungan
        // Active Visit with QR token
        Kunjungan::create([
            'user_id' => $alumniAktif->id,
            'kode_kunjungan' => 'KNJ-'.date('Ymd').'-001',
            'qr_visit_token' => 'VISIT-TEST-001',
            'tanggal_kunjungan' => date('Y-m-d'),
            'jam_kunjungan' => '10:00:00',
            'tujuan' => 'Silaturahmi dengan Ustaz',
            'pihak_ditemui' => 'KH. Abdullah Hakim (Pimpinan Pondok)',
            'jumlah_rombongan' => 3,
            'kendaraan' => 'Mobil Toyota Innova (B 1234 PPI)',
            'is_menginap' => false,
            'catatan_alumni' => 'Membawa bingkisan kitab tafsir untuk perpustakaan pondok.',
            'status' => 'disetujui',
            'catatan_petugas' => 'Dipersilakan parkir di halaman depan Gedung Utama.',
        ]);

        Kunjungan::create([
            'user_id' => $alumniAktif->id,
            'kode_kunjungan' => 'KNJ-'.date('Ymd', strtotime('+3 days')).'-002',
            'qr_visit_token' => 'VISIT-TEST-002',
            'tanggal_kunjungan' => date('Y-m-d', strtotime('+3 days')),
            'jam_kunjungan' => '14:00:00',
            'tujuan' => 'Menjenguk Santri',
            'pihak_ditemui' => 'Santri Fajar (Kelas 2 MTs)',
            'jumlah_rombongan' => 2,
            'kendaraan' => 'Motor Honda Vario (B 5678 KLM)',
            'is_menginap' => false,
            'status' => 'menunggu',
        ]);

        // 4. Seed Kabar Pondok
        KabarPondok::create([
            'user_id' => $admin->id,
            'judul' => 'Penerimaan Santri Baru (PSB) Gelombang 1 Dibuka: Kuota Terbatas',
            'slug' => 'psb-gelombang-1-dibuka',
            'kategori' => 'Pengumuman',
            'ringkasan' => 'Pondok Pesantren PPIB resmi membuka pendaftaran santri baru jalur reguler dan jalur khusus alumni dengan kuota terbatas.',
            'konten' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nPondok Pesantren PPIB secara resmi membuka Penerimaan Santri Baru (PSB) Tahun Ajaran 2027/2028. Khusus bagi alumni IKLIMB, tersedia jalur rekomendasi dengan prioritas verifikasi berkas dan tes tahfizh.\n\nPersyaratan pendaftaran meliputi fotokopi ijazah, rapor, pas foto, dan kartu keluarga. Pendaftaran online dapat diakses melalui portal IKLIMB Apps pada menu PSB Jalur Alumni.",
            'gambar' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80',
            'is_pinned' => true,
            'published_at' => now()->subDays(2),
            'views_count' => 142,
        ]);

        KabarPondok::create([
            'user_id' => $admin->id,
            'judul' => 'Milad PPIB ke-25 & Reuni Akbar 10 Tahun: Menjalin Ukhuwah Membangun Peradaban',
            'slug' => 'milad-ppib-25-reuni-akbar',
            'kategori' => 'Agenda',
            'ringkasan' => 'Rangkaian temu akbar alumni seluruh angkatan yang akan diselenggarakan di Aula Utama Kampus PPIB.',
            'konten' => "Mari meriahkan agenda Reuni Akbar 10 Tahun dan Peringatan Seperempat Abad Kiprah PPIB. Kegiatan akan diisi dengan Khatmil Qur'an, Temu Asatizah Sepuh, Bazar Usaha Alumni, dan Musyawarah Nasional Pengurus IKLIMB.\n\nPastikan alumni melakukan konfirmasi kehadiran melalui fitur RSVP di IKLIMB Apps.",
            'gambar' => 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?auto=format&fit=crop&w=800&q=80',
            'is_pinned' => true,
            'published_at' => now()->subDay(),
            'views_count' => 98,
        ]);

        KabarPondok::create([
            'user_id' => $admin->id,
            'judul' => 'Kunjungan Mahabbah Delegasi Ulama Al-Azhar Kairo ke Pesantren PPIB',
            'slug' => 'kunjungan-ulama-al-azhar-kairo',
            'kategori' => 'Berita',
            'ringkasan' => 'Delegasi Majelis Hukama Al-Muslimin meninjau program sanad tahfizh dan pembelajaran kitab kuning di PPIB.',
            'konten' => 'Alhamdulillah, pada hari Rabu kemarin, PPIB menerima kunjungan istimewa delegasi dari Universitas Al-Azhar Kairo Mesir. Kunjungan ini berfokus pada penguatan kurikulum bahasa Arab dan peluang beasiswa studi lanjut bagi santri dan alumni PPIB.',
            'gambar' => 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80',
            'is_pinned' => false,
            'published_at' => now()->subHours(6),
            'views_count' => 74,
        ]);

        // 5. Seed Permohonan Dokumen
        PermohonanDokumen::create([
            'user_id' => $alumniAktif->id,
            'nomor_permohonan' => 'DOK-'.date('Ym').'-001',
            'jenis_dokumen' => 'Legalisasi Ijazah Pondok',
            'keperluan' => 'Pendaftaran beasiswa program pascasarjana Magister (S2) Luar Negeri',
            'jumlah_eksemplar' => 3,
            'metode_pengambilan' => 'Ambil Langsung di Pos/TU',
            'status' => 'diproses',
            'catatan_admin' => 'Ijazah sedang dalam proses tanda tangan Pimpinan Pondok.',
        ]);

        // 6. Seed Tracer Study
        TracerStudy::create([
            'user_id' => $alumniAktif->id,
            'tahun_survey' => date('Y'),
            'status_kiprah' => 'Bekerja',
            'nama_instansi' => 'PT. Barakah Solusi Informatika',
            'pendapatan_rata_rata' => 'Rp 5 - 10 Juta',
            'keselarasan_ilmu' => 'Sangat Selaras',
            'kontribusi_pondok_feedback' => 'Pondok memberikan fondasi adab dan disiplin yang sangat penting di dunia kerja industri.',
            'saran_kurikulum' => 'Perbanyak pelatihan coding dan literasi digital sejak jenjang Madrasah Aliyah.',
        ]);

        // 7. Seed Donasi Programs & Penyaluran
        $prog1 = DonasiProgram::create([
            'judul' => 'Wakaf Pembangunan Asrama Santri Tahfizh Lantai 3',
            'slug' => 'wakaf-asrama-tahfizh-lantai-3',
            'kategori' => 'Wakaf Pembangunan',
            'target_dana' => 500000000,
            'dana_terkumpul' => 325000000,
            'tanggal_berakhir' => date('Y-12-31'),
            'deskripsi' => 'Penggalangan dana wakaf produktif untuk perluasan kamar santri penghafal Al-Qur\'an 30 Juz di asrama pusat PPIB.',
            'is_aktif' => true,
        ]);

        DonasiProgram::create([
            'judul' => 'Beasiswa Penuh Santri Yatim & Dhuafa Berprestasi',
            'slug' => 'beasiswa-santri-yatim-dhuafa',
            'kategori' => 'Beasiswa Santri',
            'target_dana' => 150000000,
            'dana_terkumpul' => 98500000,
            'tanggal_berakhir' => date('Y-12-31'),
            'deskripsi' => 'Bantuan SPP, seragam, dan uang saku santri yatim penghafal Qur\'an berprestasi.',
            'is_aktif' => true,
        ]);

        DonasiPenyaluran::create([
            'donasi_program_id' => $prog1->id,
            'judul_penyaluran' => 'Pengecoran Balok & Tiang Asrama Lantai 3',
            'nominal_disalurkan' => 75000000,
            'tanggal_penyaluran' => date('Y-m-d', strtotime('-5 days')),
            'laporan_kegiatan' => 'Pekerjaan struktur pengecoran beton lantai 3 telah selesai dikerjakan bersama tim kontraktor sipil.',
        ]);

        // 8. Seed Agenda Reuni
        $agenda1 = AgendaReuni::create([
            'judul' => 'Silaturahmi Akbar Alumni & Buka Puasa Bersama PPIB',
            'slug' => 'silaturahmi-akbar-buka-bersama',
            'kategori' => 'Reuni Akbar',
            'tanggal_mulai' => date('Y-m-d 16:00:00', strtotime('+14 days')),
            'tanggal_selesai' => date('Y-m-d 20:30:00', strtotime('+14 days')),
            'lokasi' => 'Masjid Jami\' Pondok Pesantren PPIB',
            'biaya_donasi' => 50000,
            'kuota' => 200,
            'deskripsi' => 'Agenda temu kangen lintas angkatan, tausiyah oleh Pengasuh Pondok, dan doa bersama untuk kejayaan umat.',
            'kontak_person' => 'Ust. Fikri (081234567891)',
        ]);

        AgendaRsvp::create([
            'agenda_reuni_id' => $agenda1->id,
            'user_id' => $alumniAktif->id,
            'status_kehadiran' => 'Hadir',
            'jumlah_tamu' => 2,
            'catatan' => 'Insya Allah hadir bersama keluarga.',
        ]);

        // 9. Seed Info Lowongan & Usaha Alumni
        InfoLowonganUsaha::create([
            'user_id' => $alumniAktif->id,
            'tipe' => 'lowongan_kerja',
            'judul' => 'Dibutuhkan Junior Web Developer (Laravel & Tailwind)',
            'nama_perusahaan_usaha' => 'PT. Barakah Solusi Informatika',
            'bidang_industri' => 'Teknologi Informasi',
            'deskripsi' => 'Membuka kesempatan bagi adik-adik alumni PPIB yang memiliki kemampuan dasar PHP/Laravel untuk bergabung di tim pengembangan software kami.',
            'lokasi' => 'Jakarta Selatan (Hybrid)',
            'kontak_wa' => '081234567894',
            'is_verified' => true,
        ]);

        InfoLowonganUsaha::create([
            'user_id' => $admin->id,
            'tipe' => 'kebutuhan_dai',
            'judul' => 'Peluang Khidmat Guru Tahfizh & Bahasa Arab Pesantren',
            'nama_perusahaan_usaha' => 'Pesantren Cabang PPIB Bogor',
            'bidang_industri' => 'Pendidikan Islam',
            'deskripsi' => 'Dibutuhkan 2 orang alumni mutakhorrijin yang hafal Al-Qur\'an minimal 15 juz dan fasih berbahasa Arab untuk mengajar di asrama cabang.',
            'lokasi' => 'Bogor, Jawa Barat',
            'kontak_wa' => '081234567890',
            'is_verified' => true,
        ]);

        // 10. Seed Forum Angkatan
        ForumAngkatan::create([
            'angkatan' => 'Angkatan 10 (Al-Fatih)',
            'tahun_lulus' => 2015,
            'nama_koordinator' => 'Ahmad Rifai, S.Kom.',
            'no_wa_koordinator' => '081234567894',
            'link_wa_group' => 'https://chat.whatsapp.com/demo-iklimb-angkatan10',
            'keterangan' => 'Grup resmi alumni kelulusan MA PPIB tahun 2015.',
        ]);

        ForumAngkatan::create([
            'angkatan' => 'Angkatan 11 (As-Shiddiq)',
            'tahun_lulus' => 2016,
            'nama_koordinator' => 'Rizky Santoso',
            'no_wa_koordinator' => '081234567893',
            'link_wa_group' => 'https://chat.whatsapp.com/demo-iklimb-angkatan11',
            'keterangan' => 'Grup silaturahmi santri lulusan tahun 2016.',
        ]);

        // 11. Seed Kajian & Materi
        KajianMateri::create([
            'judul' => 'Tafsir Surat Al-Hujurat: Etika Ukhuwah & Menjaga Persaudaraan Santri',
            'slug' => 'tafsir-al-hujurat-etika-ukhuwah',
            'kategori' => 'Tafsir & Hadis',
            'nama_narasumber' => 'KH. Abdullah Hakim (Pimpinan PPIB)',
            'media_type' => 'youtube',
            'media_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'ringkasan' => 'Kajian mendalam adab pergaulan, tabayyun kabar berita, dan larangan merendahkan sesama muslim.',
            'konten' => 'Pembahasan ayat demi ayat tentang pondasi persaudaraan iman yang melampaui sekat suku, angkatan, dan latar belakang keduniaan.',
            'published_at' => now()->subDays(3),
        ]);

        // 12. Seed Tanya Ustaz
        TanyaUstaz::create([
            'user_id' => $alumniAktif->id,
            'kategori_keilmuan' => 'Muamalah & Bisnis',
            'judul_pertanyaan' => 'Hukum Transaksi Paylater & Skema Cicilan Tanpa Bunga Bank Konvensional',
            'pertanyaan' => 'Assalamu\'alaikum Ustaz. Bagaimana hukumnya menggunakan fitur paylater belanja online jika kita selalu membayar tepat waktu sebelum denda jatuh tempo?',
            'is_anonim' => false,
            'status' => 'dijawab',
            'dijawab_oleh' => $admin->id,
            'nama_ustaz_penjawab' => 'Dewan Syariah PPIB',
            'jawaban' => 'Wa\'alaikumussalam Warahmatullahi Wabarakatuh. Mayoritas ulama kontemporer menghimbau untuk menghindari akad yang menyertakan klausul denda keterlambatan (riba nasiah), meskipun pengguna berniat membayar tepat waktu. Lebih dianjurkan menggunakan akad murabahah syariah murni.',
            'answered_at' => now()->subDay(),
            'is_public' => true,
        ]);

        // 13. Seed Saran & Masukan
        SaranMasukan::create([
            'user_id' => $alumniAktif->id,
            'topik' => 'Pengembangan Pondok & Sarpras',
            'isi_aspirasi' => 'Mohon dipertimbangkan pengadaan fasilitas laboratorium komputer dan coding santri di pesantren agar santri melek teknologi digital islami.',
            'status' => 'ditindaklanjuti',
            'tanggapan_pondok' => 'Jazakumullah khairan sarannya. Alhamdulillah saat ini sedang disiapkan renovasi ruang Lab Komputer 30 unit PC di gedung baru.',
            'ditanggapi_at' => now()->subHours(12),
        ]);
    }
}
