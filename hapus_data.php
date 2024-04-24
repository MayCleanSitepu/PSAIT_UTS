<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form HTML
    $nim = $_POST['nim'];
    $kode_mk = $_POST['kode_mk'];

    // URL endpoint API untuk menghapus data
    $api_url = 'http://localhost/UTS/rest.php?nim=' . $nim . '&kode_mk=' . $kode_mk;

    // Konfigurasi curl untuk mengirim permintaan DELETE ke API
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Eksekusi curl dan tangkap responsenya
    $response = curl_exec($curl);

    // Cek apakah request berhasil atau tidak
    if ($response === false) {
        echo json_encode(array("status" => 0, "message" => "Failed to send delete request to API"));
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
