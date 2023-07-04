<?php
$servername = "localhost";
$username = "root";
$password = "QKV6yCs2ps.=";
$dbname = "xkj";
$connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT datetime, dht22_temp, dht22_humd, lm75_temp, cwb_temp, cwb_humd, esp_pm1, esp_pm25, esp_pm100, epa_pm25, epa_pm10
          FROM sensor_data
          ORDER BY datetime DESC
          LIMIT 10";

$result = mysqli_query($connection, $query);

$dht22_tempData = array();
$dht22_humdData = array();
$lm75_tempData = array();
$cwb_tempData = array();
$cwb_humd = array();
$esp_pm1Data = array();
$esp_pm25Data = array();
$esp_pm100Data = array();
$epa_pm25Data = array();
$epa_pm10Data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $dht22_tempData[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['dht22_temp'])
    );
    $dht22_humdData[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['dht22_humd'])
    );
    $lm75_tempData[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['lm75_temp'])
    );
    $cwb_tempData[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['cwb_temp'])
    );
    $cwb_humd[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['cwb_humd'])
    );
    $esp_pm1Data[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['esp_pm1'])
    );
    $esp_pm25Data[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['esp_pm25'])
    );
    $esp_pm100Data[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['esp_pm100'])
    );
    $epa_pm25Data[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['epa_pm25'])
    );
    $epa_pm10Data[] = array(
        strtotime($row['datetime']) * 1000,
        floatval($row['epa_pm10'])
    );
}
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL DATA</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="container1" style="width: 100%;"></div>
    <div id="container2" style="width: 100%;"></div>
    <div id="container3" style="width: 100%;"></div>
    <div id="container4" style="width: 100%;"></div>
    <div id="container5" style="width: 100%;"></div>
    <script type="text/javascript">
        function fetchData() {
            $.ajax({
                url: 'fetch_data.php', // Replace with the server-side script to fetch updated data
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var dht22_tempData = data.dht22_tempData;
                    var dht22_humdData = data.dht22_humdData;
                    var lm75_tempData = data.lm75_tempData;
                    var cwb_tempData = data.cwb_tempData;
                    var cwb_humd = data.cwb_humd;
                    var esp_pm1Data = data.esp_pm1Data;
                    var esp_pm25Data = data.esp_pm25Data;
                    var esp_pm100Data = data.esp_pm100Data;
                    var epa_pm25Data = data.epa_pm25Data;
                    var epa_pm10Data = data.epa_pm10Data;

                    // Update the chart data
                    chart1.series[0].setData(dht22_tempData);
                    chart1.series[1].setData(lm75_tempData);
                    chart1.series[2].setData(cwb_tempData);

                    chart2.series[0].setData(dht22_humdData);
                    chart2.series[1].setData(cwb_humd);

                    chart3.series[0].setData(esp_pm1Data);
                    chart3.series[1].setData(epa_pm10Data);

                    chart4.series[0].setData(esp_pm25Data);
                    chart4.series[1].setData(epa_pm25Data);

                    chart5.series[0].setData(esp_pm100Data);
                    chart5.series[1].setData(epa_pm10Data);
                }
            });
        }

        // Initial chart rendering
        var chart1 = Highcharts.chart('container1', {
            // Chart options...
        });

        var chart2 = Highcharts.chart('container2', {
            // Chart options...
        });

        var chart3 = Highcharts.chart('container3', {
            // Chart options...
        });

        var chart4 = Highcharts.chart('container4', {
            // Chart options...
        });

        var chart5 = Highcharts.chart('container5', {
            // Chart options...
        });

        // Fetch data initially
        fetchData();

        // Refresh data every 5 seconds
        setInterval(fetchData, 5000);
    </script>
</body>
</html>
