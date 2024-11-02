<?php
$servername = "localhost"; // Your server name
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "food"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the 'shopowners' table
$sql = "CREATE TABLE IF NOT EXISTS shopowners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    shop_name VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// Execute the query and check if it was successful
if ($conn->query($sql) === TRUE) {
    echo "Table 'shopowners' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


?>