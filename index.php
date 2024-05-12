<?php 
session_start();

function is_data_exist($nama, $nis, $rayon) {
    foreach ($_SESSION['data_siswa'] as $siswa) {
        if($siswa['nama'] == $nama && $siswa['nis'] == $nis && $siswa['rayon'] == $rayon) {
            return true;
        } else {
            return false;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-submt"])) {
        $nama = $_POST["nama"];
        $nis = $_POST["nis"];
        $rayon = $_POST["rayon"];

        $nis_exist = false;
        foreach ($_SESSION['data_siswa'] as $siswa) {
            if($siswa['nis'] == $nis) {
                $nis_exist = true;
                break;
            }
        }
        
        if(is_data_exist($nama, $nis, $rayon)) {
            $_SESSION['error_message'] = "Data sudah ada. Tidak boleh menduplikat";
        } elseif ($siswa['nis'] === $nis) {
            $_SESSION['error_message'] = "NIS sudah ada. Tidak boleh menduplikat";
        } else {
            $_SESSION["data_siswa"][] = array(
                'nama' => $nama,
                'nis' => $nis,
                'rayon' => $rayon,
            );
            $_SESSION['success_message'] = "Data berhasil ditambahkan";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-delete"])) {
    $index = $_POST["delete-index"];
    unset($_SESSION['data_siswa'][$index]);
    $_SESSION['data_siswa'] = array_values($_SESSION['data_siswa']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-edit"])) {
    $index = $_POST["edit-index"];
    header("Location: edit.php?index=$index");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-print-all"])) {
    header("Location: print.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn-delete-all"])) {
    unset($_SESSION['data_siswa']);
    $_SESSION['data_siswa'] = array();
    $_SESSION['success_message'] = "Semua data berhasil dihapus";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="public/style.css">
</head>
<body>
<div class="container">
    <div class="form-container">
        <h3 class="text-center mt-4">Masukan Data Siswa</h3>
        <!-- FORM CONTROL -->
        <div class="d-flex justify-content-center">
            <form method="post" class="add-data d-flex justify-content-center flex-column mb-2">
                <div class="input-container d-flex gap-2">
                    <input class="form-control" type="text" placeholder="Masukan Nama" style="text-align: center;" name="nama" required>
                    <input class="form-control" type="number" placeholder="Masukan NIS" style="text-align: center;" name="nis" required>
                    <input class="form-control" type="text" placeholder="Masukan Rayon" style="text-align: center;" name="rayon" required>
                </div>
                <!-- Add Button -->
                <div class="btn-collapse mt-2">
                    <button type="submit" class="btn btn-primary btn-sm" name="btn-submt"><i class="fa-solid fa-plus"></i> Tambah</button>
                </div>
            </form>
        </div>
    </div>
    <hr>
        <?php 
            if(isset($_SESSION["success_message"])) {
                echo "<div class='alert alert-success d-flex justify-content-between' role='alert'>";
                echo $_SESSION['success_message'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo '</div>';
                unset($_SESSION['success_message']);
            }

            if(isset($_SESSION["error_message"])) {
                echo "<div class='alert alert-danger d-flex justify-content-between' role='alert'>";
                echo $_SESSION['error_message'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo '</div>';
                unset($_SESSION['error_message']);
            }
        ?>
        <div>
            <table class="table table-bordered" >
            <?php if(isset($_SESSION['data_siswa']) && !empty($_SESSION['data_siswa'])): ?>
                <div class="d-flex btn-collapse mt-2 mb-2 gap-2">
                    <form action="" method="post">
                        <button type="submit" class="btn btn-warning btn-sm" name="btn-print-all"><i class="fa-solid fa-print"></i> Cetak</button>
                        <button type="submit" class="btn btn-danger btn-sm" name="btn-delete-all"><i class='fa-solid fa-trash'></i> Hapus</button>
                    </form>
                </div>
            <?php endif; ?>
            <thead>
                <tr class="table-container table-primary" style="text-align: center;">
                    <th scope="col">No</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Rayon</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
                <tbody>
                <?php
                if (isset($_SESSION['data_siswa']) && !empty($_SESSION['data_siswa'])) {
                    $nomor = 1;
                    foreach ($_SESSION['data_siswa'] as $index => $siswa) {
                        echo "<tr style='text-align: center;'>";
                        echo "<td>$nomor</td>";
                        echo "<td>".$siswa['nama']."</td>";
                        echo "<td>".$siswa['nis']."</td>";
                        echo "<td>".$siswa['rayon']."</td>";
                        echo "<td>
                            <form method='post' class='d-inline-block'>
                                <input type='hidden' name='edit-index' value='$index';>
                                <button type='submit' class='btn btn-warning btn-sm' name='btn-edit'><i class='fa-solid fa-pencil'></i> </button>
                            </form>
                            <form method='post' class='d-inline-block'>
                                <input type='hidden' name='delete-index' value='$index'>
                                <button type='submit' class='btn btn-danger btn-sm' name='btn-delete'><i class='fa-solid fa-trash'></i> </button>
                            </form>
                            </td>";
                        echo "</tr>";
                        $nomor++;
                    } 
                    } else {
                        echo "<tr class='table-active fw-bold'>
                        <td colspan='5' class='text-danger' style='text-align: center;'>Tidak ada Data</td>
                        </tr>";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
