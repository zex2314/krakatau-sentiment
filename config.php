<?php
// Token API Apify
define('APIFY_TOKEN', 'apify_api_DxQu14TsBhrhxH5xlkehSTAHx4Pbp50ZeuQW');

/**
 * Fungsi untuk mengambil data dari Dataset Apify API
 */
function getApifyDatasetItems($datasetId) {
    $url = "https://api.apify.com/v2/datasets/{$datasetId}/items?token=" . APIFY_TOKEN;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        curl_close($ch);
        return null;
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

/**
 * Fungsi Penyedia 8 Data Sentimen Masyarakat (Mock Data)
 */
function getMockSentimentData() {
    return [
        [
            "id" => "POST-001",
            "tanggal" => "2026-10-08 08:30",
            "pengguna" => "@warga_pesisir",
            "platform" => "X (Twitter)",
            "teks" => "Abu vulkanik Anak Krakatau makin tebal pagi ini di wilayah Banten. Mohon semua warga pakai masker saat keluar rumah!",
            "sentimen" => "Negatif",
            "skor" => 0.88,
            "dampak" => "Kesehatan / ISPA"
        ],
        [
            "id" => "POST-002",
            "tanggal" => "2026-10-08 09:15",
            "pengguna" => "@banten_info",
            "platform" => "Instagram",
            "teks" => "Tim BPBD Banten cepat tanggap membagikan 10.000 masker gratis untuk mengantisipasi sebaran abu vulkanik Gunung Anak Krakatau.",
            "sentimen" => "Positif",
            "skor" => 0.92,
            "dampak" => "Penanganan Bencana"
        ],
        [
            "id" => "POST-003",
            "tanggal" => "2026-10-08 10:00",
            "pengguna" => "@nelayan_sunda",
            "platform" => "Facebook",
            "teks" => "Aktivitas melaut terganggu akibat jarak pandang terbatas di Selat Sunda karena paparan abu vulkanik.",
            "sentimen" => "Negatif",
            "skor" => 0.85,
            "dampak" => "Mata Pencaharian"
        ],
        [
            "id" => "POST-004",
            "tanggal" => "2026-10-08 11:20",
            "pengguna" => "@traveler_id",
            "platform" => "X (Twitter)",
            "teks" => "Jadwal penyeberangan kapal ferry Merak-Bakauheni terpantau masih lancar dan aman dengan pengawasan ketat BMKG.",
            "sentimen" => "Netral",
            "skor" => 0.65,
            "dampak" => "Transportasi Laut"
        ],
        [
            "id" => "POST-005",
            "tanggal" => "2026-10-08 13:45",
            "pengguna" => "@mitigasi_bencana",
            "platform" => "YouTube",
            "teks" => "Panduan lengkap menghadapi hujan abu vulkanik: Amankan sumber air bersih dan tutup ventilasi rumah.",
            "sentimen" => "Positif",
            "skor" => 0.90,
            "dampak" => "Edukasi Masyarakat"
        ],
        [
            "id" => "POST-006",
            "tanggal" => "2026-10-08 14:10",
            "pengguna" => "@petani_lampung",
            "platform" => "Facebook",
            "teks" => "Lahan pertanian di sekitar pesisir Lampung Selatan mulai tertutup tipis abu vulkanik, khawatir merusak tanaman sayur.",
            "sentimen" => "Negatif",
            "skor" => 0.79,
            "dampak" => "Pertanian"
        ],
        [
            "id" => "POST-007",
            "tanggal" => "2026-10-08 15:30",
            "pengguna" => "@pengamat_volcano",
            "platform" => "X (Twitter)",
            "teks" => "Erupsi Anak Krakatau merupakan fenomena alam berkala. Tetap tenang dan selalu pantau info resmi dari PVMBG.",
            "sentimen" => "Netral",
            "skor" => 0.70,
            "dampak" => "Informasi Kebencanaan"
        ],
        [
            "id" => "POST-008",
            "tanggal" => "2026-10-08 16:50",
            "pengguna" => "@sehat_banten",
            "platform" => "Instagram",
            "teks" => "Puskesmas setempat siap melayani warga yang mengalami iritasi mata atau mata pedih akibat paparan abu vulkanik.",
            "sentimen" => "Positif",
            "skor" => 0.86,
            "dampak" => "Layanan Kesehatan"
        ]
    ];
}
?>