<?php

    function actionAccueil($twig){
        echo $twig->render('index.html.twig',[]);
    }

    function actionInscription($twig,$db){

            //J'allège le code du contrôleur...
            require_once '../src/service/GoogleAPi.php';
            require_once '../src/service/RestCountries.php';

            /*Inscription*/
            $form = [];
            //Lorsque l'on appuie sur le bouton Inscrire (Requête POST)
            if (isset($_POST['btInscrire'])) {
                   if(!empty($_POST['inputLastName']) && !empty($_POST['inputFirstName'])
                    && !empty($_POST['inputBirthDate']) && !empty($_POST['inputGender'])
                    && !empty($_POST['countryList']) && !empty($_POST['jobList']) && !empty($_POST['inputEmail'])){
                        $input = new InputValidation();

                        $inputLastName = $input->str($_POST['inputLastName']);
                        $inputFirstName = $input->str($_POST['inputFirstName']);
                        $inputBirthDate = $input->dateValid($_POST['inputBirthDate']);
                        $inputGender =  $input::clearInput($_POST['inputGender']);
                        $inputCountry =  $input::clearInput($_POST['countryList']);
                        $inputJob =  $input::clearInput($_POST['jobList']);
                        $inputEmail = $input->email($_POST['inputEmail']);

                        $user = new Users($db);
                        $infos = $user->select();
                        $exist = false;

                        //On cherche si l'email est déjà utilisé
                        foreach ($infos as $info){
                            if(strtolower($info['email']) == strtolower($inputEmail)){

                                $exist = true;
                            }
                        }

                        //S'il ne l'est pas
                        if(!$exist){

                            $form['valide'] = true;
                            $form['email'] = $inputEmail;

                            $user = new Users($db);
                            $exec = $user->insert(
                                $inputFirstName, $inputLastName, $inputBirthDate,
                                $inputGender, $inputCountry, $inputJob, $inputEmail
                            );

                            //Si erreur lors de la requête
                            if (!$exec) {
                                $form['valide'] = false;
                                $form['error'] = 'Erreur lors de l\'inscription';
                            }else{
                             /*Notifications par mails*/
                                $mail = new EmailNotification();

                                $mail->notifyUserOnSignUp($_POST);
                                $mail->notifyAdminOnSignUp($_POST);
                            }
                        }else{
                                $form['valide'] = false;
                                $form['error'] = "Email déjà utilisé";
                             }
                    }else{
                        $form['valide'] = false;
                        $form['error'] = "Champs vide(s) !";
                    }
            }

        echo $twig->render('inscription.html.twig',[
            "tab" => $tab,
            "countryCode" => $countryCode,
            "countryName" => $countryName,
            'form' => $form
        ]);
    }