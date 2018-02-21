<?php

// Ajoute une valeur à un fichier JSON
function add_to_json( $text, $url="assets/json/datalist.json"){
    // Partie décodage
    $array_data = [];
    $array_data = load_json( $url );


    if( $text != "" && $text != false && $text != null ){

        $array_data[] = [
            "content" => $text,
            "archived" => false
        ];

        // Sauvegarde du fichier
        file_put_contents($url, json_encode( $array_data, JSON_PRETTY_PRINT ));
    }
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

    // echo 'VAR DUMP : '; var_dump($index_to_archive);
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
function get_value($value_name){
    $value_to_return = null;

    if(isset($_POST[$value_name])){
        $value_to_return = filter_var($_POST[$value_name], FILTER_SANITIZE_STRING);
        // unset($_POST[$value_name]); // On détruit la variable contenu dans POST après l'avoir récupéré pour éviter de la renvoyer en rechargeant la page
    }

    return $value_to_return;
}

?>