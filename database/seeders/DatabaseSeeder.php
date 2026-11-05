<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Admin;
use App\Models\Committee;
use App\Models\Member;
use App\Models\OneGateLink;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SEED ADMINS
        if (Admin::count() === 0) {
            Admin::create([
                'id' => (string) Str::uuid(),
                'name' => 'Admin Resimen Taruna',
                'email' => 'resimen@stmkg.ac.id',
                'password_hash' => Hash::make('arthawijaya26'),
                'role' => 'superadmin',
            ]);
        }

        // 2. SEED MEMBERS
        if (Member::count() === 0) {
            $memberList = [
                // Komandan Utama
                ['name' => 'Riza Bina Bhakti Adinegara', 'role' => 'Komandan Resimen', 'title' => 'Resimen Taruna', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/komandan.png', 'order_index' => 1],
                // Batalion & Pimpinan
                ['name' => 'Hendro Samuel Kaparang', 'role' => 'Komandan', 'title' => 'Batalion 1', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/hendro.png', 'order_index' => 2],
                ['name' => 'Putra Abdurrazzaq A. Wahid', 'role' => 'Sekretaris', 'title' => 'Utama', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/putra.png', 'order_index' => 3],
                ['name' => 'Iman Nurimansyah', 'role' => 'Komandan', 'title' => 'Batalion 2', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/iman.png', 'order_index' => 4],
                // Deputi & Poltar
                ['name' => 'Fahri Kuncoro', 'role' => 'Deputi I', 'title' => 'Kerohanian', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/fahri.png', 'order_index' => 5],
                ['name' => 'James Eleon Steven Brice Harun', 'role' => 'Komandan', 'title' => 'Polisi Taruna', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/james.png', 'order_index' => 6],
                ['name' => 'Michael Alessandro Delpi Dange', 'role' => 'Deputi II', 'title' => 'Kesenian dan Olahraga', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/delpi.png', 'order_index' => 7],
                // Deputi III & Kompi
                ['name' => 'Satria Sabilah Hidaist', 'role' => 'Deputi III', 'title' => 'Pengabdian Masyarakat', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/satria.png', 'order_index' => 8],
                ['name' => 'Gerald Heaston Junior Mbatu', 'role' => 'Komandan', 'title' => 'Kompi A', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/gerald.png', 'order_index' => 9],
                ['name' => 'Derik Nara Kaha', 'role' => 'Deputi IV', 'title' => 'Keilmuan', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/derik.png', 'order_index' => 10],
                // Kompi B, C, D
                ['name' => 'Galang Prabowo Sugeng', 'role' => 'Komandan', 'title' => 'Kompi B', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/galang.png', 'order_index' => 11],
                ['name' => 'Prayoga Pandapotan Simanjuntak', 'role' => 'Komandan', 'title' => 'Kompi C', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/paryoga.png', 'order_index' => 12],
                ['name' => 'Zulfitrah Mokoginta', 'role' => 'Komandan', 'title' => 'Kompi D', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/zulfitrah.png', 'order_index' => 13],
                // Operasional & Unit
                ['name' => 'Marianus Carol Jehadun', 'role' => 'Kepala Unit', 'title' => 'Operasional Poltar', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/marianus.png', 'order_index' => 14],
                ['name' => 'Dila Binsari Rumadaul', 'role' => 'Komandan', 'title' => 'Karate', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/dila.png', 'order_index' => 15],
                ['name' => 'Muhammad Ikul Yassar Iliyas', 'role' => 'Kepala Unit', 'title' => 'Kesekretariatan Poltar', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/muhammad.png', 'order_index' => 16],
                // Marching Band, Passus, Padus
                ['name' => 'Hendra Murad Suwakul', 'role' => 'Komandan', 'title' => 'Marching Band', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/hendra.png', 'order_index' => 17],
                ['name' => 'Dhanu Prakoso', 'role' => 'Komandan', 'title' => 'Pasukan Khusus', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/dhanu.png', 'order_index' => 18],
                ['name' => 'Gabriel Yawimano Wanma', 'role' => 'Komandan', 'title' => 'Paduan Suara', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/gabriel.png', 'order_index' => 19],
                // IPTEK & Bidang
                ['name' => 'La Ode Ashamad Nusriah', 'role' => 'Komandan', 'title' => 'IPTEK dan Jurnalistik', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/laode.png', 'order_index' => 20],
                ['name' => 'Jalaludin Akbar Lambuo', 'role' => 'Kepala Bidang', 'title' => 'ALENSA', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/jalaludin.png', 'order_index' => 21],
                ['name' => 'Muhammad Akbar Darmawan', 'role' => 'Kepala Bidang', 'title' => 'Olahraga', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/muh akbar.png', 'order_index' => 22],
                ['name' => 'Javiero Revando Skivo Lantang', 'role' => 'Kepala Bidang', 'title' => 'KRESYA', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/javiero.png', 'order_index' => 23],
                ['name' => 'Fernanda Radhya Arya Siregar', 'role' => 'Kepala Bidang', 'title' => 'ITARSI', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/fernanda.png', 'order_index' => 24],
                ['name' => 'Prima Panggalo Allolinggi', 'role' => 'Kepala Bidang', 'title' => 'ALENSA', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/prima.png', 'order_index' => 25],
                ['name' => 'Gracesylla Octavine Puji R.', 'role' => 'Kepala Bidang', 'title' => 'ITM', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/gracesylla.png', 'order_index' => 26],
                ['name' => 'Ninda Aulia', 'role' => 'Kepala Bidang', 'title' => 'ITK', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/ninda.png', 'order_index' => 27],
                ['name' => 'Tazkia Ramadhani', 'role' => 'Kepala Bidang', 'title' => 'ITG', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/tazkia.png', 'order_index' => 28],
                ['name' => 'Nada Naurah Rumaday', 'role' => 'Kepala Bidang', 'title' => 'Taruna STMKG Mengajar', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/nada.png', 'order_index' => 29],
                ['name' => 'Lira Wandik', 'role' => 'Kepala Bidang', 'title' => 'WANASETYA', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/lira.png', 'order_index' => 30],
                ['name' => 'Yuan Zalfa Tanggahma', 'role' => 'Kepala Bidang', 'title' => 'Kesehatan', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/yuan.png', 'order_index' => 31],
                ['name' => 'Muhammad Syaifullah Arif', 'role' => 'Kepala Bidang', 'title' => 'Rohani Islam', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/muh syaifullah.png', 'order_index' => 32],
                ['name' => 'Geth Gabriel Vellon Komul', 'role' => 'Kepala Bidang', 'title' => 'Rohani Kristen', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/geth.png', 'order_index' => 33],
                ['name' => 'Gabriela Alexandria F. Gusfa', 'role' => 'Kepala Bidang', 'title' => 'Rohani Kristen', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/gabriela.png', 'order_index' => 34],
                ['name' => 'Putu Bagus Paramanandana', 'role' => 'Kepala Bidang', 'title' => 'Rohani Hindu', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/putu.png', 'order_index' => 35],
            ];

            foreach ($memberList as $m) {
                Member::create($m);
            }
        }

        // 3. SEED ACTIVITIES
        if (Activity::count() === 0) {
            Activity::create([
                'id' => 'pelantikan-komandan-2026-diamond',
                'title' => 'PELANTIKAN KOMANDAN RESIMEN TARUNA PERIODE 2026',
                'category' => 'upacara',
                'event_date' => '2026-01-12',
                'location' => 'Auditorium Utama STMKG, Tangerang Selatan',
                'summary' => 'Momen sakral pelantikan dan pengukuhan Komandan Resimen Taruna STMKG Periode 2026 bersama jajaran Kabinet Artha Wijaya.',
                'description' => 'Upacara Pelantikan Komandan Resimen Taruna Sekolah Tinggi Meteorologi Klimatologi dan Geofisika (STMKG) Periode 2026 berlangsung dengan khidmat dan penuh rasa tanggung jawab. Bertempat di Auditorium Utama STMKG, prosesi ini menandai babak baru estafet kepemimpinan resimen di bawah naungan Kabinet Artha Wijaya.',
                'template_type' => 'diamond',
                'cover_photo_url' => '/assets/gallery/pelantikan_diamond.png',
                'photos' => [
                    'badgeCategory' => 'Upacara Resmi',
                    'cabinetTitle' => 'KABINET ARTHA WIJAYA',
                    'dateRibbon' => '12 JANUARI 2026',
                    'featured' => true,
                    'titleLines' => [
                        ['text' => 'PELANTIKAN', 'highlight' => 'P'],
                        ['text' => 'KOMANDAN', 'highlight' => 'K'],
                        ['text' => 'RESIMEN TARUNA', 'highlight' => 'R', 'highlight2' => 'T'],
                        ['text' => 'PERIODE 2026', 'highlight' => 'P'],
                    ],
                    'diamondPhotos' => [
                        'center' => [
                            'url' => '/assets/gallery/ceremony_insignia.jpg',
                            'fallback' => '/assets/coverkomandan.png',
                            'title' => 'Penyematan Tanda Pangkat & Jabatan',
                            'subtitle' => 'Momen sakral penyematan evolet komandan oleh Pembina STMKG',
                        ],
                        'topLeft' => [
                            'url' => '/assets/gallery/ceremony_signing.jpg',
                            'fallback' => '/assets/coverkomandan.png',
                            'title' => 'Penandatanganan Naskah Jabatan',
                            'subtitle' => 'Komandan menandatangani berita acara serah terima',
                        ],
                        'topRight' => [
                            'url' => '/assets/gallery/ceremony_sk.jpg',
                            'fallback' => '/assets/coverkomandan.png',
                            'title' => 'Pembacaan Naskah Pelantikan',
                            'subtitle' => 'Pembacaan Surat Keputusan oleh inspektur upacara',
                        ],
                        'bottomLeft' => [
                            'url' => '/assets/gallery/ceremony_penyematan.jpg',
                            'fallback' => '/assets/coverkomandan.png',
                            'title' => 'Penyerahan Tongkat Komando',
                            'subtitle' => 'Simbol amanah dan tanggung jawab memimpin Resimen',
                        ],
                        'bottomRight' => [
                            'url' => '/assets/gallery/ceremony_pataka.jpg',
                            'fallback' => '/assets/coverkomandan.png',
                            'title' => 'Penyerahan Pataka Resimen Taruna',
                            'subtitle' => 'Penghormatan terhadap panji kebesaran STMKG',
                        ],
                    ],
                    'instagram' => '@resimen.stmkg',
                    'website' => 'resimen.stmkg.ac.id',
                ],
            ]);

            Activity::create([
                'id' => 'pelantikan-komandan-2026-grid',
                'title' => 'Pelantikan Komandan Resimen Taruna',
                'category' => 'upacara',
                'event_date' => '2026-01-12',
                'location' => 'Gedung Serbaguna STMKG',
                'summary' => 'Arsip visual 4 momen krusial pelantikan: pembacaan naskah, penyematan tanda pangkat, ikrar sumpah, dan penyerahan pataka kehormatan.',
                'description' => 'Setiap tahapan prosesi pelantikan membawa nilai luhur disiplin, loyalitas, dan integritas taruna STMKG. Dari pembacaan sumpah hingga penyerahan bendera pataka resimen, seluruh rangkaian terdokumentasi rapi dalam arsip resmi ini.',
                'template_type' => 'grid',
                'cover_photo_url' => '/assets/gallery/pelantikan_grid.jpg',
                'photos' => [
                    'badgeCategory' => 'Dokumentasi Khidmat',
                    'subtitle' => 'Dokumentasi Lengkap 4 Tahapan Upacara Pengukuhan',
                    'dateRibbon' => '12 JANUARI 2026',
                    'featured' => true,
                    'gridPhotos' => [
                        [
                            'url' => '/assets/gallery/ceremony_sk.jpg',
                            'title' => '1. Pembacaan Surat Keputusan',
                            'caption' => 'Inspektur upacara membacakan SK pengangkatan pengurus Resimen Taruna 2026.',
                        ],
                        [
                            'url' => '/assets/gallery/ceremony_penyematan.jpg',
                            'title' => '2. Penyematan Atribut Komando',
                            'caption' => 'Pengalungan brevet dan tanda kehormatan Komandan Resimen.',
                        ],
                        [
                            'url' => '/assets/gallery/ceremony_signing.jpg',
                            'title' => '3. Penandatanganan Pakta Integritas',
                            'caption' => 'Komitmen mewujudkan Zona Integritas dan kepemimpinan berkarakter.',
                        ],
                        [
                            'url' => '/assets/gallery/ceremony_pataka.jpg',
                            'title' => '4. Penyerahan Panji Pataka STMKG',
                            'caption' => 'Serah terima pataka resimen disaksikan seluruh jajaran civitas akademika.',
                        ],
                    ],
                    'instagram' => '@resimen.stmkg',
                    'website' => 'resimen.stmkg.ac.id',
                ],
            ]);
        }

        // 4. SEED ONE GATE LINKS
        if (OneGateLink::count() === 0) {
            $links = [
                [
                    'title' => 'HF Radar View',
                    'category' => 'layanan',
                    'badge' => 'Monitoring',
                    'type' => 'spreadsheet',
                    'description' => 'Lembar kerja pemantauan dan rekapitulasi data kegiatan Taruna berbasis HF Radar.',
                    'url' => 'https://docs.google.com/spreadsheets/d/1dVqLiLTdAcuMVJW5QAKmOkU1my2DaxjfiLdWwDtLuwc/edit?gid=400844499#gid=400844499',
                    'order_index' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Pemesanan Produk Danus 2026',
                    'category' => 'layanan',
                    'badge' => 'Dana Usaha',
                    'type' => 'form',
                    'description' => 'Formulir pemesanan resmi merchandise dan produk Dana Usaha Resimen Taruna STMKG periode 2026.',
                    'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSd0pcRdSAy8EeiS3_RKZFAjFgpPEsPXD4Kdb6iSrFOV--HAzw/viewform',
                    'order_index' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Materi Sosialisasi',
                    'category' => 'panduan',
                    'badge' => 'Drive Berkas',
                    'type' => 'drive',
                    'description' => 'Kumpulan berkas dan materi presentasi sosialisasi administrasi serta ketarunaan.',
                    'url' => 'https://drive.google.com/drive/folders/1BqmiNd6IJVSFNz8A_yC9g6fp8jRTXAlu',
                    'order_index' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => 'Draft Proposal & LPJ',
                    'category' => 'administrasi',
                    'badge' => 'Template Dokumen',
                    'type' => 'drive',
                    'description' => 'Templat resmi penyusunan proposal kegiatan dan Laporan Pertanggungjawaban (LPJ).',
                    'url' => 'https://drive.google.com/drive/folders/1qcFG7A0e_JEo8rRv_xkBPTl5a83o5XJ1',
                    'order_index' => 4,
                    'is_active' => true,
                ],
                [
                    'title' => 'Draft Surat Ketarunaan',
                    'category' => 'administrasi',
                    'badge' => 'Template Dokumen',
                    'type' => 'drive',
                    'description' => 'Kumpulan templat dan format surat-menyurat resmi Resimen Taruna.',
                    'url' => 'https://drive.google.com/drive/folders/1r1Y4ykXNrrhJzvG_hz7h096-tOAiIWkL',
                    'order_index' => 5,
                    'is_active' => true,
                ],
                [
                    'title' => 'Prosedur Pengajuan Surat',
                    'category' => 'panduan',
                    'badge' => 'SOP Resmi',
                    'type' => 'doc',
                    'description' => 'Panduan dan langkah-langkah tata cara permohonan penerbitan surat ketarunaan.',
                    'url' => 'https://docs.google.com/document/d/12ieRF5fcmk2I52BTp4cGDihCSNBwa4PQC2yb37ClF_k/edit?tab=t.0',
                    'order_index' => 6,
                    'is_active' => true,
                ],
                [
                    'title' => 'Panduan Peminjaman MS Teams',
                    'category' => 'teams',
                    'badge' => 'Petunjuk Teknis',
                    'type' => 'doc',
                    'description' => 'Petunjuk teknis prosedur alur permohonan lisensi/ruang pertemuan Microsoft Teams.',
                    'url' => 'https://docs.google.com/document/d/1V-n0AeGfGPNTC4xBcCD0U-YeBzP2bERnnOjeXgWawJI/edit?tab=t.0',
                    'order_index' => 7,
                    'is_active' => true,
                ],
                [
                    'title' => 'Alur Administrasi Mentar',
                    'category' => 'panduan',
                    'badge' => 'Bagan Alur',
                    'type' => 'doc',
                    'description' => 'Bagan alur dan panduan tahapan pengajuan dokumen surat, proposal, hingga LPJ.',
                    'url' => 'https://docs.google.com/document/d/1IEnND6AC2d3HzeACXYBx5P3PZQ8cjPKXW0D8LzAd31o/edit?tab=t.0#heading=h.l8u1m7bbbgf4',
                    'order_index' => 8,
                    'is_active' => true,
                ],
                [
                    'title' => 'Arsip Surat Perintah Tugas Taruna',
                    'category' => 'arsip',
                    'badge' => 'Rekapitulasi SPT',
                    'type' => 'form',
                    'description' => 'Dokumentasi dan rekapitulasi Surat Perintah Tugas (SPT) Taruna yang telah diterbitkan.',
                    'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSefLz6Bgn00nrkt-RT7vrV4H9wQT0p_hleidPRLriDXjQQRlQ/viewform',
                    'order_index' => 9,
                    'is_active' => true,
                ],
                [
                    'title' => 'Arsip Proposal & LPJ 2025',
                    'category' => 'arsip',
                    'badge' => 'Arsip 2025',
                    'type' => 'form',
                    'description' => 'Kumpulan berkas proposal dan LPJ kegiatan Resimen Taruna periode tahun 2025.',
                    'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSfZMMIEDrFavxtUU4vPxqsSTWK7qiOW4j_J5XNaWCxsr21xxg/viewform',
                    'order_index' => 10,
                    'is_active' => true,
                ],
                [
                    'title' => 'Surat Mentar Periode 2026',
                    'category' => 'administrasi',
                    'badge' => 'Layanan 2026',
                    'type' => 'form',
                    'description' => 'Formulir pengajuan berkas dan rekapitulasi surat-menyurat Resimen Taruna kepengurusan tahun 2026.',
                    'url' => 'https://docs.google.com/forms/d/e/1FAIpQLScyk9Gol4W2vOTf_2e1YPkLrKPt3qmNpzJLrAfQolHulfwBbw/viewform',
                    'order_index' => 11,
                    'is_active' => true,
                ],
                [
                    'title' => 'Form Peminjaman MS Teams',
                    'category' => 'teams',
                    'badge' => 'Layanan Daring',
                    'type' => 'form',
                    'description' => 'Formulir daring untuk mengajukan permohonan penggunaan akun/ruang MS Teams.',
                    'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSeIGJhLTJBb7leBsAi1V7osP5YA3YClKsmXtrCyry4hebAPlw/viewform',
                    'order_index' => 12,
                    'is_active' => true,
                ],
                [
                    'title' => 'Form LPJ Peminjaman MS Teams',
                    'category' => 'teams',
                    'badge' => 'Konfirmasi & LPJ',
                    'type' => 'form',
                    'description' => 'Formulir pelaporan dan konfirmasi setelah selesai menggunakan fasilitas MS Teams.',
                    'url' => 'https://docs.google.com/forms/d/e/1FAIpQLScWTL8ei6SXMGCz_dj3tZg1--Itqec-QV75bJoYhbsIZq8klw/viewform',
                    'order_index' => 13,
                    'is_active' => true,
                ],
            ];

            foreach ($links as $link) {
                OneGateLink::create($link);
            }
        }

        // 5. SEED COMMITTEES (44 Anggota Panitia Kesekretariatan MENTAR 7 Divisi sesuai Halaman About Us)
        if (Committee::count() === 0) {
            $committees = [
                // 1. Sekretaris (2)
                ['division' => 'Sekretaris', 'name' => 'Firjan Manap', 'role' => 'Sekretaris 1', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/firjan.png'],
                ['division' => 'Sekretaris', 'name' => 'Bintang Regina Ramadani', 'role' => 'Sekretaris 2', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/bintang regina.png'],

                // 2. Bendahara (2)
                ['division' => 'Bendahara', 'name' => 'Anisa Hidayatus Syarifah', 'role' => 'Bendahara 1', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/anisa hidayatus.png'],
                ['division' => 'Bendahara', 'name' => 'Siska Enggar Agustina Widuri', 'role' => 'Bendahara 2', 'major' => 'Klimatologi 4', 'photo_url' => '/assets/gambar/siska.png'],

                // 3. Multimedia (11)
                ['division' => 'Multimedia', 'name' => 'Hendri Karyadi', 'role' => 'Anggota', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/hendri.png'],
                ['division' => 'Multimedia', 'name' => 'Donifa Analena Aan Monim', 'role' => 'Anggota', 'major' => 'Instrumentasi 6', 'photo_url' => '/assets/gambar/donifa.png'],
                ['division' => 'Multimedia', 'name' => 'Narayan Abirama Firmansyah', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/narayan.png'],
                ['division' => 'Multimedia', 'name' => 'Muhammad Yazid Ilmany', 'role' => 'Anggota', 'major' => 'Instrumentasi 4A', 'photo_url' => '/assets/gambar/muh yazid.png'],
                ['division' => 'Multimedia', 'name' => 'Setyoagil Azhar Andartono', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/setyoagil.png'],
                ['division' => 'Multimedia', 'name' => 'M. Adhitya Al Hafizh', 'role' => 'Anggota', 'major' => 'Geofisika 4', 'photo_url' => '/assets/gambar/m adhtya.png'],
                ['division' => 'Multimedia', 'name' => 'Farrel Fitria Nathania Kuncara', 'role' => 'Anggota', 'major' => 'Meteorologi 4A', 'photo_url' => '/assets/gambar/farrel.png'],
                ['division' => 'Multimedia', 'name' => 'Majreha Khasanah', 'role' => 'Anggota', 'major' => 'Klimatologi 4', 'photo_url' => '/assets/gambar/majreha.png'],
                ['division' => 'Multimedia', 'name' => 'Thalia Salsabila', 'role' => 'Anggota', 'major' => 'Meteorologi 4A', 'photo_url' => '/assets/gambar/thalia.png'],
                ['division' => 'Multimedia', 'name' => 'Muhammad Raihan Al Faridzi', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/muh raihan.png'],
                ['division' => 'Multimedia', 'name' => 'Faqih Rosiddin', 'role' => 'Anggota', 'major' => 'Instrumentasi 4A', 'photo_url' => '/assets/gambar/faqih.png'],

                // 4. Biro Hukum (6)
                ['division' => 'Biro Hukum', 'name' => 'Chendrika Saputri', 'role' => 'Anggota', 'major' => 'Klimatologi 6', 'photo_url' => '/assets/gambar/chendrika.png'],
                ['division' => 'Biro Hukum', 'name' => 'Annisa Mulya Amaliyah', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/annisa mulya.png'],
                ['division' => 'Biro Hukum', 'name' => 'Fanzuri Akhder Addilu', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/fanzuri akhder.png'],
                ['division' => 'Biro Hukum', 'name' => 'Ahmad Sya\'bana', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/ahmad syabana.png'],
                ['division' => 'Biro Hukum', 'name' => 'Faaza Assalova Muzeta', 'role' => 'Anggota', 'major' => 'Instrumentasi 4A', 'photo_url' => '/assets/gambar/faaza.png'],
                ['division' => 'Biro Hukum', 'name' => 'Syamril', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/syamril.png'],

                // 5. Humas (6)
                ['division' => 'Humas', 'name' => 'Anisa Rahmatya Rajlina', 'role' => 'Anggota', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/anisa rahmatya.png'],
                ['division' => 'Humas', 'name' => 'Ahmad Aqila Nubala', 'role' => 'Anggota', 'major' => 'Instrumentasi 4A', 'photo_url' => '/assets/gambar/ahmad aqila.png'],
                ['division' => 'Humas', 'name' => 'Amany Hanan Nuristiningtyas', 'role' => 'Anggota', 'major' => 'Instrumentasi 4A', 'photo_url' => '/assets/gambar/amany hanan.png'],
                ['division' => 'Humas', 'name' => 'Muhamad Sutan Rafli Syaputra', 'role' => 'Anggota', 'major' => 'Geofisika 4', 'photo_url' => '/assets/gambar/muh sutan.png'],
                ['division' => 'Humas', 'name' => 'Trialrio Iriansyah', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/trialrio.png'],
                ['division' => 'Humas', 'name' => 'Liliant Christie Fa Bate', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/liliant.png'],

                // 6. Dana Usaha (9)
                ['division' => 'Dana Usaha', 'name' => 'Sulastri Gempita', 'role' => 'Anggota', 'major' => 'Meteorologi 6', 'photo_url' => '/assets/gambar/sulastri.png'],
                ['division' => 'Dana Usaha', 'name' => 'Muhammad Shafril Rusli', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/muh shafril.png'],
                ['division' => 'Dana Usaha', 'name' => 'Muhamad Zaki Albukhori', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/muh dzaki.png'],
                ['division' => 'Dana Usaha', 'name' => 'Indra Kurniawan Cahyadi', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/indra.png'],
                ['division' => 'Dana Usaha', 'name' => 'Dear Melanti', 'role' => 'Anggota', 'major' => 'Meteorologi 4A', 'photo_url' => '/assets/gambar/dear.png'],
                ['division' => 'Dana Usaha', 'name' => 'Chandra Dwikusuma Putra', 'role' => 'Anggota', 'major' => 'Geofisika 4', 'photo_url' => '/assets/gambar/chandra.png'],
                ['division' => 'Dana Usaha', 'name' => 'Muhammad Dzakwan Rizqullah', 'role' => 'Anggota', 'major' => 'Meteorologi 4A', 'photo_url' => '/assets/gambar/muh dzakwan.png'],
                ['division' => 'Dana Usaha', 'name' => 'Maghfira Izzani Maulani', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/maghfira.png'],
                ['division' => 'Dana Usaha', 'name' => 'Lusia Felicia Anidla', 'role' => 'Anggota', 'major' => 'Geofisika 4', 'photo_url' => '/assets/gambar/lusia.png'],

                // 7. Logistik (8)
                ['division' => 'Logistik', 'name' => 'Muhammad Jauharul Hikam M.', 'role' => 'Anggota', 'major' => 'Geofisika 6', 'photo_url' => '/assets/gambar/muh jauharul.png'],
                ['division' => 'Logistik', 'name' => 'Eric Gamaliel Gurusinga', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/eric.png'],
                ['division' => 'Logistik', 'name' => 'Taruna Anugrah Lase', 'role' => 'Anggota', 'major' => 'Instrumentasi 4B', 'photo_url' => '/assets/gambar/taruna.png'],
                ['division' => 'Logistik', 'name' => 'Moch. Daffa Maulana', 'role' => 'Anggota', 'major' => 'Meteorologi 4A', 'photo_url' => '/assets/gambar/moch daffa.png'],
                ['division' => 'Logistik', 'name' => 'Daddykeyn Zui Watory', 'role' => 'Anggota', 'major' => 'Klimatologi 4', 'photo_url' => '/assets/gambar/daddykeyn.png'],
                ['division' => 'Logistik', 'name' => 'Cahyo Adi Nugroho', 'role' => 'Anggota', 'major' => 'Klimatologi 4', 'photo_url' => '/assets/gambar/cahyo.png'],
                ['division' => 'Logistik', 'name' => 'Andika Vio Indra Cahyana', 'role' => 'Anggota', 'major' => 'Meteorologi 4B', 'photo_url' => '/assets/gambar/andika.png'],
                ['division' => 'Logistik', 'name' => 'Gracio Charles Leleury', 'role' => 'Anggota', 'major' => 'Geofisika 4', 'photo_url' => '/assets/gambar/gracio.png'],
            ];

            foreach ($committees as $c) {
                Committee::create($c);
            }
        }
    }
}
