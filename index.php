<?php
include 'koneksi.php';

$hasil = "";
$alasan = "";

// Ambil semua data kondisi
$query_conditions = mysqli_query($conn, "SELECT * FROM conditions");

if(isset($_POST['diagnosa'])) {

    $kondisi1 = $_POST['kondisi1'];
    $kondisi2 = $_POST['kondisi2'];

    // Cari hasil diagnosa berdasarkan rule
    $query = mysqli_query($conn, "
        SELECT hasil 
        FROM rules 
        WHERE kondisi1='$kondisi1'
        AND kondisi2='$kondisi2'
    ");

    $data = mysqli_fetch_assoc($query);

    // Jika data ditemukan
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

            // Jika hanya 1 kondisi
            $alasan = "Karena HP mengalami kondisi '" .
                        $d1['nama_kondisi'] .
                        "', maka kemungkinan kerusakan adalah '" .
                        $hasil . "'.";

        }

    } else {

        // Jika rule tidak ditemukan
        $hasil = "Kerusakan tidak ditemukan";
        $alasan = "Belum ada rule yang sesuai dengan kondisi yang dipilih.";

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

        </div>

    <?php } ?>

</div>

</body>
</html>