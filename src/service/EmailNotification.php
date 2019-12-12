<?php

use PHPMailer\PHPMailer\PHPMailer;

class EmailNotification
{

    public function __construct()
    {
    }

    public function notify($from, $to, $subject,$body){

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'amortel62@gmail.com';
        $mail->Password   = 'qnfvxtmiibvskfba';
        $mail->Port       = 587;

        $mail->isHTML();
        $mail->setFrom($from);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();

    }

    public function notifyUserOnSignUp($info){

          $body = '
              <h1>Inscription réussie !</h1>
              <h3>Voiçi vos informations :</h3>
              <p>Nom : '.$info['inputLastName'].'</p>
              <p>Prénom : '.$info['inputFirstName'].'</p>
              <p>Mail : '.$info['inputEmail'].'</p>
              <p>Date de naissance : '.$info['inputBirthDate'].'</p>
              <p>Sexe : '.$info['inputGender'].'</p>
              <p>Pays : '.$info['countryList'].'</p>
              <p>Métier : '.$info['jobList'].'</p>
              ';
          $from = 'wacheyoanpro@gmail.com';
          $to = $info['inputEmail'];
          $subject = 'Inscription réussie !';

          $this->notify($from,$to,$subject,$body);

    }

    public function notifyAdminOnSignUp($info){

          $body = '
          <h1>Un nouvel utilisateur s\'est inscrit !</h1>
          <a href="index.php?page=users_list">Voir les utilisateurs</a>
          <h3>Voiçi ses informations :</h3>
              <p>Nom : '.$info['inputLastName'].'</p>
              <p>Prénom : '.$info['inputFirstName'].'</p>
              <p>Mail : '.$info['inputEmail'].'</p>
              <p>Date de naissance : '.$info['inputBirthDate'].'</p>
              <p>Sexe : '.$info['inputGender'].'</p>   
              <p>Pays : '.$info['countryList'].'</p>
              <p>Métier : '.$info['jobList'].'</p>
          ';
          $from = 'wacheyoanpro@gmail.com';
          $to = 'wacheyoanpro@gmail.com';
          $subject = 'Nouvel utilisateur !';

          $this->notify($from,$to,$subject,$body);

    }

}