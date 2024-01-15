<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo "Welcome to the member's area, " . htmlspecialchars($_SESSION['username']) . "!";
    ?>

<style>
    body {
        text-align: center;
        font-family: Arial, sans-serif;
    }

    #appointmentsContainer {
        margin: auto;
        width: 80%;
    }

    #appointmentsTable {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    #appointmentsTable th, #appointmentsTable td {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #appointmentsTable tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #appointmentsTable th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #4CAF50;
        color: white;
    }

    button {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }

    button:hover {
        background-color: #d32f2f;
    }
</style>

<div id="appointmentsContainer">
    <h2>Your Appointments</h2>
    <table id="appointmentsTable" border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Appointment ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Appointment Time</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="appointmentsList"></tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetchAppointments();
    });

    function fetchAppointments() {
        fetch('http://vhost1.localhost/config/get_appointments.php')
            .then(response => response.json())
            .then(appointments => {
                const appointmentsList = document.getElementById('appointmentsList');
                appointmentsList.innerHTML = ''; 
                appointments.forEach(appointment => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${appointment.id}</td>
                        <td>${appointment.appointment_id}</td>
                        <td>${appointment.name}</td>
                        <td>${appointment.phone}</td>
                        <td>${appointment.appointment_time}</td>
                        <td>${appointment.created_at}</td>
                        <td><button onclick="deleteAppointment(${appointment.id})">Delete</button></td>
                    `;
                    appointmentsList.appendChild(row);
                });
            })
            .catch(error => console.error('Error fetching appointments:', error));
    }

    function deleteAppointment(appointmentId) {
        if (!confirm('Are you sure you want to delete this appointment?')) {
            return;
        }
        fetch(`http://vhost1.localhost/config/delete_appointment.php?id=${appointmentId}`, { method: 'DELETE' })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Appointment deleted successfully.');
                    fetchAppointments(); 
                } else {
                    alert('Error deleting appointment');
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>


    <?php
} else {
    echo "Please log in first to see this page.";
}
?>
