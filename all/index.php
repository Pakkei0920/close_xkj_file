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
</head>
<body>
    <div id="container1" style="width: 100%;"></div>
    <div id="container2" style="width: 100%;"></div>
    <div id="container3" style="width: 100%;"></div>
    <div id="container4" style="width: 100%;"></div>
    <div id="container5" style="width: 100%;"></div>
<script type="text/javascript">
        var dht22_tempData = <?php echo json_encode($dht22_tempData); ?>;
        var dht22_humdData = <?php echo json_encode($dht22_humdData); ?>;
        var lm75_tempData = <?php echo json_encode($lm75_tempData); ?>;
        var cwb_tempData = <?php echo json_encode($cwb_tempData); ?>;
        var cwb_humd = <?php echo json_encode($cwb_humd); ?>;
        var esp_pm1Data = <?php echo json_encode($esp_pm1Data); ?>;
        var esp_pm25Data = <?php echo json_encode($esp_pm25Data); ?>;
        var esp_pm100Data = <?php echo json_encode($esp_pm100Data); ?>;
        var epa_pm25Data = <?php echo json_encode($epa_pm25Data); ?>;
        var epa_pm10Data = <?php echo json_encode($epa_pm10Data); ?>;

        Highcharts.chart('container1', {
            title: {
                text: 'Temperature (°C)'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    second: '%m-%d<br/>%H:%M:%S',
                    minute: '%m-%d<br/>%H:%M',
                    hour: '%m-%d<br/>%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%m',
                }
            },
            series: [{
                name: 'DHT22',
                data: dht22_tempData,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            },
            {
                name: 'LM75',
                data: lm75_tempData,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            },
            {
                name: 'CWB',
                data: cwb_tempData,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            }]
        });

        Highcharts.chart('container2', {
            title: {
                text: 'Humidity (°F)'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    second: '%m-%d<br/>%H:%M:%S',
                    minute: '%m-%d<br/>%H:%M',
                    hour: '%m-%d<br/>%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%m',
                }
            },
            series: [{
                name: 'DHT22',
                data: dht22_humdData,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            },
            {
                name: 'CWB',
                data: cwb_humd,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            }]
        });

        Highcharts.chart('container3', {
            title: {
                text: 'PM1.0'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    second: '%m-%d<br/>%H:%M:%S',
                    minute: '%m-%d<br/>%H:%M',
                    hour: '%m-%d<br/>%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%m',
                }
            },
            series: [{
                name: 'ESP PM1.0',
                data: esp_pm1Data,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            },
            {
                name: 'EPA PM1.0',
                data: epa_pm10Data,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            }]
        });

        Highcharts.chart('container4', {
            title: {
                text: 'PM2.5'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    second: '%m-%d<br/>%H:%M:%S',
                    minute: '%m-%d<br/>%H:%M',
                    hour: '%m-%d<br/>%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%m',
                }
            },
            series: [{
                name: 'ESP PM2.5',
                data: esp_pm25Data,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            },
            {
                name: 'EPA PM2.5',
                data: epa_pm25Data,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            }]
        });

        Highcharts.chart('container5', {
            title: {
                text: 'PM10'
            },
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    second: '%m-%d<br/>%H:%M:%S',
                    minute: '%m-%d<br/>%H:%M',
                    hour: '%m-%d<br/>%H:%M',
                    day: '%m-%d',
                    week: '%m-%d',
                    month: '%m',
                }
            },
            series: [{
                name: 'ESP PM10',
                data: esp_pm100Data,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            },
            {
                name: 'EPA PM10',
                data: epa_pm10Data,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f}' // Display two decimal places
                }
            }]
        });
    </script>
</body>
</html>
