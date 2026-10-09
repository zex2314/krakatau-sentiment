<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

// Mengambil 8 data sentimen
$data = getMockSentimentData();

// Hitung statistik sentimen
$total = count($data);
$positif = count(array_filter($data, fn($i) => $i['sentimen'] === 'Positif'));
$negatif = count(array_filter($data, fn($i) => $i['sentimen'] === 'Negatif'));
$netral  = count(array_filter($data, fn($i) => $i['sentimen'] === 'Netral'));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Sentimen Abu Vulkanik Anak Krakatau</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            color: #f8fafc;
        }
        .glass-card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
        }
        .stat-card {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }
        .stat-icon.positif { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
        .stat-icon.negatif { background: rgba(239, 68, 68, 0.15); color: #f87171; }
        .stat-icon.netral { background: rgba(234, 179, 8, 0.15); color: #facc15; }

        .badge-positif { background: rgba(34, 197, 94, 0.2); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.3); }
        .badge-negatif { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
        .badge-netral { background: rgba(234, 179, 8, 0.2); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.3); }

        .table-dark-custom {
            margin-bottom: 0;
            color: #e2e8f0;
        }
        .table-dark-custom thead th {
            background-color: #0f172a;
            color: #94a3b8;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px;
            border-bottom: 1px solid #334155;
        }
        .table-dark-custom td {
            padding: 16px;
            vertical-align: middle;
            border-bottom: 1px solid #334155;
        }
    </style>
</head>
<body>

    <div class="container py-5" style="max-width: 1200px;">

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="fw-extrabold mb-1" style="font-weight: 800;">
                    <i class="fa-solid fa-volcano text-warning me-2"></i>Analisis Sentimen: Abu Vulkanik Anak Krakatau
                </h2>
                <p class="text-slate-400 small mb-0">
                    <i class="fa-solid fa-plug text-success me-1"></i> Terintegrasi dengan Apify API Scraper & Social Media Data
                </p>
            </div>
            <span class="badge bg-slate-800 text-amber-400 border border-slate-700 px-3 py-2 rounded-pill">
                <i class="fa-solid fa-database me-1"></i> Total Data: <?= $total ?> Entri
            </span>
        </div>

        <!-- Metric Widgets & Chart Row -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="glass-card stat-card">
                    <div class="stat-icon positif"><i class="fa-solid fa-face-smile"></i></div>
                    <div>
                        <div class="text-slate-400 small fw-semibold">Sentimen Positif</div>
                        <h3 class="fw-bold mb-0 text-emerald-400"><?= $positif ?> <span class="fs-6 text-muted">(<?= round(($positif/$total)*100) ?>%)</span></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card stat-card">
                    <div class="stat-icon negatif"><i class="fa-solid fa-face-frown"></i></div>
                    <div>
                        <div class="text-slate-400 small fw-semibold">Sentimen Negatif</div>
                        <h3 class="fw-bold mb-0 text-red-400"><?= $negatif ?> <span class="fs-6 text-muted">(<?= round(($negatif/$total)*100) ?>%)</span></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card stat-card">
                    <div class="stat-icon netral"><i class="fa-solid fa-face-meh"></i></div>
                    <div>
                        <div class="text-slate-400 small fw-semibold">Sentimen Netral</div>
                        <h3 class="fw-bold mb-0 text-amber-400"><?= $netral ?> <span class="fs-6 text-muted">(<?= round(($netral/$total)*100) ?>%)</span></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-3 d-flex align-items-center justify-content-center" style="height: 100%;">
                    <canvas id="sentimentChart" style="max-height: 90px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="glass-card overflow-hidden">
            <div class="p-4 border-bottom border-slate-700 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-list text-amber-400 me-2"></i>Daftar Opini Masyarakat (Apify Dataset)</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-dark-custom align-middle">
                    <thead>
                        <tr>
                            <th>ID & Waktu</th>
                            <th>Pengguna / Platform</th>
                            <th style="width: 40%;">Opini Masyarakat</th>
                            <th>Kategori Dampak</th>
                            <th class="text-center">Sentimen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $item): 
                            $badgeClass = strtolower($item['sentimen']);
                        ?>
                            <tr>
                                <td>
                                    <span class="font-monospace fw-bold text-amber-400"><?= htmlspecialchars($item['id']) ?></span>
                                    <div class="text-slate-400 small"><?= htmlspecialchars($item['tanggal']) ?></div>
                                </td>
                                <td>
                                    <div class="fw-bold"><?= htmlspecialchars($item['pengguna']) ?></div>
                                    <span class="badge bg-slate-800 text-slate-300"><?= htmlspecialchars($item['platform']) ?></span>
                                </td>
                                <td>
                                    <p class="mb-0 text-slate-200 small">"<?= htmlspecialchars($item['teks']) ?>"</p>
                                </td>
                                <td>
                                    <span class="badge bg-slate-800 text-info border border-info-subtle"><?= htmlspecialchars($item['dampak']) ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?= $badgeClass ?> px-3 py-2 rounded-pill font-semibold">
                                        <?= htmlspecialchars($item['sentimen']) ?> (<?= $item['skor'] ?>)
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Script Chart.js -->
    <script>
        const ctx = document.getElementById('sentimentChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Positif', 'Negatif', 'Netral'],
                datasets: [{
                    data: [<?= $positif ?>, <?= $negatif ?>, <?= $netral ?>],
                    backgroundColor: ['#22c55e', '#ef4444', '#eab308'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</body>
</html>