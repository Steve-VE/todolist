<?php

function add_to_JSON( $value, $url="assets/json/datalist.json"){
    $raw_file = file_get_contents( $url );
    $decoded_file = json_decode($raw_file, true);

    $decoded_file = $value;
    $raw_file = json_encode($decoded_file);

    // Partie encodage
    $array_test[] = [
        "title" => "TODO #1",
        "content" => $value
    ];

    file_put_contents($url, json_encode( $array_test ));
}

function get_value($value_name){
    $value_to_return = null;

    if(isset($_POST[$value_name])){
        $value_to_return = filter_var($_POST[$value_name], FILTER_SANITIZE_STRING);
    }
    $value_to_return = $_POST[$value_name];
    return $value_to_return;
}

?>