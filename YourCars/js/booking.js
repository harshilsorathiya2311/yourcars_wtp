// Form validation for test drive booking
function validateBookingForm() {
    const phone = document.getElementById('phone').value;
    const phoneRegex = /^[0-9+\-\s()]{7,15}$/;

    if (!phoneRegex.test(phone)) {
        alert('Please enter a valid phone number.');
        return false;
    }

    const dateInput = document.getElementById('date').value;
    const selectedDate = new Date(dateInput);
    const today = new Date();
    today.setHours(0,0,0,0);

    if (selectedDate < today) {
        alert('Test drive date cannot be in the past.');
        return false;
    }

    return true;
}
