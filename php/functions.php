<?php

// Ajoute une valeur à un fichier JSON
function add_to_json( $text, $url="assets/json/datalist.json"){
    // Partie décodage
    $array_data = [];
    $array_data = load_json( $url );


    if( $text != "" && $text != false && $text != null ){
        $valid = true;
        foreach($array_data as &$data){
            if($data->content == $text){
                $data->archived = false;
                $valid = false;
                break;
            }
        }

        if($valid){
            $array_data[] = [
                "content" => $text,
                "archived" => false
            ];
        }

        // Sauvegarde du fichier
        file_put_contents($url, json_encode( $array_data, JSON_PRETTY_PRINT ));
    }
}

// Regarde si la date est passé
function expirate( $date ){

    if($date == null){
        return false;
    }
    else{
        $date = new DateTime($date);
        $today = new DateTime();

        if( $date < $today ){
            return true;
        }
    }

    return false;
}

// Charge et retourne un fichier JSON
function load_json($url="assets/json/datalist.json"){
    if(!$raw_file = file_get_contents($url)){
        $error = error_get_last();
        // echo "HTTP request failed. Error was: " . $error['message'];
    }
    else{
        return json_decode($raw_file);
    }
}

// Fonction à appeller pour "archiver" des valeurs dans le fichier JSON
function archive_json($index_to_archive, $url="assets/json/datalist.json"){
    $array_data = load_json( $url );
    if(isset($index_to_archive) && count($index_to_archive) > 0){

        for($i = 0; $i < count($array_data); $i++){
            if(in_array( $i, $index_to_archive )){
                $array_data[$i]->archived = true;
            }
        }
    }

    file_put_contents($url, json_encode( $array_data, JSON_PRETTY_PRINT ));
}


// Retourne une valeur à aller chercher dans $_POST
function get_value($value_name, $filter=FILTER_SANITIZE_STRING){
    $value_to_return = null;

    if(isset($_POST[$value_name])){
        $value_to_return = filter_var($_POST[$value_name], $filter);
        // unset($_POST[$value_name]); // On détruit la variable contenu dans POST après l'avoir récupéré pour éviter de la renvoyer en rechargeant la page
    }

    return $value_to_return;
}



function delete_archives($values, $url="assets/json/datalist.json"){
    $data_base = connect_to_db();

    foreach($_POST['todo_to_delete'] as $id){
        $request = "DELETE FROM `todolist` WHERE `id`=". $id .";";
        $data_base->exec($request);
    }
}

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

?>