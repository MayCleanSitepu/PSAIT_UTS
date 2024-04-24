<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Nilai Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
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
                        <table class="table table-bordered table-striped w-auto">
                            <thead class="w-auto">
                                <tr>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Lahir</th>                                   
                                    <th>Mata Kuliah</th>                                   
                                    <th>Kode Mata Kuliah</th>                                   
                                    <th>Nilai</th>
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

                                if ($json && isset($json['status']) && $json['status'] == 1 && isset($json['data']) && !empty($json['data'])) {
                                    
                                    usort($json['data'], function ($a, $b) {
                                        return strcmp($a['nama'], $b['nama']);
                                    });

                                    foreach ($json['data'] as $data) {
                                        echo '<tr>';
                                        echo '<td>' . $data['nim'] . '</td>';
                                        echo '<td>' . $data['nama'] . '</td>';
                                        echo '<td>' . $data['alamat'] . '</td>';
                                        echo '<td>' . $data['tanggal_lahir'] . '</td>';
                                        echo '<td>' . $data['nama_mk'] . '</td>';
                                        echo '<td>' . $data['kode_mk'] . '</td>';
                                        echo '<td>' . $data['nilai'] . '</td>';
                                        echo '<td class="row border-0">' .

                                        '<a href="edit_nilai.php?nim=' . $data['nim'] .'&kode_mk='. $data['kode_mk'].'&nilai='. $data['nilai']. '" class="btn ml-1 btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                            </svg>
                                        </a>'


                                        . 

                                        '<form method="POST" action="hapus_data.php">
                                            <input type="hidden" name="nim" value="' . $data['nim'] . '">
                                            <input type="hidden" name="kode_mk" value="' . $data['kode_mk'] . '">
                                            <button type="submit" class="btn btn-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                </svg>
                                            </button>
                                        </form>'
                                        
                                        .
                                        
                                      '</td>';

                                        echo '</tr>';
                                        
                                    }
                                } else {
                                    echo '<tr><td colspan="5">Tidak ada data yang ditemukan.</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                        <a href="input_nilai.php" class="btn btn-primary">Tambah Nilai</a>
                        
                        
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
