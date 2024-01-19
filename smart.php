<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer/PHPMailer.php';
require 'PHPMailer/PHPMailer/SMTP.php';

include 'secrets.php';

// Функція для отримання IP-адреси користувача
function getUserIP() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
        $ip = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));
    }
    return $ip;
}

// Збереження даних в файл users.json
function saveUsersData($data) {
    $file = '../users/users.json';
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Отримання кількості відправлених POST запитів за останню хвилину
function getRequestsCountLastMinute($usersData) {
    $count = 0;
    foreach ($usersData as $value) {
        if (time() - $value['timestamp'] <= 60) {
            $count++;
        }
    }
    return $count;
}

function getRequestsCountLastDay($usersData) {
    $count = 0;
    foreach ($usersData as $value) {
        if (time() - $value['timestamp'] <= 86400) {
            $count++;
        }
    }
    return $count;
}

function getRequestsCountByIp($ip, $usersData) {
    $count = 0;
    foreach ($usersData as $userData) {
        if ($userData['ip'] === $ip) {
            $count++;
        }
    }
    return $count;
}

function sendMail($messageBody, $subject, $email, $secrets) {
    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $secrets->mails[0];
        $mail->Password   = $secrets->passwords[0];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom($secrets->mails[0], 'Pulse');
        $mail->addAddress(''. $email .'');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $messageBody;
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$name = $_POST['name'];
$phone = $_POST['telephone'];
$email = $_POST['email'];
$lang = $_POST['lang'];

if(isset($name, $phone, $email)) {
    $userData = [
        "name" => $name,
        "email" => $email,
        "ip" => getUserIP()
    ];

    $file = '../users/users.json';
    $usersData = [];
    if (file_exists($file)) {
        $data = file_get_contents($file);
        $usersData = json_decode($data, true);
    }

    $pulseMessageBody = [
        'en' => '<!DOCTYPE html><html lang="uk"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"> <meta name="color-scheme" content="light dark"><meta name="supported-color-schemes" content="light dark only"><style>*{
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
             background-color: #053720 !important;
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
             background-color: #053720 !important;
         }
     }</style></head><body class="body"><table class="main" width="512" align="center" style="padding: 30px;
     border-radius: 30px;
     font-family: Roboto, Helvetica, Arial, Verdana;
     background: #00ff88;
     background: linear-gradient(90deg, #00ff88 0%, #61efff 100%);
     background: -moz-linear-gradient(90deg, #00ff88 0%, #61efff 100%);
     background: -webkit-linear-gradient(90deg, #00ff88 0%, #61efff 100%);"><tbody><tr><td><img class="light" src="https://i.imgur.com/e2agLLZ.png" alt="logo"> <img class="dark" style="display: none;" src="https://i.imgur.com/ATyQnI2.png" alt="logo" ><table><tbody><tr><td><div class="gmail-blend-screen"><div class="gmail-blend-difference"><h1 class="gmailAndroid" style="margin-top : 20px; color: black;font-size: 30px;font-weight: 700;text-transform: uppercase;">Thank you for your order</h1></div></div><table><tbody><tr><td ><div class="gmail-blend-screen"><div class="gmail-blend-difference"><h2 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 20px;font-weight: 700;text-transform: uppercase;">'. $userData['name'] .', although I am not a store with attractive products..</h2> </div></div></td></tr><tr></tr></tbody></table><table><tbody><tr><td><h3 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 18px;font-weight: 500;">But I have what <b style="font-weight: 700;/* color: #c70101; */font-size: 23px;">interest…</b></h3><table><tbody><tr><td width="80%"><p style="margin-top: 20px; color: black;font-size: 18px;font-weight: 300;line-height: 27px;margin-bottom: 27px;">There are a few more demo projects that showcase my skills. Check them out in my <a class ="portfolio" target="_blank" style="background-color: #000000;color: #15fca1;font-weight: 700;border-radius: 30px;padding: 2px 7px 6px 7px;text-decoration: none;" href="https://kyrylofolio.pro/" data-saferedirecturl="https://www.google.com/url?q=https://kyrylofolio.pro//">portfolio</a></p ><table><tbody><tr><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https:/ /github.com/Qunthunnan"><img class="light" src="https://i.imgur.com/qkQgSiX.png" alt="github"> <img class="dark" style="display: none;" src="https://i.imgur.com/WiqO7Cm.png" alt="github"> Github</a></td><td><a target="_blank" style="text- decoration: none; color: black; font-weight: 100; padding: 5px;" href="https://t.me/Qunthunnan0"><img class="light" src="https://i.imgur.com/jYDMH0s.png" alt="telegram"> <img class="dark" style="display: none;" src="https://i.imgur.com/yZ0NUXU.png" alt="telegram" > Telegram</a></td><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https:/ /www.facebook.com/kirylo.bashkan"><img class="light" src="https://i.imgur.com/sUjMbB5.png" alt="facebook"> <img class="dark" style ="display: none;" src="https://i.imgur.com/ZCYBArE.png" alt="facebook"> Facebook</a></td></tr></tbody></table ></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr></ tbody></table></td></tr></tbody></table></body></html>'

    ,

    'uk' => '<!DOCTYPE html><html lang="uk"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="color-scheme" content="light dark"><meta name="supported-color-schemes" content="light dark only"><style>*{
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
    background: -webkit-linear-gradient(90deg, #00ff88 0%, #61efff 100%);"><tbody><tr><td><img class="light" src="https://i.imgur.com/e2agLLZ.png" alt="logo"> <img class="dark" style="display: none;" src="https://i.imgur.com/ATyQnI2.png" alt="logo"><table><tbody><tr><td><div class="gmail-blend-screen"><div class="gmail-blend-difference"><h1 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 30px;font-weight: 700;text-transform: uppercase;">Дякую за замовлення</h1></div></div><table><tbody><tr><td><div class="gmail-blend-screen"><div class="gmail-blend-difference"><h2 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 20px;font-weight: 700;text-transform: uppercase;">'. $userData['name'] .', хоч я і не магазин з привабливими товарами..</h2></div></div></td></tr><tr></tr></tbody></table><table><tbody><tr><td><h3 class="gmailAndroid" style="margin-top: 20px; color: black;font-size: 18px;font-weight: 500;">Але, в мене є, чим <b style="font-weight: 700;/* color: #c70101; */font-size: 23px;">зацікавити…</b></h3><table><tbody><tr><td width="80%"><p style="margin-top: 20px; color: black;font-size: 18px;font-weight: 300;line-height: 27px;margin-bottom: 27px;">Є ще кілька демо-проєктів, які демонструють мої навички. Подивіться на них у моєму <a class="portfolio" target="_blank" style="background-color: #000000;color: #15fca1;font-weight: 700;border-radius: 30px;padding: 2px 7px 6px 7px;text-decoration: none;" href="https://kyrylofolio.pro/" data-saferedirecturl="https://www.google.com/url?q=https://kyrylofolio.pro//">портфоліо</a></p><table><tbody><tr><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https://github.com/Qunthunnan"><img class="light" src="https://i.imgur.com/qkQgSiX.png" alt="github"> <img class="dark" style="display: none;" src="https://i.imgur.com/WiqO7Cm.png" alt="github"> Github</a></td><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https://t.me/Qunthunnan0"><img class="light" src="https://i.imgur.com/jYDMH0s.png" alt="telegram"> <img class="dark" style="display: none;" src="https://i.imgur.com/yZ0NUXU.png" alt="telegram"> Telegram</a></td><td><a target="_blank" style="text-decoration: none;color: black;font-weight: 100;padding: 5px;" href="https://www.facebook.com/kirylo.bashkan"><img class="light" src="https://i.imgur.com/sUjMbB5.png" alt="facebook"> <img class="dark" style="display: none;" src="https://i.imgur.com/ZCYBArE.png" alt="facebook"> Facebook</a></td></tr></tbody></table></td><td></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></body></html>'];

    $subject = [
        'en' => 'Your order on Pulse',
        'uk' => 'Ваше замовлення на Pulse'
    ];

    $blockIpMailBody = [
        'en' => '<h1>Looks like the message has already been sent!</h1>
        <p>'. $userData["name"] .', I probably already received your message.</p>
        <p>If there is an error, you can contact me in a way convenient for you:</p>
        <p><a href="mailto:qunthunnan@gmail.com">qunthunnan@gmail.com</a>, <a href="https://t.me/Qunthunnan0">Telegram</a>, < a href="https://www.facebook.com/kirylo.bashkan">Facebook</a></p>'
        ,
        'uk' => '<h1>Схоже, повідомлення вже було відправлено!</h1>
        <p>'. $userData["name"] .', скоріше за все, я вже отримав ваше повідомлення.</p>
        <p>Якщо, виникла якась помилка, можете зв\'язатись зі мною зручним для вас способом:</p>
        <p><a href="mailto:qunthunnan@gmail.com">qunthunnan@gmail.com</a>, <a href="https://t.me/Qunthunnan0">Telegram</a>, <a href="https://www.facebook.com/kirylo.bashkan">Facebook</a></p>'
    ];

    $requestsLastDay = getRequestsCountLastDay($usersData);
    $warningMailBody = '<h1 style="color: red">!!УВАГА, НА СЕРВЕРІ СКОРІШЕ ЗА ВСЕ ВИЯВЛЕНО СПАМ!!</h1>
    <h2>Кількість відправлених повідомлень за останні 24 години:' . $requestsLastDay . '</h2>
    <h3>Рекомендую відключити поки mailer до з\'ясування обставин.</h3>';
    if($requestsLastDay == 30 || $requestsLastDay == 50 || $requestsLastDay == 70 || $requestsLastDay == 88) {
        echo 'Warning, spam possible!' . $requestsLastDay . ' was sended for last 24 hours';
        sendMail($warningMailBody, 'Warning!', $secrets->mails[1], $secrets);
    }

    if($requestsLastDay >= 90) {
        echo 'Error, spam detected!';
    } else {
        $requestsLastMinute = getRequestsCountLastMinute($usersData);
        if ($requestsLastMinute >= 1) {
            echo 'Error: Bandwidth limit reached, please try again later';
        } else {
            $requestsByIp = getRequestsCountByIp($userData["ip"], $usersData);
            if ($requestsByIp > 5) {
                echo 'Error: To many requests from your IP';
            } else {
                if($requestsByIp == 5) {
                    echo 'Block ip for security reasons.';
                    sendMail($blockIpMailBody[$lang], 'Your mail has been sended', $userData['email'], $secrets);
                    $usersData[] = [
                        'ip' => $userData["ip"],
                        'email' => $userData["email"],
                        'timestamp' => time(),
                        'timeDate' => date("d-m-Y H:i:s"),
                    ];
                    saveUsersData($usersData);
                } else {
                    sendMail($pulseMessageBody[$lang], $subject[$lang], $userData['email'], $secrets);
                    $usersData[] = [
                        'ip' => $userData["ip"],
                        'email' => $userData["email"],
                        'timestamp' => time(),
                        'timeDate' => date("d-m-Y H:i:s"),
                    ];
                    saveUsersData($usersData);
                }
            }
        }
    }
} else {
    echo 'Form data error!';
}
?>