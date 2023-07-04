<?php
$host = "localhost";
$username = "root";
$password = "QKV6yCs2ps.=";
$database = "xkj";

// Create a new PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

// Fetch data from the database
$query = "SELECT dht22_temp
          FROM sensor_data
          ORDER BY datetime DESC
          LIMIT 10";
$result = $pdo->query($query);

// Prepare the data for Highcharts
$data = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $category = $row['category'];
    $value = intval($row['value']);
    $data[] = array($category, $value);
}

// Convert the data to JSON format
$jsonData = json_encode($data);

// Close the database connection
$pdo = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dynamically Updated Highcharts Example</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="container" style="width: 100%; height: 400px;"></div>

    <script type="text/javascript">
        // Function to fetch updated data from the server
        function fetchData() {
            $.ajax({
                url: 'fetch_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Update the chart with the new data
                    chart.series[0].setData(data);
                }
            });
        }

        // Generate the initial chart using Highcharts
       var chart = Highcharts.chart('container', {
    title: {
        text: 'Dynamic Chart'
    },
    xAxis: {
        type: 'datetime', // Change the type to 'datetime'
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
        type: 'line',  // Change the type to 'line'
        data: <?php echo $jsonData; ?>
    }]
});



        // Fetch data every 5 seconds
        setInterval(fetchData, 5000);
    </script>
</body>
</html>