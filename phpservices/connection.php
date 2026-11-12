<?php

/*
 * Database connection – Jayam Hydraulic Engineering (Spares)
 * PHP 8.3 | MySQL 8.0
 *
 * Development/debug version
 */

// ─────────────────────────────────────────────────────────────
// ERROR REPORTING
// ─────────────────────────────────────────────────────────────

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

mysqli_report(MYSQLI_REPORT_OFF);


// ─────────────────────────────────────────────────────────────
// ENVIRONMENT DETECTION
// ─────────────────────────────────────────────────────────────

$__host = strtolower(
    $_SERVER['HTTP_HOST']
    ?? $_SERVER['SERVER_NAME']
    ?? 'localhost'
);

$__is_local = (
    $__host === 'localhost' ||
    $__host === '127.0.0.1' ||
    $__host === '::1' ||
    strpos($__host, 'localhost:') === 0
);


// ─────────────────────────────────────────────────────────────
// DATABASE CONFIGURATION
// ─────────────────────────────────────────────────────────────

if ($__is_local) {

    // Local XAMPP
    $servername = "localhost";
    $username   = "root";
    $password   = "";
    $dbname     = "jmt_jeyam_billing";

} else {

    // Production
    $servername = "localhost";
    $username   = "jmt_jeyam_billing";
    $password   = "7x4YV*tH#T4M";
    $dbname     = "jmt_jeyam_billing";
}

$master_db = $dbname;


// ─────────────────────────────────────────────────────────────
// DATABASE CONNECTION
// ─────────────────────────────────────────────────────────────

$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);


// ─────────────────────────────────────────────────────────────
// CONNECTION ERROR
// ─────────────────────────────────────────────────────────────

if (!$conn) {

    $error = mysqli_connect_error();

    error_log("DB connection failed: " . $error);

    http_response_code(500);

    die(
        "<h3>Database Connection Error</h3>" .
        "<p><strong>Host:</strong> " . htmlspecialchars($servername) . "</p>" .
        "<p><strong>Database:</strong> " . htmlspecialchars($dbname) . "</p>" .
        "<p><strong>User:</strong> " . htmlspecialchars($username) . "</p>" .
        "<p><strong>Error:</strong> " . htmlspecialchars($error) . "</p>"
    );
}


// ─────────────────────────────────────────────────────────────
// SET CHARACTER SET
// ─────────────────────────────────────────────────────────────

if (!mysqli_set_charset($conn, "utf8mb4")) {

    $error = mysqli_error($conn);

    die(
        "<h3>Charset Error</h3>" .
        "<p>" . htmlspecialchars($error) . "</p>"
    );
}


// ─────────────────────────────────────────────────────────────
// SET COLLATION
// ─────────────────────────────────────────────────────────────

if (!mysqli_query(
    $conn,
    "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
)) {

    $error = mysqli_error($conn);

    die(
        "<h3>SET NAMES Error</h3>" .
        "<p>" . htmlspecialchars($error) . "</p>"
    );
}


// ─────────────────────────────────────────────────────────────
// MYSQL SQL MODE
// ─────────────────────────────────────────────────────────────

if (!mysqli_query(
    $conn,
    "SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'"
)) {

    $error = mysqli_error($conn);

    die(
        "<h3>SQL Mode Error</h3>" .
        "<p>" . htmlspecialchars($error) . "</p>"
    );
}


// ─────────────────────────────────────────────────────────────
// TIMEZONE – INDIA / IST
// ─────────────────────────────────────────────────────────────

if (!mysqli_query(
    $conn,
    "SET time_zone = '+05:30'"
)) {

    $error = mysqli_error($conn);

    die(
        "<h3>Timezone Error</h3>" .
        "<p>" . htmlspecialchars($error) . "</p>"
    );
}


// ─────────────────────────────────────────────────────────────
// CONNECTION SUCCESS
// ─────────────────────────────────────────────────────────────

// Uncomment this temporarily if you want to confirm connection:
//
// echo "Database connected successfully.<br>";
// echo "Host: " . htmlspecialchars($servername) . "<br>";
// echo "Database: " . htmlspecialchars($dbname) . "<br>";
// echo "User: " . htmlspecialchars($username) . "<br>";
// echo "PHP Version: " . PHP_VERSION . "<br>";
// echo "MySQL Version: " . mysqli_get_server_info($conn) . "<br>";

?>