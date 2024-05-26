<?php
    namespace App\Mail;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mail {
        public static function EnviarEmail($endereço) {
            $codigo = '';

            for ($i=0;$i<6;$i++) {
                $codigo .= (string) rand(0, 9);
            }
            
            $mail = new PHPMailer(true);
            
            try {
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Password = '@EEEPRita1';
                $mail->Username = 'alysson.chaves@aluno.ce.gov.br';
                $mail->Port = 587;
                $mail->Host = 'smtp.gmail.com';
                $mail->CharSet = 'UTF-8';

                $mail->addAddress($endereço);

                $mail->isHTML();
                $mail->Subject = 'Atenciosamente churrascaria Risca Faca';
                $mail->Body = 'Codigo de verificação: '.$codigo;
                
                $mail->send();
                return $codigo;
            } catch (Exception $e) {
                print('Nao foi possivel enviar um email'. $e->getMessage());
                return false;
            }
        }
    }