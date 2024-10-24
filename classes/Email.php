<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    
    public function sendConfirmation() {

        $mail = new PHPMailer();

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'live.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'api';
        $mail->Password = '4b7f42f566039478a0af5a77ca271177';

        $mail->setFrom('cuentas@leosStyle.com');
        $mail->addAddress('cuentas@leosStyle.com', 'LeosStyle.com');
        $mail->Subject = 'Confirmación de cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola" . $this->nombre . "!</strong></p>";
        $contenido .= "<p>Para confirmar tu cuenta, haz click en el siguiente enlace:</p>";
        $contenido .= "<p><a href='http://localhost/confirmar?token=" . $this->token ."'></a></p>";
        $contenido .= "<p>Si no has solicitado esta acción, ignora este correo.</p>";
        $contenido .= "<p>Saludos,</p>";
        $contenido .= "<p>LeosStyle.com</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        $mail->send();

    }
}