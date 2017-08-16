<?php


use PHPMailer;
/**
 * Created by PhpStorm.
 * User: micha
 * Date: 16/07/17
 * Time: 15:10
 */
class Mailer{

    public function __construct(){
        $this->initMailer();
    }

    private function setMailer(PHPMailer $mailer){
        $this->mailer=$mailer;
    }

    private function getMailer():PHPMailer{
        return $this->mailer;
    }

    private function initMailer(){
        $this->setMailer(new PHPMailer());

        $this->getMailer()->isSMTP();                                      // Set mailer to use SMTP
        $this->getMailer()->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $this->getMailer()->SMTPAuth = true;                               // Enable SMTP authentication
        $this->getMailer()->Username = 'web.services.mailer@gmail.com';                 // SMTP username
        $this->getMailer()->Password = 'veryeasypassword';                           // SMTP password
        $this->getMailer()->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $this->getMailer()->Port = 587;                                    // TCP port to connect to
    }

    public function  sentRawMail($to, $subject, $text, $from = 'web.services.mailer@gmail.com'){
        $this->getMailer()->isHTML(false);
        $this->sentMail($to, $subject, $text, $from);

    }

    public function  sentHTMLMail($to, $subject, $text, $from = 'web.services.mailer@gmail.com'){
        $this->getMailer()->isHTML(true);
        $this->sentMail($to, $subject, $text, $from);
    }

    private function sentMail($to, $subject, $text, $from):bool{
        $this->getMailer()->setFrom('from@example.com', 'Mailer');
        $this->getMailer()->addAddress($to);               // Name is optional
        $this->getMailer()->Subject = $subject;
        $this->getMailer()->Body = $text;

        if (!$this->getMailer()->send()){
            throw new Error();
        }
    }



}