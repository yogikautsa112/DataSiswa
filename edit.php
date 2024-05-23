<?php
session_start();

function is_data_exist($nama, $nis, $rayon, $exclude_index = null) {
    foreach ($_SESSION['data_siswa'] as $index => $siswa) {
        if ($index != $exclude_index && $siswa['nis'] == $nis) {
            return true;
        }
    }
    return false;
}

if (!isset($_GET["index"]) || !isset($_SESSION['data_siswa'][$_GET["index"]])) {
    header("Location: index.php");
    exit;
}

$index = $_GET["index"];
$siswa = $_SESSION['data_siswa'][$index];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-update"])) {
    $nama = $_POST["nama"];
    $nis = $_POST["nis"];
    $rayon = $_POST["rayon"];

    if (is_data_exist($nama, $nis, $rayon, $index)) {
        $_SESSION['error_message'] = "Data dengan NIS ini sudah ada. Tidak boleh menduplikat.";
    } else {
        $_SESSION['data_siswa'][$index] = array(
            'nama' => $nama,
            'nis' => $nis,
            'rayon' => $rayon
        );
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-4">Edit Data Siswa</h2>
        <?php
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']);
        }
        ?>
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($siswa['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?php echo htmlspecialchars($siswa['nis']); ?>" required>
            </div>
            <div class="form-group">
                <label for="rayon">Rayon:</label>
                <input type="text" class="form-control" id="rayon" name="rayon" value="<?php echo htmlspecialchars($siswa['rayon']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="btn-update">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
