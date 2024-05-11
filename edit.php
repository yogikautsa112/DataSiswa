<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btn-update"])) {
        $index = $_GET["index"];
        $nama = $_POST["nama"];
        $nis = $_POST["nis"];
        $rayon = $_POST["rayon"];
        $_SESSION['data_siswa'][$index] = array(
            'nama' => $nama,
            'nis' => $nis,
            'rayon' => $rayon
        );
        header("Location: index.php");
        exit;
    }
}
if (!isset($_GET["index"])) {
    header("Location: index.php");
    exit;
}

$index = $_GET["index"];

if (!isset($_SESSION['data_siswa'][$index])) { 
    header("Location: index.php");
    exit;
}

$siswa = $_SESSION['data_siswa'][$index];
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
        <form method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $siswa['nama']; ?>">
            </div>
            <div class="form-group">
                <label for="nis">NIS:</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $siswa['nis']; ?>">
            </div>
            <div class="form-group">
                <label for="rayon">Rayon:</label>
                <input type="text" class="form-control" id="rayon" name="rayon" value="<?php echo $siswa['rayon']; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="btn-update">Update</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
