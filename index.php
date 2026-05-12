<?php
include 'koneksi.php';

$hasil = "";
$alasan = "";
$solusi = "";

// Ambil semua data kondisi
$query_conditions = mysqli_query($conn, "SELECT * FROM conditions");

if(isset($_POST['diagnosa'])) {

    $kondisi1 = $_POST['kondisi1'];
    $kondisi2 = $_POST['kondisi2'];

    // Cari hasil diagnosa
    $query = mysqli_query($conn, "
        SELECT hasil 
        FROM rules 
        WHERE kondisi1='$kondisi1'
        AND kondisi2='$kondisi2'
    ");

    $data = mysqli_fetch_assoc($query);

    // Jika ditemukan
    if($data) {

        $hasil = $data['hasil'];

        // Ambil nama kondisi 1
        $q1 = mysqli_query($conn, "
            SELECT nama_kondisi 
            FROM conditions 
            WHERE id='$kondisi1'
        ");

        $d1 = mysqli_fetch_assoc($q1);

        // Jika kondisi 2 dipilih
        if($kondisi2 != 0){

            // Ambil nama kondisi 2
            $q2 = mysqli_query($conn, "
                SELECT nama_kondisi 
                FROM conditions 
                WHERE id='$kondisi2'
            ");

            $d2 = mysqli_fetch_assoc($q2);

            // Membuat alasan otomatis
            $alasan = "Karena HP mengalami kondisi '" .
                        $d1['nama_kondisi'] .
                        "' dan '" .
                        $d2['nama_kondisi'] .
                        "', maka kemungkinan kerusakan adalah '" .
                        $hasil . "'.";

        } else {

            $alasan = "Karena HP mengalami kondisi '" .
                        $d1['nama_kondisi'] .
                        "', maka kemungkinan kerusakan adalah '" .
                        $hasil . "'.";

        }

        // SOLUSI BERDASARKAN HASIL
        if($hasil == "IC Power Rusak"){

            $solusi = "Periksa IC Power dan lakukan penggantian pada komponen IC Power.";

        } elseif($hasil == "Port Charger Rusak"){

            $solusi = "Bersihkan port charger atau ganti port charger jika rusak.";

        } elseif($hasil == "LCD Rusak"){

            $solusi = "Lakukan penggantian LCD atau periksa fleksibel layar.";

        } elseif($hasil == "Baterai Drop"){

            $solusi = "Ganti baterai dengan baterai baru yang sesuai tipe HP.";

        } elseif($hasil == "Baterai Rusak"){

            $solusi = "Lakukan pengecekan baterai dan ganti jika sudah tidak normal.";

        } elseif($hasil == "Sistem Crash"){

            $solusi = "Lakukan restart, reset sistem, atau flashing ulang perangkat.";

        } elseif($hasil == "IC Sinyal Rusak"){

            $solusi = "Periksa bagian IC sinyal dan antena jaringan.";

        } elseif($hasil == "Touchscreen Bermasalah"){

            $solusi = "Periksa touchscreen atau ganti layar sentuh.";

        } elseif($hasil == "Modul Kamera Rusak"){

            $solusi = "Periksa modul kamera dan lakukan penggantian jika diperlukan.";

        } elseif($hasil == "Overheat"){

            $solusi = "Kurangi penggunaan berlebihan dan periksa kondisi baterai atau prosesor.";

        } elseif($hasil == "Gangguan Sinyal"){

            $solusi = "Periksa kartu SIM dan komponen jaringan pada HP.";

        } elseif($hasil == "Kerusakan Power"){

            $solusi = "Periksa jalur power dan komponen IC Power.";

        } elseif($hasil == "Kerusakan Layar"){

            $solusi = "Periksa LCD dan touchscreen pada perangkat.";

        } else {

            $solusi = "Silakan lakukan pengecekan lebih lanjut pada perangkat.";

        }

    } else {

        $hasil = "Kerusakan tidak ditemukan";
        $alasan = "Belum ada rule yang sesuai dengan kondisi yang dipilih.";
        $solusi = "-";

    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Sistem Deteksi Kerusakan HP Android</title>

    <style>

        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 40px;
        }

        .container {
            width: 420px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        select,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
        }

        button {
            cursor: pointer;
        }

        .hasil {
            margin-top: 20px;
            background: #d4edda;
            padding: 15px;
            border-radius: 5px;
        }

        .hasil h3,
        .hasil h4 {
            margin: 5px 0;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>Sistem Deteksi Kerusakan HP Android</h2>

    <form method="POST">

        <!-- KONDISI 1 -->
        <label>Kondisi 1</label>

        <select name="kondisi1" required>

            <option value="">-- Pilih Kondisi --</option>

            <?php
            mysqli_data_seek($query_conditions, 0);

            while($row = mysqli_fetch_assoc($query_conditions)) {
            ?>

                <option value="<?php echo $row['id']; ?>"

                <?php
                if(isset($_POST['kondisi1']) && $_POST['kondisi1'] == $row['id']) {
                    echo "selected";
                }
                ?>

                >

                    <?php echo $row['nama_kondisi']; ?>

                </option>

            <?php } ?>

        </select>

        <!-- KONDISI 2 -->
        <label>Kondisi 2</label>

        <select name="kondisi2" required>

            <option value="0"

            <?php
            if(isset($_POST['kondisi2']) && $_POST['kondisi2'] == "0") {
                echo "selected";
            }
            ?>

            >

                Tidak ada

            </option>

            <?php
            mysqli_data_seek($query_conditions, 0);

            while($row = mysqli_fetch_assoc($query_conditions)) {
            ?>

                <option value="<?php echo $row['id']; ?>"

                <?php
                if(isset($_POST['kondisi2']) && $_POST['kondisi2'] == $row['id']) {
                    echo "selected";
                }
                ?>

                >

                    <?php echo $row['nama_kondisi']; ?>

                </option>

            <?php } ?>

        </select>

        <button type="submit" name="diagnosa">
            Diagnosa
        </button>

    </form>

    <!-- HASIL -->
    <?php if($hasil != "") { ?>

        <div class="hasil">

            <h3>Hasil Diagnosa:</h3>

            <p>
                <b><?php echo $hasil; ?></b>
            </p>

            <h4>Alasan:</h4>

            <p>
                <?php echo $alasan; ?>
            </p>

            <h4>Solusi:</h4>

            <p>
                <?php echo $solusi; ?>
            </p>

        </div>

    <?php } ?>

</div>

</body>
</html>