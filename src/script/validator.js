$(document).ready(function(){

    function validateForm (form){
        $(form).validate({
            rules: {
                name: {
                    required: true,
                    minlength: 2
                },
                telephone: {
                    required: true
                },
                email: {
                    required: true
                }
            },
            messages: {
                name: {
                    minlength: "Мінімальна кількість букв для імені: 2",
                    required: "Будь ласка, напишіть своє ім'я"
                },
                telephone: "Будь ласка, напишіть свій телефон",
                email: {
                    required: "Будь ласка, напишіть свою електронну скриньку",
                    email: "Перевірте, чи правильно написана адреса, не забудьте @"
                }
            },
            errorClass: "client-form__error"
        });
    };

    validateForm('#consultation form');
    validateForm('#buy form');
    validateForm('.client-form_consultation');
});