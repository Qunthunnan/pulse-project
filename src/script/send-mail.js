$(document).ready(function() {

    $("form").submit(function (e) {
        e.preventDefault();
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
            $("#buy-done").fadeIn('slow');
        })
        return false;
    });
});