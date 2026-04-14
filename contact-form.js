function openContactForm() {
    document.getElementById('contactModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeContactForm() {
    document.getElementById('contactModal').classList.remove('active');
    document.body.style.overflow = '';
}

// отправка данных на сервер
function submitContactForm(event) {
    event.preventDefault();

    const form = document.getElementById('contactForm');
    const formData = new FormData(form);

    // отправка данных на php обработчик
    fetch('/backend/contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text); });
        }
        return response.text();
    })
    .then(message => {
        closeContactForm();
        showSuccessNotification();
        form.reset();
    })
    .catch(error => {
        alert('Ошибка: ' + error.message);
    });
}

// уведа об успехе
function showSuccessNotification() {
    const success = document.getElementById('contactSuccess');
    success.classList.add('active');
    setTimeout(() => success.classList.remove('active'), 5000);
}

// закрытие через эскейп
document.addEventListener('click', function(event) {
    const modal = document.getElementById('contactModal');
    if (event.target === modal) {
        closeContactForm();
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeContactForm();
    }
});
