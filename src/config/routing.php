<?php
    function getPage($db)
    {
        $lesPages['accueil'] = "actionAccueil";
        $lesPages['inscription'] = "actionInscription";
        $lesPages['admin'] = "actionAdmin";
        $lesPages['users_list'] = "actionUsersList";
        $lesPages['user_modif'] = "actionUserModif";
        $lesPages['user_add'] = "actionUserAdd";
        $lesPages['deconnnexion'] = "actionDeconnexion";

        if($db!==NULL) {
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = 'accueil';
            }

            if (!isset($lesPages[$page])) {
                $page = 'accueil';
            }
            $contenu = $lesPages[$page];

        }

        return $contenu;
    }
