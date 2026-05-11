<?php
include 'koneksi.php';

$hasil = "";

$query_conditions = mysqli_query($conn, "SELECT * FROM conditions");

if(isset($_POST['diagnosa'])) {

    $kondisi1 = $_POST['kondisi1'];
    $kondisi2 = $_POST['kondisi2'];

    $query = mysqli_query($conn, "SELECT hasil FROM rules WHERE kondisi1='$kondisi1' AND kondisi2='$kondisi2'");

    $data = mysqli_fetch_assoc($query);

    if($data) {
        $hasil = $data['hasil'];
    } else {
        $hasil = "Kerusakan tidak ditemukan";
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
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: auto;
        }

        h2 {
            text-align: center;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        .hasil {
            margin-top: 20px;
            background: #d4edda;
            padding: 10px;
            border-radius: 5px;
        }

    </style>

</head>
<body>

<div class="container">

    <h2>Sistem Deteksi Kerusakan HP Android</h2>

    <form method="POST">

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

    <?php if($hasil != "") { ?>

    <div class="hasil">

        <b>Hasil Diagnosa:</b><br>

        <?php echo $hasil; ?>

    </div>

    <?php } ?>

</div>

</body>
</html>