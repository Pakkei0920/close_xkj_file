<?php
$servername = "localhost";
$username = "root";
$password = "QKV6yCs2ps.=";
$dbname = "xkj";
$connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT datetime, dht22_temp
          FROM sensor_data
          ORDER BY datetime DESC
          LIMIT 10";

$result = mysqli_query($connection, $query);

$dht22_tempData = array();

while ($row = mysqli_fetch_assoc($result)) {
    $dht22_tempData[] = array(
        strtotime($row['datetime']) * 1000 + 28800000,
        floatval($row['dht22_temp'])
    );}

// Convert the data to JSON format and send the response
header('Content-Type: application/json');

echo json_encode($dht22_tempData);
?>
