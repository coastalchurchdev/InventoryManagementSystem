<?php
$servername = 'pims.gocoastal.org';
$database = 'dbzopdgnyog8xp';
$username = 'ulx7wzfgibdht';
$password = 'gr1@dc8&2~v@';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";