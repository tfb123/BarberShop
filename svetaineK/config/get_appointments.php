<?php
require_once 'config.php';

$conn = getDBConnection();

$query = "SELECT id, appointment_id, name, phone, appointment_time, created_at FROM appointments";
$result = $conn->query($query);

$appointments = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
    $result->free();
}

header('Content-Type: application/json');
echo json_encode($appointments);

$conn->close();
?>