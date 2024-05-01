<?php
    require_once("services/pdf/fpdf.php");
    require_once("services/database.php");

    session_start();

    if($_SESSION['is_login'] == false) {
        header("location: login.php");
    }

    if(isset($_POST['report'])) {
        $hari = $_POST['hari'];
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetTitle("Laporan Pengunjung");
        $pdf->SetFont("Arial", "B", 14);
        // $pdf->Cell(40, 10, "TEST", 0, 1);

        $select_history_query = "SELECT * FROM history WHERE hari='$hari'";  //ketika melakukan query history ini yang dihistory ini dihari tersebut ditanggal posting tadi
        $select_history = $db->query($select_history_query);
        //jika tidak ada data alias ga lebih dari 0 datanya
        if($select_history->num_rows > 0) { //jika ada data yg di database 
            //maka buatlah generate header dahulu
        $pdf->Text(10, 6, "Total $select_history->num_rows pengunjung pada $hari");
        $pdf->Cell(24, 10, "no_meja", 1, 0);
        $pdf->Cell(48, 10, "nama_pelanggan", 1, 0);
        $pdf->Cell(38, 10, "hari keluar", 1, 0);
        $pdf->Cell(38, 10, "jam keluar", 1, 0);
        $pdf->Cell(40, 10, "", 0, 1); //untuk enter line

            //& kita looping database yg hasil query diatas, kita munculin history dibawah ini
            foreach($select_history as $history) {
                $pdf->Cell(24, 10, $history["no_meja"], 1, 0);
                $pdf->Cell(48, 10, $history["nama_pelanggan"], 1, 0);
                $pdf->Cell(38, 10, $history["hari"], 1, 0);
                $pdf->Cell(38, 10, $history["jam"], 1, 1);
            }
            $pdf->Output(); //dikeluarkan menjadi pdf
        }else { //maka kita munculin Tidak ada laporan untuk tgl sekian
            $pdf->SetFont("Arial", "B", 14);
            $pdf->Cell(38, 10, "Tidak ada laporan untuk tanggal $hari", 0, 1);
            $pdf->Output();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>REPORT</title>
</head>
<body>
    <?php include("layouts/header.php") ?>

    <div class="super-center">
        <h3>Cetak PDF</h3>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <input type="date" name="hari">
            <button type="submit" name="report">Generate Report</button>
        </form>
    </div>
</body>
</html>