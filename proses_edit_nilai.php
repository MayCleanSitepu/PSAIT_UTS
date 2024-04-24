<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form HTML
    $nim = isset($_POST['nim']) ? $_POST['nim'] : '';
    $kode_mk = isset($_POST['kode_mk']) ? $_POST['kode_mk'] : '';
    $nilai = isset($_POST['nilai']) ? $_POST['nilai'] : '';

    // Periksa apakah ada parameter yang kosong
    if (empty($nim) || empty($kode_mk) || empty($nilai)) {
        echo json_encode(array("status" => 0, "message" => "Missing parameter. Please provide all required parameters."));
        exit; // Berhenti eksekusi jika ada parameter yang kosong
    }

    // Data yang akan dikirimkan ke API dalam format JSON
    $data = array(
        'nim' => $nim,
        'kode_mk' => $kode_mk,
        'nilai' => $nilai
    );

    // Konversi data menjadi JSON
    $data_json = json_encode($data);

    // URL endpoint API untuk update nilai
    $api_url = 'http://localhost/UTS/rest.php';

    // Konfigurasi curl untuk mengirim data ke API
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    // Eksekusi curl dan tangkap responsenya
    $response = curl_exec($curl);

    // Cek apakah request berhasil atau tidak
    if ($response === false) {
        $error_msg = curl_error($curl);
        echo json_encode(array("status" => 0, "message" => "Failed to send data to API. Error: $error_msg"));
    } else {
        // Konversi respons dari API menjadi array
        $result = json_decode($response, true);
        if ($result && isset($result['status']) && $result['status'] == 1) {
            echo json_encode(array("status" => 1, "message" => "Data updated successfully"));
        } else {
            echo json_encode(array("status" => 0, "message" => "Failed to update data. API response: " . json_encode($result)));
        }
    }

    // Tutup curl
    curl_close($curl);
} else {
    // Jika bukan metode POST, beri respons Bad Request
    header("HTTP/1.0 400 Bad Request");
    echo json_encode(array("status" => 0, "message" => "Invalid request method"));
}
?>
