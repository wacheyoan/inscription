<?php
session_start();
/* initialisation des fichiers TWIG */

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';
require_once '../src/config/parametres.php';
require_once '../src/app/connexion.php';
require_once '../src/config/routing.php';
require_once '../src/controleur/controleur_index.php';
require_once '../src/controleur/controleur_admin.php';
require_once '../src/modele/Users.php';
require_once '../src/service/EmailNotification.php';
require_once '../src/service/InputValidation.php';



$loader = new FilesystemLoader('../src/vue/');
$twig = new Environment($loader, [
    'debug' => true,
    'cache' => false,
]);
$twig->addExtension(new DebugExtension());

if(!isset($_SESSION['role'])){
    $_SESSION['role'] = 'VISITOR';
}
$twig->addGlobal('role',$_SESSION['role']);

$db = connect($config);

$contenu = getPage($db);
$contenu($twig,$db);



