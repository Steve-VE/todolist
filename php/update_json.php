<?php
// Charge et retourne un fichier JSON
function load_json($url="../assets/json/datalist.json"){
    if(!$raw_file = file_get_contents($url)){
        $error = error_get_last();
        // echo "HTTP request failed. Error was: " . $error['message'];
    }
    else{
        return json_decode($raw_file);
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


if(isset($_POST['json_name']) && isset($_POST['json_state'])){

    $json_name = get_value('json_name');
    $json_state = (get_value('json_state') == 'true')? true : false;

    $json_file = load_json();

    for($i = 0; $i < count($json_file); $i++){

        if(  $json_file[$i]->content == $json_name 
        && $json_file[$i]->archived == $json_state){

            $json_file[$i]->archived = !$json_state;
        
            $i = count($json_file); // Pour casser la boucle
        }
    }

    file_put_contents( "../assets/json/datalist.json", json_encode( $json_file, JSON_PRETTY_PRINT ));
    // file_put_contents( "datalist.json", json_encode( $json_file, JSON_PRETTY_PRINT ));
}
?>