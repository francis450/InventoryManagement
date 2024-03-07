<?php

// Include config file
require_once 'config.php';

// Extract database configuration from config array
$db_config = $config['db'];

// Extract base URL from config array
$base_url = $config['base_url'];

// Establish database connection
try {
    $pdo = new PDO("mysql:host={$db_config['host']};dbname={$db_config['database']}", $db_config['username'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());


// Start session    
session_start();

// Define base URL
define('BASE_URL', $base_url);

// Include necessary files
// require_once 'functions.php'; // Include functions file
// You can include more files here as needed

// redirect to index page
header('Location: index.php#bx');

?>
