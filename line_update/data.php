<?php
// Fetch data from your data source
// Replace this with your own logic to fetch the updated data
$data = [
    time() * 1000, // Use the current timestamp as x-value
    rand(0, 100) // Use random data for y-value
];

// Return the data in JSON format
echo json_encode($data);
?>
