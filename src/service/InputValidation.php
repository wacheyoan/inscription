<?php


class InputValidation
{

    public static function clearInput($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function str($data){
        if(!is_string($data)){
            throw new Exception('Champs nécessite une chaîne de caractères',900);
        }
        return self::clearInput($data);
    }

    function dateValid($data){
        $ydm = explode('-',$data);
        if(checkdate($ydm['2'],$ydm['1'],$ydm['0'])) {
            return $data;
        }else{
            throw new Exception('Date non valide !',901);
        }
    }

    function email($data){
        $data = filter_var($data,FILTER_VALIDATE_EMAIL);
        if(!$data){
            throw new Exception('Format du mail erroné !');
        }else{
            return $data;
        }
    }







}