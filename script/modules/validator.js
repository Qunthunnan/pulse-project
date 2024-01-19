import validate from 'jquery-validation';
const ditictionary = require('../../ditictionary.json');
const lang = document.documentElement.getAttribute('lang');

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
                    minlength: ditictionary['messagesNameLength'][lang],
                    required: ditictionary['messagesName'][lang],
                },
                telephone: ditictionary['messagesPhone'][lang],
                email: {
                    required: ditictionary['messagesEmail'][lang],
                    email: ditictionary['messagesEmailCorrect'][lang],
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
            const formData = new FormData(e.target);
            formData.append('lang', lang);
            const userData = $.param(Object.fromEntries(formData.entries()));
        $.ajax({
            type: "POST",
            url: "/pulse/smart.php",
            data: userData
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

