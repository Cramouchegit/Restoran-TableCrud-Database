<?php
    //require_once = buat memanggil file yang berbeda
    require_once 'services/database.php';
    session_start();

    if($_SESSION['is_login'] == false) {
        header("location: login.php");
    }
    define('APP_NAME', 'CUYRESTO - WEBSITE PENERIMAAN TAMU'); //cara memanggil sesuatu dengan final project
    $select_meja_query = "SELECT * FROM meja";
    $count_meja_query = "SELECT COUNT(status) as total_count, SUM(status=1) as total_row FROM meja";

    $select_meja = $db->query($select_meja_query);
    $count_meja = $db->query($count_meja_query);

    $status = $count_meja->fetch_assoc();
    $jumlah_meja = $status["total_count"];
    $meja_isi = $status["total_row"];

    $is_full = false;

    if($jumlah_meja == $meja_isi) {
        $is_full = true;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title> <?= APP_NAME ?> </title>
</head>
<body>
    <?php include("layouts/header.php") ?>

    <br>

    <!-- <h1 align="center"> -->
        <?php 
        $sisa_meja = $jumlah_meja - $meja_isi;
            if($is_full) {
                echo "<h1 align='center'>MEJA PENUH</h1>";
            }else {
                echo "<h1 align='center'>$sisa_meja Meja Kosong</h1>";
            }
        ?>
    <!-- </h1> -->
    <div class="container">
        <!-- looping lewat foreach -->
        <?php
                foreach ($select_meja as $meja) {
                    // menampilkan tipe meja dan no meja
                    // echo $meja['no_meja'];
                    // echo $meja['tipe_meja'];
            ?>
        <div class="card" onclick="goToMeja(`<?= $meja['no_meja'] ?>`, `<?= $meja['nama_pelanggan'] ?>`)">
            <b><?= $meja['tipe_meja'] . " " . $meja['no_meja']; ?></b>
            <p>
                <!-- Cara menampilkan data meja -->
                <!-- if($meja['nama_pelanggan'] == NULL AND $meja['jumlah_orang'] == NULL) {
                            echo "meja kosong";
                        } -->

                <!-- Jika nama pelangan NULL dan meja jumlah orangnya NULL/belum ada datanya tanda tanya adalah maka "meja kosong" selain dari itu maka munculah nama pelanggan dari database-->
                <?= $meja['nama_pelanggan'] == null && $meja['jumlah_orang'] == null ? "meja kosong" : $meja['nama_pelanggan'] . " " . $meja['jumlah_orang'] . " orang" ?>
            </p>
        </div>
        <?php } ?>
    </div>
    <script>
        function goToMeja(no_meja, nama_pelanggan) {
            const url = "meja.php";
            const params = `?no_meja=${no_meja}&nama_pelanggan=${nama_pelanggan}`
                window.location.replace(url + params);
            // window.location.replace(`meja.php?no_meja=${no_meja}&nama_pelanggan=${nama_pelanggan}`)
        }
    </script>
</body>

</html>
