<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Email{

        private $mailer;

        public function __construct($host, $username, $senha, $name){
            $this->mailer= new PHPMailer(true);

            try {
                //Server settings
                $this->mailer->isSMTP();                                            // Send using SMTP
                $this->mailer->Host       = $host;                    // Set the SMTP server to send through
                $this->mailer->SMTPAuth   = true;                                   // Enable SMTP authentication
                $this->mailer->Username   = $username;                     // SMTP username
                $this->mailer->Password   = $senha;                               // SMTP password
                $this->mailer->SMTPSecure = 'ssl';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $this->mailer->Port       = 465;                                    // TCP port to connect to

                $this->mailer->setFrom($username, $name);
                $this->mailer->isHTML(true);     
                
                $this->mailer->Charset = "UTF-8";

                
                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function addAdress($email, $nome){
            $this->mailer->addAddress($email, $nome); 
        }

        public function formatMail($info){
            $this->mailer->Subject = strip_tags($info["Subject"]);
            $this->mailer->Body    = strip_tags($info["body"]);
            $this->mailer->AltBody = strip_tags($info["body"]);
        }

        public function sendMail(){
            try {
                $this->mailer->send();
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }
?>