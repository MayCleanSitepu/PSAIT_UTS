<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
        table tr td:last-child {
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Daftar Nilai Mahasiswa</h2>
                    </div>
                    <div class="scroll">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($curl, CURLOPT_URL, 'http://localhost/UTS/rest.php');
                                $res = curl_exec($curl);
                                $json = json_decode($res, true);

                                $displayedNames = array(); // Array untuk menyimpan nama-nama yang sudah ditampilkan

                                if ($json && isset($json['status']) && $json['status'] == 1 && isset($json['data']) && !empty($json['data'])) {
                                    foreach ($json['data'] as $data) {
                                        $nama = $data['nama'];
                                        // Cek apakah nama sudah ditampilkan sebelumnya
                                        if (!in_array($nama, $displayedNames)) {
                                            echo '<tr>';
                                            echo '<td>' . $data['nim'] . '</td>';
                                            echo '<td>' . $nama . '</td>';
                                            echo '<td><a href="insert_data.php?nim=' . $data['nim'] . '" class="btn btn-primary">Tambah Nilai</a></td>';
                                            echo '</tr>';
                                            // Tambahkan nama ke array displayedNames
                                            $displayedNames[] = $nama;
                                        }
                                    }
                                } else {
                                    echo '<tr><td colspan="3">Tidak ada data yang ditemukan.</td></tr>';
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
