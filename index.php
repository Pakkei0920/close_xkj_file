<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="5" >
    <link rel="stylesheet" type="text/css" href="style.css" media="screen"/>

	<title> Sensor Data </title>

</head>

<body>

    <h1>SENSOR DATA</h1>

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

// 查询MySQL中的数据
$sql = "SELECT id, sensor, location, temperature, humidity, datetime FROM sensor_data ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// 检测查询结果
if (!$result) {
  die("Error: " . mysqli_error($conn));
}

// 显示查询结果
echo '<html>
      <head>
        <title>Sensor Data</title>
        <style>
          body {
            background: #f5efe0;
            box-sizing: border-box;
            color: #000;
            font-size: 1.8rem;
            letter-spacing: -0.015em;
            text-align: center;
          }
          table {
            margin-left: auto;
            margin-right: auto;
            width: 80%;
          }

          th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            background: #666;
            color: #FFF;
            padding: 2px 6px;
            border-collapse: separate;
            border: 1px solid #000;
          }

          td {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 15px;
            text-align: center;
            border: 1px solid #DDD;
          }
        </style>
      </head>
      <body>';

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <th>ID</th> 
        <th>Date &amp; Time</th> 
        <th>Sensor</th> 
        <th>Location</th> 
        <th>Temperature &deg;C</th> 
        <th>Humidity &#37;</th>
      </tr>';

while ($row = mysqli_fetch_assoc($result)) {
  $id = $row["id"];
  $datetime = $row["datetime"];
  $sensor = $row["sensor"];
  $location = $row["location"];
  $temperature = $row["temperature"];
  $humidity = $row["humidity"];

  echo '<tr> 
          <td>' . $id . '</td> 
          <td>' . $datetime . '</td> 
          <td>' . $sensor . '</td> 
          <td>' . $location . '</td> 
          <td>' . $temperature . '</td> 
          <td>' . $humidity . '</td>
        </tr>';
}

echo '</table>
      </body>
    </html>';

// 释放查询结果内存
mysqli_free_result($result);

// 关闭MySQL连接
mysqli_close($conn);
?>
