<?php
  session_start();

  if (!isset($_SESSION["username"])) {
     header("Location: login.php");
  }

  include("connection.php");
  
  if (isset($_GET["message"])) {
      $message = $_GET["message"];
  }
     
  $query = "SELECT * FROM student ORDER BY nim ASC";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Mahasiswa</title>
  <link href="assets/style.css" rel="stylesheet" >
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
    <?php
      if (isset($message)) {
          echo "<div class='pesan'>$message</div>";
      }
    ?>
    <table border="1">
    <tr>
      <th>NIM</th>
      <th>Nama</th>
      <th>Tempat Lahir</th>
      <th>Tanggal Lahir</th>
      <th>Fakultas</th>
      <th>Jurusan</th>
      <th>IPK</th>
      <th>Action</th>
    </tr>
    <?php
      $result = mysqli_query($connection, $query);
      if(!$result) {
          die ("Query Error: ".mysqli_errno($connection)." - ".mysqli_error($connection));
      }
      while($data = mysqli_fetch_assoc($result)){ 
        $birth_date = strtotime($data["birth_date"]);
        $formatted_date = date("d-m-Y", $birth_date);
        
        echo "<tr>";
        echo "<td>$data[nim]</td>";
        echo "<td>$data[name]</td>";
        echo "<td>$data[birth_city]</td>";
        echo "<td>$formatted_date</td>";
        echo "<td>$data[faculty]</td>";
        echo "<td>$data[department]</td>";
        echo "<td>$data[gpa]</td>";
        echo "<td>
                <a class='edit' href='edit_student.php?nim=$data[nim]'>Edit</a> |
                <a class='delete' href='delete_student.php?nim=$data[nim]'>Delete</a>
              </td>";
        echo "</tr>";
      }
      mysqli_free_result($result);
      mysqli_close($connection);
    ?>
    </table>
  </div>
</body>
</html>
