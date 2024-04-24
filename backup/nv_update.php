<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Update Nilai Mahasiswa</h2>
        <form action="nv_proses_update.php" method="POST">
            <div class="form-group">
                <label for="nim">NIM Mahasiswa:</label>
                <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM Mahasiswa">
            </div>
            <div class="form-group">
                <label for="kode_mk">Kode Mata Kuliah:</label>
                <input type="text" class="form-control" id="kode_mk" name="kode_mk" placeholder="Masukkan Kode Mata Kuliah">
            </div>
            <div class="form-group">
                <label for="nilai">Nilai Baru:</label>
                <input type="number" class="form-control" id="nilai" name="nilai" placeholder="Masukkan Nilai Baru">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Update Nilai</button>
        </form>
    </div>
</body>
</html>
