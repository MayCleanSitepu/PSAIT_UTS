<?php
include 'config.php';

// Fungsi untuk mengupdate nilai mahasiswa
function update_nilai($nim, $kode_mk, $nilai)
{
    global $mysqli;

    // Lakukan sanitasi input untuk menghindari SQL injection
    $nim = mysqli_real_escape_string($mysqli, $nim);
    $kode_mk = mysqli_real_escape_string($mysqli, $kode_mk);
    $nilai = mysqli_real_escape_string($mysqli, $nilai);

    // Query untuk update nilai mahasiswa
    $query = "UPDATE perkuliahan SET nilai='$nilai' WHERE nim='$nim' AND kode_mk='$kode_mk'";

    // Eksekusi query
    if ($mysqli->query($query)) {
        echo json_encode(array("status" => 1, "message" => "Data updated successfully"));
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(array("status" => 0, "message" => "Failed to update data: " . $mysqli->error));
    }
}

// Panggil fungsi update_nilai dengan parameter yang sesuai
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nim']) && isset($_POST['kode_mk']) && isset($_POST['nilai'])) {
        $nim = $_POST['nim'];
        $kode_mk = $_POST['kode_mk'];
        $nilai = $_POST['nilai'];

        update_nilai($nim, $kode_mk, $nilai);
    } else {
        echo json_encode(array("status" => 0, "message" => "Missing parameters"));
    }
} else {
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode(array("status" => 0, "message" => "Invalid request method"));
}
?>
