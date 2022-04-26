<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
 
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru','phpmailer/language/');
$mail->IsHTML(true);


$mail->setForm('deadstrouk@gmail.com', 'Фотограф по життю');


$mail->setAddress('dunets.vitalii@gmail.com');


$mail->Subject('Привіт, це фотограф по життю.');


$body = '<h1> Зустрічай листа <h1>';

if(trim(!empty($_POST['name']))){
    $body.= '<p><strong>Name:</strong>'.$_POST['name'].'</p>';

}
if(trim(!empty($_POST['email']))){
    $body.= '<p><strong>E-mail:</strong>'.$_POST['email'].'</p>';
    
}

if(!empty($_FILES['image']['tmp_name'])){
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    
    if(copy($_FILES['image']['tmp_name'], $filePath)){ 
        $fileAttach = $filePath;
        $body.='<p><strong>Фото в додатку</strong>';
        $mail->addAttachment($fileAttach);

    }
}

$mail->Body =$body;

if(!$mail->send()){
    $massage = 'Помилка';
} else{
    $massage = 'Данні відправлені!';
}

$response = ['message' => $massage];

header('Content-type: application/json');
echo json_encode($response);

?>


