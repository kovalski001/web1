function openContactForm() {
    document.getElementById('contactModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeContactForm() {
    document.getElementById('contactModal').classList.remove('active');
    document.body.style.overflow = '';
}

function submitContactForm(event) {
    event.preventDefault();

    const form = document.getElementById('contactForm');
    const formData = new FormData(form);

    // Укажите ваш endpoint от Formspree (он уже есть)
    fetch('https://formspree.io/f/xnjbrlna', {
        method: 'POST',
        body: formData,
        headers: { 'Accept': 'application/json' }
    })
    .then(response => {
        if (response.ok) {
            closeContactForm();
            showSuccessNotification();
            form.reset();
        } else {
            alert('Ошибка отправки. Попробуйте позже.');
        }
    })
    .catch(() => alert('Ошибка соединения.'));
}

function showSuccessNotification() {
    const success = document.getElementById('contactSuccess');
    success.classList.add('active');
    setTimeout(() => success.classList.remove('active'), 4000);
}

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
