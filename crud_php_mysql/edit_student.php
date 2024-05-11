<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}

include("connection.php");

if (isset($_GET["nim"])) {
    $nim = $_GET["nim"];
    
    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $query = "SELECT * FROM student WHERE nim = '$nim'";
    $result = mysqli_query($connection, $query);
    
    if ($result) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Gagal mengambil data mahasiswa.";
        exit();
    }
} else {
    echo "NIM mahasiswa tidak ditemukan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $name = $_POST["name"];
    $birth_city = $_POST["birth_city"];
    $birth_date = $_POST["birth_date"];
    $faculty = $_POST["faculty"];
    $department = $_POST["department"];
    $gpa = $_POST["gpa"];
    
    // Query untuk update data mahasiswa
    $update_query = "UPDATE student SET name='$name', birth_city='$birth_city', birth_date='$birth_date', faculty='$faculty', department='$department', gpa='$gpa' WHERE nim = '$nim'";
    
    $update_result = mysqli_query($connection, $update_query);
    
    if ($update_result) {
        header("Location: student_view.php?message=Data%20mahasiswa%20berhasil%20diupdate.");
        exit();
    } else {
        echo "Gagal mengupdate data mahasiswa.";
        exit();
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet" >
    <link href="assets/style2.css" rel="stylesheet" >
</head>

<body>
    <div class="container">
        <div id="header">
            <h1 id="logo">Data Mahasiswa</h1>
        </div>
        <hr>
        <nav>
            <a class="tombol tampil" href="student_view.php">Tampil</a>
            <a class="tombol tambah" href="student_add.php">Tambah</a>
            <a class="tombol logout" href="logout.php">Logout</a>
        </nav>
        <h2>Edit Data Mahasiswa</h2>
        <form id="form_mahasiswa" method="POST">
            <fieldset>
                <legend>Data Mahasiswa</legend>
                <p>
                    <label for="nim">NIM:</label>
                    <input type="text" id="nim" name="nim" value="<?php echo $data['nim']; ?>" readonly>
                </p>
                <p>
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>">
                </p>
                <p>
                    <label for="birth_city">Tempat Lahir:</label>
                    <input type="text" id="birth_city" name="birth_city" value="<?php echo $data['birth_city']; ?>">
                </p>
                <p>
                    <label for="birth_date">Tanggal Lahir:</label>
                    <input type="date" id="birth_date" name="birth_date" value="<?php echo $data['birth_date']; ?>">
                </p>
                <p>
                    <label for="faculty">Fakultas:</label>
                    <select id="faculty" name="faculty">
                        <option value="FTIB" <?php if ($data['faculty'] === 'FTIB') echo 'selected'; ?>>FTIB</option>
                        <option value="FTEIC" <?php if ($data['faculty'] === 'FTEIC') echo 'selected'; ?>>FTEIC</option>
                    </select>
                </p>
                <p>
                    <label for="department">Jurusan:</label>
                    <input type="text" id="department" name="department" value="<?php echo $data['department']; ?>">
                </p>
                <p>
                    <label for="gpa">IPK:</label>
                    <input type="text" id="gpa" name="gpa" value="<?php echo $data['gpa']; ?>">
                </p>
            </fieldset>
            <br>
            <p>
                <input type="submit" value="Simpan Perubahan">
            </p>
        </form>
    </div>
</body>

</html>
