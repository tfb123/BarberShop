<?php
require_once 'config.php';

function generateUniqueAppointmentId($conn) {
    $id = mt_rand(1000000, 9999999);
    $checkQuery = $conn->prepare("SELECT COUNT(*) FROM appointments WHERE appointment_id = ?");
    $checkQuery->bind_param('i', $id);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $row = $result->fetch_row();
    if ($row[0] > 0) {
        return generateUniqueAppointmentId($conn);
    }
    return $id;
}

$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$phone = $data['phone'];
$appointment_time = $data['appointment_time'];

$conn = getDBConnection();

$appointmentId = generateUniqueAppointmentId($conn);

$stmt = $conn->prepare("INSERT INTO appointments (appointment_id, name, phone, appointment_time) VALUES (?, ?, ?, ?)");
$stmt->bind_param('isss', $appointmentId, $name, $phone, $appointment_time);

$response = array();
if ($stmt->execute()) {
    $response['status'] = 'success';
    $response['appointment_id'] = $appointmentId;
} else {
    $response['status'] = 'error';
    $response['message'] = 'Could not create the appointment.';
}

echo json_encode($response);

$stmt->close();
$conn->close();
?>
