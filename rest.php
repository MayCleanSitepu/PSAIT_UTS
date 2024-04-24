<?php
require_once "config.php";

$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        if (!empty($_GET["nim"]) && !empty($_GET["kode_mk"])) {
            $nim = $_GET["nim"];
            $kode_mk = $_GET["kode_mk"];
            get_data($nim, $kode_mk);
        } elseif (!empty($_GET["nim"])) {
            $nim = $_GET["nim"];
            get_nilai_by_nim($nim);
        } else {
            get_all_data();
        }
        break;
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!empty($input["nim"]) && !empty($input["kode_mk"]) && isset($input["nilai"])) {
            $nim = $input["nim"];
            $kode_mk = $input["kode_mk"];
            $nilai = $input["nilai"];
            insert_data($nim, $kode_mk, $nilai);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(array("status" => 0, "message" => "Missing parameters"));
        }
        break;
    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        if (!empty($_GET["nim"]) && !empty($_GET["kode_mk"]) && isset($input["nilai"])) {
            $nim = $_GET["nim"];
            $kode_mk = $_GET["kode_mk"];
            $nilai = $input["nilai"];
            update_data($nim, $kode_mk, $nilai);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(array("status" => 0, "message" => "Missing parameters"));
        }
        break;
    case 'DELETE':
        if (!empty($_GET["nim"]) && !empty($_GET["kode_mk"])) {
            $nim = $_GET["nim"];
            $kode_mk = $_GET["kode_mk"];
            delete_data($nim, $kode_mk);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(array("status" => 0, "message" => "Missing parameters"));
        }
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

function get_all_data()
{
    global $mysqli;
    $query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, mahasiswa.tanggal_lahir, matakuliah.nama_mk,matakuliah.kode_mk, perkuliahan.nilai 
              FROM mahasiswa 
              JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim 
              JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk";
    $data = array();
    $result = $mysqli->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' =>'Get List Data Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_data($nim, $kode_mk)
{
    global $mysqli;
    $query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, matakuliah.nama_mk, perkuliahan.nilai 
              FROM mahasiswa 
              JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim 
              JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk 
              WHERE mahasiswa.nim = '$nim' AND matakuliah.kode_mk = '$kode_mk'";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        $response = array(
            'status' => 1,
            'message' =>'Get Data Successfully.',
            'data' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header("HTTP/1.0 404 Not Found");
        echo json_encode(array("status" => 0, "message" => "Data not found"));
    }
}


function get_nilai_by_nim($nim)
{
    global $mysqli;
    $query = "SELECT mahasiswa.nim, mahasiswa.nama, matakuliah.nama_mk, perkuliahan.nilai 
              FROM mahasiswa 
              JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim 
              JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk 
              WHERE mahasiswa.nim = '$nim'";
    $result = $mysqli->query($query);
    if ($result->num_rows > 0) {
        $data = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        $response = array(
            'status' => 1,
            'message' =>'Get Data Successfully.',
            'data' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        header("HTTP/1.0 404 Not Found");
        echo json_encode(array("status" => 0, "message" => "Data not found"));
    }
}

function insert_data($nim, $kode_mk, $nilai)
{
    global $mysqli;
    $query = "INSERT INTO perkuliahan (nim, kode_mk, nilai) 
              VALUES ('$nim', '$kode_mk', $nilai)";
    if ($mysqli->query($query)) {
        echo json_encode(array("status" => 1, "message" => "Data inserted successfully"));
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(array("status" => 0, "message" => "Failed to insert data"));
    }
}

function update_data($nim, $kode_mk, $nilai)
{
    global $mysqli;
    // Gunakan parameterized query untuk menghindari SQL Injection
    $query = "UPDATE perkuliahan SET nilai=? WHERE nim=? AND kode_mk=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("iss", $nilai, $nim, $kode_mk);
        if ($stmt->execute()) {
            // Jika berhasil, kirim respons dengan status 1
            echo json_encode(array("status" => 1, "message" => "Data updated successfully"));
        } else {
            // Jika eksekusi query gagal, kirim respons dengan status 0 dan pesan error
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(array("status" => 0, "message" => "Failed to update data. Error: " . $stmt->error));
        }
        $stmt->close();
    } else {
        // Jika prepare statement gagal, kirim respons dengan status 0 dan pesan error
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(array("status" => 0, "message" => "Failed to prepare statement. Error: " . $mysqli->error));
    }
}


function delete_data($nim, $kode_mk)
{
    global $mysqli;
    $query = "DELETE FROM perkuliahan 
              WHERE nim='$nim' AND kode_mk='$kode_mk'";
    if ($mysqli->query($query)) {
        echo json_encode(array("status" => 1, "message" => "Data deleted successfully"));
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo json_encode(array("status" => 0, "message" => "Failed to delete data"));
    }
}
?>
