import jQuery from "jquery";
window.$ = window.jQuery = jQuery;
import validate from 'jquery-validation';

export const validator = function () {
    // console.log("TEST1");
    function validateForm (form){
        // console.log("TEST2");
        let validation = $(form).validate({
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

        // console.log("TEST3");
        return validation.form();
    };


    $("form").submit(function (e) {
        e.preventDefault();
        if(validateForm(this) == true) {
            $('.client-form__loading').fadeIn();
        $.ajax({
            type: "POST",
            url: "mailer/smart.php",
            data: $(this).serialize()
        }).done(function () {
            $(this).find("input").val("");
            $("form").trigger("reset");

            $('.client-form__loading').fadeOut();
            $(".overlay .modal").fadeOut('slow');
            $(".overlay, #buy-done").fadeIn('slow');
        })
        }

        return false;
    });
}

