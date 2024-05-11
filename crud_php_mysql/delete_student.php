<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

include("connection.php");

if (isset($_GET["nim"])) {
    $nim = $_GET["nim"];
    
    // Query untuk menghapus data mahasiswa berdasarkan NIM
    $delete_query = "DELETE FROM student WHERE nim = '$nim'";
    $delete_result = mysqli_query($connection, $delete_query);
    
    if ($delete_result) {
        header("Location: student_view.php?message=Data%20mahasiswa%20berhasil%20dihapus.");
        exit();
    } else {
        echo "Gagal menghapus data mahasiswa.";
        exit();
    }
} else {
    echo "NIM mahasiswa tidak ditemukan.";
    exit();
}

mysqli_close($connection);
?>
