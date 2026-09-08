<?php
$mysqli = new mysqli('localhost', 'root', '');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error . "\n");
}
echo "Connected to MySQL successfully\n";
$mysqli->query('CREATE DATABASE IF NOT EXISTS ci4 CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
echo "Database ci4 created/verified\n";
$mysqli->close();