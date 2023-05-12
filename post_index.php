<?php
$servername = "localhost"; // MySQL服务器名称
$username = "root"; // MySQL用户名
$password = "QKV6yCs2ps.="; // MySQL密码
$dbname = "xkj"; // MySQL数据库名

// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);

// 检测连接
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// 获取POST数据
$sensor = $_POST['sensor'];
$location = $_POST['location'];
$temperature = $_POST['temperature'];
$humidity = $_POST['humidity'];

// 插入数据到MySQL
$sql = "INSERT INTO sensor_data (sensor, location, temperature, humidity) VALUES ('$sensor', '$location', $temperature, $humidity)";


if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
