<?php
/* Database connection - Services Non-GST, PHP 8.3 compatible.
 * Database is `services_non_gst`.
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "services_non_gst";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn_services = mysqli_connect($servername, $username, $password, $dbname);
    mysqli_set_charset($conn_services, "utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log("Services DB connection failed: " . $e->getMessage());
    http_response_code(500);
    die("Services Database connection failed. Please contact administrator.");
}
?>
