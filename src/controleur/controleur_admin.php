<?php

    function actionAdmin($twig){

        if(isset($_POST['btCode'])){
            if($_POST['inputCode'] == 'ADMIN'){
                $_SESSION['role'] = 'ADMIN';
                header("Location:index.php?page=inscription");
            }
        }

        echo $twig->render('admin/index.html.twig',[]);

    }

    function actionDeconnexion($twig){
        session_unset();
        session_destroy();
        header("Location:index.php");
    }

    function actionUsersList($twig,$db){

        $form = null;
        $user = new Users($db);
        if(isset($_GET['id'])){
            $exec = $user->delete($_GET['id']);
            if(!$exec){
                $form['valide'] = false;
                $form['message'] = 'Porblème lors de la suppression';
            }else{
                $form['valide'] = true;
                $form['message'] = 'Utilisateur supprimé avec succès';
            }

        }
        $liste = $user->select();




        echo $twig->render('admin/users_list.html.twig',[
            'liste' => $liste,
            'form' => $form
        ]);
    }

    function actionUserModif($twig,$db){

        $form=[];
        $everyCountries = json_decode(file_get_contents('https://restcountries.eu/rest/v2/all'), true);
        $tab=[];
        foreach ($everyCountries as $country) {
            array_push($tab,$country['name']);
        }
        if(isset($_GET['id'])){
            $user = new Users($db);
            $currentUser = $user->selectById($_GET['id']);

            if($currentUser != null){
                $form['user'] = $currentUser;
            }else{
                $form['message'] = "Utilisateur incorrect";
            }
        }else{
            if(isset($_POST['btModifier'])){

                $user = new Users($db);

                $inputLastName = $_POST['inputLastName'];
                $inputFirstName = $_POST['inputFirstName'];
                $inputBirthDate = $_POST['inputBirthDate'];
                $inputGender = $_POST['inputGender'];
                $inputCountry = $_POST['countryList'];
                $inputJob = $_POST['jobList'];
                $inputEmail = $_POST['inputEmail'];
                $id = $_POST['id'];

                $exec = $user->update($inputFirstName,$inputLastName,$inputBirthDate,$inputGender,$inputCountry,
                    $inputJob,$inputEmail,$id);

                if(!$exec){
                    $form['valide'] = false;
                    $form['message'] ='Echec de la modification';
                }else{
                    $form['valide'] = true;
                    $form['message'] ='Modification réussie';
                }
            }else{
                $form['message'] = "Utilisateur non précisé";
            }
        }

        echo $twig->render('admin/user_modif.html.twig',[
            'form' => $form,
            'tab' => $tab
        ]);
    }

    function actionUserAdd($twig,$db){

        if(isset($_POST['btAjouter'])){
            $user = new Users($db);

            $inputLastName = $_POST['inputLastName'];
            $inputFirstName = $_POST['inputFirstName'];
            $inputBirthDate = $_POST['inputBirthDate'];
            $inputGender = $_POST['inputGender'];
            $inputCountry = $_POST['countryList'];
            $inputJob = $_POST['jobList'];
            $inputEmail = $_POST['inputEmail'];

            $exec = $user->insert($inputFirstName,$inputLastName,$inputBirthDate,
                $inputGender,$inputCountry,$inputJob,$inputEmail);

            if($exec) {
                header('Location:index.php?page=users_list');
            }

        }

        $everyCountries = json_decode(file_get_contents('https://restcountries.eu/rest/v2/all'), true);
        $tab=[];
        foreach ($everyCountries as $country) {
           array_push($tab,$country['name']);
        }

        echo $twig->render('admin/user_add.html.twig',[
            'tab' => $tab
        ]);
    }