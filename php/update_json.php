<?php

function connect_to_db($host="localhost", $dbname="becode", $username="root", $password="" ){
    // Connexion à la base de donnée...
    try{
        $data_base = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password);
        return $data_base;
    }
    catch(Exception $e){
        // echo 'Erreur: Impossible de se connecter à la DataBase';
        die('Erreur: Impossible de se connecter à la DataBase'. $e->getMessage());
    }
}

// Retourne une valeur à aller chercher dans $_POST
function get_value($value_name){
    $value_to_return = null;

    if(isset($_POST[$value_name])){
        $value_to_return = filter_var($_POST[$value_name], FILTER_SANITIZE_STRING);
        // unset($_POST[$value_name]); // On détruit la variable contenu dans POST après l'avoir récupéré pour éviter de la renvoyer en rechargeant la page
    }

    return $value_to_return;
}

/////////////////////////////////////////////////////////////////


if(isset($_POST['element_id']) && isset($_POST['element_state'])){

    $element_id = get_value('element_id');
    $element_state = (get_value('element_state') == 'true')? 1 : 0;

    $data_base = connect_to_db();
    $sql_request = "UPDATE `todolist` SET `state`=". $element_state ." WHERE `id`='". $element_id ."';";
    var_dump($sql_request);
    $result = $data_base->exec($sql_request);
}
?>