<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';

$name = $_POST['name'];
$phone = $_POST['telephone'];
$email = $_POST['email'];

//Load Composer's autoloader

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
	$mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'bredtv6@gmail.com';                     //SMTP username
    $mail->Password   = 'icrzibusutqzncly';                          //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('bredtv6@gmail.com', 'Pulse');
    $mail->addAddress(''. $email .'');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Ваше замовлення на Pulse';
    $mail->Body    = '<!DOCTYPE html><html lang="uk"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="color-scheme" content="light dark"><meta name="supported-color-schemes" content="light dark only"><style>*{
        margin: 0px;
        padding: 0px;
    }
    
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap");
    
    @media (prefers-color-scheme: dark) {
        .main {
            background: #000000 !important;
        }
        h1, h2, h3, p, a {
            color: #00ff88 !important;
        }
        .portfolio {
            background-color: #053720  !important;
        }
        .light {
            display: none !important;
        }
        .dark {
            display: unset !important;
        }
    }
    @media (prefers-color-scheme: light) {
        .light {
            display: unset !important;
        }
        .dark {
            display: none !important;
        }
    }
    
    @media (max-width: 575px) {
        div > u + .body .light {
        display: none !important;
        }
        div > u + .body .dark {
            display: unset !important;
        }
        div > u + .body .main {
            background: #000000 !important;
        }
        div > u + .body h1, h2, h3, p, a {
            color: #00ff88 !important;
        }
        div > u + .body .portfolio {
            background-color: #053720  !important;
        }
    }</style></head><body class="body"><table class="main" width="512" align="center" style="padding: 30px;
    border-radius: 30px;
    font-family: Roboto, Helvetica, Arial, Verdana;
    background: #00ff88;
    background: linear-gradient(90deg, #00ff88 0%, #61efff 100%);
    background: -moz-linear-gradient(90deg, #00ff88 0%, #61efff 100%);
    background: -webkit-linear-gradient(90deg, #00ff88 0%, #61efff 100%);"><tbody><tr><td><img class="light" src="https://i.imgur.com/e2agLLZ.png" alt="logo"> <img class="dark" style="display: none;" src="https://i.imgur.com/ATyQnI2.png" alt="logo"><table><tbody><tr><td><div class="gmail-blend-screen"><div class="gmail-blend-difference"><h1 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 30px;font-weight: 700;text-transform: uppercase;">Дякую за замовлення</h1></div></div><table><tbody><tr><td><div class="gmail-blend-screen"><div class="gmail-blend-difference"><h2 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 20px;font-weight: 700;text-transform: uppercase;">'. $name .', хоч я і не магазин з привабливими товарами..</h2></div></div></td></tr><tr></tr></tbody></table><table><tbody><tr><td><h3 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 18px;font-weight: 500;">Але, в мене є, чим <b style="font-weight: 700;/* color: #c70101; */font-size: 23px;">зацікавити…</b></h3><table><tbody><tr><td width="80%"><p style="margin-top: 20px; color: black;font-size: 18px;font-weight: 300;line-height: 27px;margin-bottom: 27px;">Є ще кілька демо-проєктів, які демонструють мої навички. Подивіться на них у моєму <a class="portfolio" target="_blank" style="background-color: #000000;color: #15fca1;font-weight: 700;border-radius: 30px;padding: 2px 7px 6px 7px;text-decoration: none;" href="https://kyrylofolio.pro/" data-saferedirecturl="https://www.google.com/url?q=https://kyrylofolio.pro/">портфоліо</a></p><table><tbody><tr><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https://github.com/Qunthunnan"><img class="light" src="https://i.imgur.com/qkQgSiX.png" alt="github"> <img class="dark" style="display: none;" src="https://i.imgur.com/WiqO7Cm.png" alt="github"> Github</a></td><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https://t.me/Qunthunnan0"><img class="light" src="https://i.imgur.com/jYDMH0s.png" alt="telegram"> <img class="dark" style="display: none;" src="https://i.imgur.com/yZ0NUXU.png" alt="telegram"> Telegram</a></td><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https://www.facebook.com/kirylo.bashkan"><img class="light" src="https://i.imgur.com/sUjMbB5.png" alt="facebook"> <img class="dark" style="display: none;" src="https://i.imgur.com/ZCYBArE.png" alt="facebook"> Facebook</a></td></tr></tbody></table></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></body></html>';

    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}