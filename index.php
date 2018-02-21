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

    <script src="js/jquery-3.3.1.min.js"></script>
    

    <link rel="stylesheet" href="stylesheets/main.css">

    <title>Todo List</title>
</head>
<body>
    <main>
        <div class="list create-todo">
            <h2>Ajouter une nouvelle tâche</h2>
            <form action="" method="post">
                <input type="text" name="new_entry" id="new-entry">
                <input type="submit" value="Enregistrer">
            </form>
        </div>


        <div class="list todo">
            <h2>À faire</h2>
            <form action="" method="post">
                <input type="submit" value="Archiver">
                <div class="collect">   
                    <?php
                    $data = load_json();
                    
                    for($i = 0; $i < count($data); $i++){
                        $current_item = $data[$i];
                        
                        if($current_item->archived == false){
                            echo '<div class="item">';
                            echo '<input type="checkbox" name="todo_to_archive[]" value ="';
                            echo $i;
                            echo '" />';
                            
                            echo ' <label for="'. $i .'">';
                            echo $current_item->content;
                            echo '</label></div>';
                        }
                    }
                    ?>
                </div>
            </form>
        </div>
        <div class="list archive">
            <h2>Archives</h2>
            <form>
                <?php
                $data = load_json();
                
                for($i = 0; $i < count($data); $i++){
                    $current_item = $data[$i];
                    
                    if($current_item->archived == true){
                        echo '<div class="item">';
                        echo '<input type="checkbox" disabled checked>';
                        echo '<label>';
                        echo $current_item->content;
                        echo '</label></div>';
                    }
                }
                ?>
            </form>
        </div>
    </main>

    <?php
    // var_dump($_POST);
    ?>
</body>
<script src="js/todo-script.js"></script>
</html>
