<!DOCTYPE html>
<html>
<head>
    <title>Highcharts Dynamically Updated Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/stock.js"></script>
</head>
<body>
    <div id="chartContainer" style="height: 400px; width: 100%;"></div>

    <script>
        // Initialize the chart
        var chart = Highcharts.stockChart('chartContainer', {
            rangeSelector: {
                buttons: [{
                    count: 1,
                    type: 'minute',
                    text: '1M'
                }, {
                    count: 5,
                    type: 'minute',
                    text: '5M'
                }, {
                    type: 'all',
                    text: 'All'
                }],
                inputEnabled: false,
                selected: 0
            },
            title: {
                text: 'Dynamically Updated Highcharts'
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 5 * 60 * 1000 // 5 minutes
            },
            yAxis: {
                title: {
                    text: 'Value'
                }
            },
            series: [{
                name: 'Data',
                data: []
            }]
        });

        // Function to request data from the server
        function requestData() {
            $.ajax({
                url: 'data.php', // PHP file that returns updated data in JSON format
                success: function (data) {
                    var series = chart.series[0];
                    var shift = series.data.length > 20; // Shift the series if data exceeds 20 points

                    // Add the new data point
                    chart.series[0].addPoint(data, true, shift);

                    // Call the function again after a specific interval (e.g., 1 minute)
                    setTimeout(requestData, 60 * 1000);
                },
                cache: false
            });
        }

        // Fetch initial data when the chart is loaded
        requestData();
    </script>
</body>
</html>
