<?php
    namespace App\Class\Mail;

    use Dotenv\Dotenv;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    $dotenv = Dotenv::createImmutable(__DIR__.'\..\..\..\..');
    $dotenv->load();

    class Mail {
        
        private string $host;
        private string $user;
        private string $pass;
        private string $port;
        private PHPMailer $mail;

        public function __construct()
        {
            $this->host = $_ENV['SMTP_HOST'];
            $this->user = $_ENV['SMTP_USER'];
            $this->pass = $_ENV['SMTP_PASS'];
            $this->port = $_ENV['SMTP_PORT'];
            $this->mail = new PHPMailer(true);
        }

        public function sendMail($Message, $Address)
        {
            $mail = $this->mail;
            try {
                $mail->SMTPAuth = true;
                $mail->isSMTP();
                $mail->CharSet = 'UTF-8';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

                $mail->Host = $this->host;
                $mail->Username = $this->user;
                $mail->Password = $this->pass;
                $mail->Port = $this->port;

                $mail->setFrom($this->user);
                $mail->addAddress($Address);

                $mail->Subject = 'Atenciosamento Risca Faca';
                $mail->Body = 'Codigo de verificação: '.$Message;

                $mail->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

    }