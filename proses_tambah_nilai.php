<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form HTML
    $nim = $_POST['nim'];
    $kode_mk = $_POST['kode_mk'];
    $nilai = $_POST['nilai'];

    // Data yang akan dikirimkan ke API dalam format JSON
    $data = array(
        'nim' => $nim,
        'kode_mk' => $kode_mk,
        'nilai' => $nilai
    );

    // Konversi data menjadi JSON
    $data_json = json_encode($data);

    // URL endpoint API
    $api_url = 'http://localhost/UTS/rest.php';

    // Konfigurasi curl untuk mengirim data ke API
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Eksekusi curl dan tangkap responsenya
    $response = curl_exec($curl);

    // Cek apakah request berhasil atau tidak
    if ($response === false) {
        echo json_encode(array("status" => 0, "message" => "Failed to send data to API"));
    } else {
        // Konversi respons dari API menjadi array
        $result = json_decode($response, true);
        // Tampilkan pesan dari API
        echo json_encode($result);
    }

    // Tutup curl
    curl_close($curl);
} else {
    // Jika bukan metode POST, beri respons Bad Request
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(array("status" => 0, "message" => "Invalid request method"));
}
?>
