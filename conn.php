<?php

// MySQL Hostname / Server (for eg: 'localhost')
$host = 'localhost';

// MySQL Database Name
$database = 'Facet';

// MySQL Database User
$username = 'root';

// MySQL Database Password
$password = 'root';

// Create Connection
$conn = new mysqli($host,$username,$password,$database);

// Check Connection
if($conn->connect_error){
    echo 'Connection Failed: '.$conn->connect_error;
}
