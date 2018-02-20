<?php
require "php/functions.php";

if(isset($_POST)){
    var_dump($_POST);
    if(isset($_POST['new_entry']) && !empty(isset($_POST['new_entry']))){
        $new_entry = get_value( "new_entry" );
        add_to_JSON($new_entry);

        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="stylesheets/main.css">

    <title>Todo List</title>
</head>
<body>
    
    <form action="" method="post">
        <!-- <textarea name="new_entry" id="blocnote" ></textarea> -->
        <input type="text" name="new_entry" id="">
        <input type="submit" value="Enregistrer">
    </form>

</body>
</html>