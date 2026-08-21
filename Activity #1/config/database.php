<?php

declare(strict_types=1);

$databaseHost = getenv('DB_HOST') ?: 'localhost';
$databasePort = getenv('DB_PORT') ?: '3306';
$databaseName = getenv('DB_NAME') ?: 'de_guzman_resort';
$databaseUser = getenv('DB_USER') ?: 'resort_app';
$databasePassword = getenv('DB_PASSWORD') ?: 'ResortLocal2026!';

$dataSourceName = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
    $databaseHost,
    $databasePort,
    $databaseName
);

try {
    $pdo = new PDO(
        $dataSourceName,
        $databaseUser,
        $databasePassword,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    exit('Database connection failed. Run database/de_guzman_resort.sql in MySQL Workbench first.');
}
