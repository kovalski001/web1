// открыть форму обратной связи
function openContactForm() {
    const modal = document.getElementById('contactModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// закрыть форму обратной связи
function closeContactForm() {
    const modal = document.getElementById('contactModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// отправить форму
function submitContactForm(event) {
    event.preventDefault();
    
    const name = document.getElementById('contactName').value;
    const phone = document.getElementById('contactPhone').value;
    const service = document.getElementById('contactService').value;
    const message = document.getElementById('contactMessage').value;
    
    // Собираем данные формы
    const formData = {
        name: name,
        phone: phone,
        service: service,
        message: message,
        timestamp: new Date().toISOString()
    };
    
    // Логируем данные (в реальном проекте здесь будет отправка на сервер)
    console.log('Отправка формы обратной связи:', formData);
    
    // закрываем форму
    closeContactForm();
    
    // показываем уведомление об успехе
    showSuccessNotification();
    
    // очищаем форму
    document.getElementById('contactForm').reset();
}

// показать уведомление об успешной отправке
function showSuccessNotification() {
    const success = document.getElementById('contactSuccess');
    success.classList.add('active');
    
    // скрываем через 4 секунды
    setTimeout(() => {
        success.classList.remove('active');
    }, 4000);
}

// закрытие модального окна при клике вне его
document.addEventListener('click', function(event) {
    const modal = document.getElementById('contactModal');
    if (event.target === modal) {
        closeContactForm();
    }
});

// закрытие модального окна по клавише esc
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeContactForm();
    }
});

// для телефона
document.addEventListener('DOMContentLoaded', function() {
    const phoneInput = document.getElementById('contactPhone');
    
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 0) {
                if (value[0] === '7' || value[0] === '8') {
                    value = value.substring(1);
                }
                
                let formatted = '+7';
                
                if (value.length > 0) {
                    formatted += ' (' + value.substring(0, 3);
                }
                if (value.length > 3) {
                    formatted += ') ' + value.substring(3, 6);
                }
                if (value.length > 6) {
                    formatted += '-' + value.substring(6, 8);
                }
                if (value.length > 8) {
                    formatted += '-' + value.substring(8, 10);
                }
                
                e.target.value = formatted;
            }
        });
    }
});

// анимация появления кнопки при скролле
let contactButton = document.getElementById('contactButton');
let lastScrollTop = 0;

window.addEventListener('scroll', function() {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 300) {
        contactButton.style.opacity = '1';
        contactButton.style.visibility = 'visible';
    } else {
        contactButton.style.opacity = '0';
        contactButton.style.visibility = 'hidden';
    }
    
    lastScrollTop = scrollTop;
});

// инициализация - кнопка скрыта изначально
document.addEventListener('DOMContentLoaded', function() {
    contactButton.style.opacity = '0';
    contactButton.style.visibility = 'hidden';
    contactButton.style.transition = 'opacity 0.3s, visibility 0.3s';
});
