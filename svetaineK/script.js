let appointments = [];

document.addEventListener('DOMContentLoaded', function () {
    fetchAppointments();
    setupEventListeners();

    document.getElementById('loginButton').addEventListener('click', function() {
        window.location.href = 'admin/login.php';
    });
});

function setupEventListeners() {
    const dateInput = document.getElementById('appointmentDate');
    const timeSlotsContainer = document.getElementById('timeSlots');
    const bookingForm = document.getElementById('bookingForm');

    dateInput.addEventListener('change', function () {
        generateTimeSlots(timeSlotsContainer, dateInput.value);
    });

    bookingForm.addEventListener('submit', function (e) {
        e.preventDefault();
        submitAppointmentForm();
    });

    window.addEventListener('click', function (event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    });
}

function fetchAppointments() {
    fetch('../config/get_appointments.php')
        .then(response => response.json())
        .then(data => {
            appointments = data;
        })
        .catch(error => console.error('Error fetching appointments:', error));
}

function generateTimeSlots(container, selectedDate) {
    container.innerHTML = '';
    const startTime = 9;
    const endTime = 18;

    for (let hour = startTime; hour < endTime; hour++) {
        createButton(hour, 0, container, selectedDate);
        createButton(hour, 30, container, selectedDate);
    }
}

function createButton(hour, minutes, container, selectedDate) {
    const formattedTime = `${hour.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;
    const timeButton = document.createElement('button');
    timeButton.textContent = formattedTime;
    timeButton.classList.add('time-slot');

    if (isTimeSlotBooked(selectedDate, formattedTime)) {
        timeButton.classList.add('booked');
        timeButton.disabled = true;
    } else {
        timeButton.addEventListener('click', function () {
            showBookingForm(selectedDate, formattedTime);
        });
    }

    container.appendChild(timeButton);
}

function isTimeSlotBooked(date, time) {
    const dateTime = `${date} ${time}`;
    return appointments.some(appointment => appointment.appointment_time.startsWith(dateTime));
}

function showBookingForm(date, time) {
    const modal = document.getElementById('bookingModal');
    modal.style.display = 'block';
    document.getElementById('appointmentTime').value = `${date} ${time}`;
    document.querySelector('.modal-title').textContent = `Book Appointment for ${date} at ${time}`;
}

function submitAppointmentForm() {
    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const appointmentTime = document.getElementById('appointmentTime').value;

    fetch('../config/save_appointment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name: name, phone: phone, appointment_time: appointmentTime })
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            displayConfirmationModal(data.appointment_id);
            fetchAppointments();
        } else {
            console.error('Error saving appointment:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function displayConfirmationModal(appointmentId) {
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmationMessage = document.getElementById('confirmationMessage');
    confirmationMessage.textContent = `Your appointment ID is ${appointmentId}`;
    confirmationModal.style.display = 'block';
    closeBookingModal();
}

function closeBookingModal() {
    document.getElementById('bookingModal').style.display = 'none';
}

function closeConfirmationModal() {
    document.getElementById('confirmationModal').style.display = 'none';
}

const confirmationModalHTML = `
<div id="confirmationModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeConfirmationModal()">&times;</span>
        <h3>Appointment Confirmation</h3>
        <p id="confirmationMessage"></p>
        <button onclick="closeConfirmationModal()">Close</button>
    </div>
</div>
`;

document.body.insertAdjacentHTML('beforeend', confirmationModalHTML);

document.querySelectorAll('.close').forEach(button => {
    button.addEventListener('click', function() {
        button.closest('.modal').style.display = 'none';
    });
});
