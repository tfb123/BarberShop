<?php
require_once 'config.php';

$conn = getDBConnection();

if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM appointments WHERE id = ?");
    $stmt->bind_param('i', $appointmentId);

    $response = array();
    if ($stmt->execute()) {
        $response['status'] = 'success';
    } else {
        $response['status'] = 'error';
    }

    echo json_encode($response);

    $stmt->close();
}

$conn->close();
?>
