<?php
require "php/functions.php";

$to_archive = null;


if(isset($_POST)){
    // var_dump($_POST);

    if(isset($_POST['todo_to_archive'])){
        if(is_array($_POST['todo_to_archive'])){    
            $to_archive = $_POST['todo_to_archive'];
            archive_json($to_archive);
        }
    }

    if(isset($_POST['new_entry']) && !empty(isset($_POST['new_entry']))){
        // $new_entry = get_value( "new_entry_text" );
        add_to_json( get_value( "new_entry" ) );
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
    <main>
        <form class="create-todo" action="" method="post">
            <h1>Ajouter une nouvelle tâche</h1>
            <input type="text" name="new_entry" id="new-entry">
            <input type="submit" value="Enregistrer">
        </form>


        <div class="list">
            <h2>À faire</h2>
            <form action="" method="post">
                <?php
                $data = load_json();
                
                for($i = 0; $i < count($data); $i++){
                    $current_item = $data[$i];
                    
                    if($current_item->archived == false){
                        echo '<input type="checkbox" name="todo_to_archive[]" value ="';
                        echo $i;
                        echo '" />';

                        echo ' <label for="'. $i .'">';
                        echo $current_item->content;
                        echo '</label><br/>';
                    }
                }
                ?>
                <input type="submit" value="Archiver">
            </form>
        </div>
        <div class="list">
            <h2>Archivés</h2>
            <ul>
                <?php
                $data = load_json();
                
                for($i = 0; $i < count($data); $i++){
                    $current_item = $data[$i];
                    
                    if($current_item->archived == true){
                        echo '<li>';
                        echo $current_item->content;
                        echo '</li>';
                    }
                }
                ?>
            </ul>
        </div>
    </main>

    <?php
    var_dump($_POST);
    ?>
</body>
</html>