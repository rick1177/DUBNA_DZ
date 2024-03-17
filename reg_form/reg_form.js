document.addEventListener("DOMContentLoaded", function() {
    // Действия для полей ввода имени, отчества и фамилии
    const nameInputs = ["name_", "mname_", "sname_"];

    nameInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener("input", function(event) {
                let inputValue = event.target.value;
                let newValue = inputValue.replace(/[^А-Яа-яЁё]/g, '');
                event.target.value = newValue;
            });
        }
    });

    // Действия для чекбокса "Выступление с докладом"
    var reportCheckbox = document.getElementById("report");
    var reportCheckboxtext = document.getElementById("report_yes_no_checkbox");
    var topicTextarea = document.getElementById("topic");

    if (reportCheckbox) {
        reportCheckbox.addEventListener("change", () => {
            topicTextarea.value = ""; // Обнуляем поле темы доклада

            if (reportCheckbox.checked) {
                reportCheckboxtext.textContent = "ДА";
                topicTextarea.removeAttribute("readonly");
                topicTextarea.removeAttribute("disabled");
            } else {
                reportCheckboxtext.textContent = "НЕТ";
                topicTextarea.setAttribute("readonly", true);
                topicTextarea.setAttribute("disabled", true);
            }
        });
    }

    // Действия для поля email
    const emailInput = document.getElementById("email");

    if (emailInput) {
        emailInput.addEventListener("input", function(event) {
            let inputValue = event.target.value;

            // Удаляем все символы, кроме латинских букв, цифр и допустимых символов в email
            let newValue = inputValue.replace(/[^\w.%+-@]/gi, '');

            // Проверяем, изменилось ли значение поля
            if (inputValue !== newValue) {
                // Если значение изменилось, обновляем значение поля
                event.target.value = newValue;
            }
        });
    }

    // Ограничения для ввода в поле с телефоном
    const phoneInput = document.getElementById("phone");
    let isFirstDigit = true;

    if (phoneInput) {
        phoneInput.addEventListener("input", function(event) {
            let inputValue = event.target.value;

            // Удаляем все символы, кроме цифр
            let newValue = inputValue.replace(/\D/g, '');
            //let newValue = inputValue.replace(/[^\d\s]/g, '');

            // Форматируем номер телефона
            let formattedValue = formatPhoneNumber(newValue);

            // Обновляем значение поля
            event.target.value = formattedValue;
        });
    }

    function formatPhoneNumber(phoneNumber) {
        let formattedPhoneNumber = "";
        let firstTwoChars = "+7";

        if (phoneNumber.length <2) {
            formattedPhoneNumber = firstTwoChars;
        }
        if (phoneNumber.length >= 2) {
            formattedPhoneNumber = firstTwoChars+ " (" + phoneNumber.substring(1, 4);
        }
        if (phoneNumber.length >= 5) {
            formattedPhoneNumber += ") " + phoneNumber.substring(4, 7);
        }
        if (phoneNumber.length >= 8) {
            formattedPhoneNumber += " " + phoneNumber.substring(7, 9);
        }
        if (phoneNumber.length >= 10) {
            formattedPhoneNumber += " " + phoneNumber.substring(9, 11);
        }
        if (phoneNumber.length > 12) {
            formattedPhoneNumber = formattedPhoneNumber;
        }

        return formattedPhoneNumber;
    }

    // Вызываем функцию после загрузки формы
    formLoaded();
});

// Функция, которая будет вызвана после загрузки формы
function formLoaded() {
    // Ваш код для работы с формой после ее загрузки
    // Например, ваши обработчики событий, валидация формы и т.д.
}
