<?php
    use PHPMailer\PHPMailer;
    use PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    //От кого письмо
    $mail->setFrom('smirnova_spb@mail.ru', 'Клиент');
    //Кому отправить
    $mail->addAddress('smirnova_spb@mail.ru');
    //Тема письма
    $mail->Subject = 'Заявка на ремонтные работы';

    //Тело письма
    $body = '<h1>Добрый день. Новая заявка.</h1>';

    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Имя клиента:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>Почта клиента:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['phone']))){
        $body.='<p><strong>Номер телефона клиента:</strong> '.$_POST['phone'].'</p>';
    }
    if(trim(!empty($_POST['message']))){
        $body.='<p><strong>Описание заявки:</strong> '.$_POST['message'].'</p>';
    }

    //Прикрепление файла
    if(!empty($_FILES['image']['tmp_name'])) {
        //путь загрузки файла
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        //грузим файл
        if (copy($_FILES['image']['tmp_name'], $filePath)){
            $filePath = $filePath;
            $body.='<p><strong>Фотография объекта в приложении</strong></p>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    //Отправляем
    if (!$mail->send()) {
        $message = 'Ошибка';
    } else {
        $message = 'Данные отправлены!';
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);

    ?>