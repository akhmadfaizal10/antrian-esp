<?php
// Pastikan ada parameter ID yang diberikan
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Konfigurasi koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "antrian";

    // Membuat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Debugging untuk memastikan ID yang diterima valid
    error_log("Requested Previous Message for ID: " . $id);

    // Query untuk mengambil pesan sebelumnya dari ID yang diberikan dan hanya untuk pesan hari ini
    // ID yang lebih kecil dari $id dan hanya untuk pesan hari ini
    $sql = "SELECT id, message, created_at FROM messages WHERE created_at >= CURDATE() AND id < $id ORDER BY id DESC LIMIT 1";
    
    // Debugging SQL query
    error_log("SQL Query: " . $sql);

    $result = $conn->query($sql);

    // Cek apakah ada pesan sebelumnya
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row); // Mengembalikan data dalam format JSON
    } else {
        error_log("Tidak ada pesan sebelumnya.");
        echo json_encode(null); // Tidak ada pesan sebelumnya
    }

    // Menutup koneksi database
    $conn->close();
}
?>
