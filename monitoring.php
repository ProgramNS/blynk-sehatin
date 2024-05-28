<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.html");
    exit();
}

if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: index.html");
    exit();
}

// Blynk API settings
$blynk_token = 'sDfJ5eWb2LBT8SJJH1fVYN9XUlbohTwN';
$api_url_base = 'https://sgp1.blynk.cloud';

// Fungsi untuk mengambil data dari Blynk
function fetchBlynkData($token, $pin)
{
    $url = "https://sgp1.blynk.cloud/external/api/get?token=$token&pin=$pin";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

// Mengambil data dari Blynk
$spo2 = fetchBlynkData($blynk_token, 'v5');
$suhu = fetchBlynkData($blynk_token, 'v3');
$detak_jantung = fetchBlynkData($blynk_token, 'v4');

// Memastikan data diambil dengan benar
if (is_array($spo2)) {
    $spo2 = $spo2[0];
}
if (is_array($suhu)) {
    $suhu = $suhu[0];
}
if (is_array($detak_jantung)) {
    $detak_jantung = $detak_jantung[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Dashboard</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .dashboard-container {
        background-color: #4CAF50;
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        text-align: center;
        color: white;
    }

    .card {
        background-color: #f2f2f2;
        border-radius: 10px;
        padding: 20px;
        margin: 10px;
    }

    .gauge {
        font-size: 48px;
        color: black;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
    }

    .logo {
        width: 10rem;
    }

    .logout-btn {
        background-color: #28a745;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
    }
    </style>
</head>

<body>

    <div class="header">
        <img src="images/Logo_Kampus_Merdeka_Kemendikbud.png" alt="Kampus Merdeka" class="logo">
        <img src="images/mitra_ed3b11ff-d5e7-4a62-a608-f1c5d8f5748b.png" alt="Indobot Academy" class="logo">
    </div>

    <div class="container dashboard-container">
        <form method="post">
            <div class="d-flex justify-content-end">
                <button class="logout-btn" type="submit" name="logout">Logout</button>
            </div>
            <div>
                <img src="images/logo sehatin.jpg" alt="Logo" class="img-fluid mb-3 rounded" style="width: 10rem;">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="gauge"><?php echo htmlspecialchars($spo2); ?></div>
                        <p class="text-dark">SPO2</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="gauge"><?php echo htmlspecialchars($suhu); ?></div>
                        <p class="text-dark">SUHU</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="gauge"><?php echo htmlspecialchars($detak_jantung); ?></div>
                        <p class="text-dark">Detak Jantung</p>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>