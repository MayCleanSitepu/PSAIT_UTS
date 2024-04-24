<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Tambah Nilai Mahasiswa</h2>
        <form action="proses_tambah_nilai.php" method="POST">
            <div class="form-group">
                <label for="nim">NIM Mahasiswa:</label>
                <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $_GET['nim']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="kode_mk">Kode_mk:</label>
                <input type="text" class="form-control" id="kode_mk" name="kode_mk" required>
            </div>
            <div class="form-group">
                <label for="nilai">Nilai:</label>
                <input type="number" class="form-control" id="nilai" name="nilai" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</body>
</html>



