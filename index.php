<?php
require "php/functions.php";

// Connexion à la base de donnée...
$data_base = connect_to_db();

$to_archive = null;

// Si $_POST existe (ce qui sous-entend que des valeurs ont été passées via la méthode 'post')
if(isset($_POST)){
    if(isset($_POST['todo_to_archive'])){
        if(is_array($_POST['todo_to_archive'])){    
            $to_archive = $_POST['todo_to_archive'];
            archive_json($to_archive);
        }
    }

    if(isset($_POST['new_entry']) && !empty(isset($_POST['new_entry']))){
        $new_entry = get_value("new_entry");


        if(isset($data_base) && strlen($new_entry) > 0){
            $sql_requets = "INSERT INTO todolist (id, content, state) VALUES (null, '". get_value("new_entry") ."', 0);";
            $data_base->exec($sql_requets);
        }
    }

    if(isset($_POST['todo_to_delete'])){
        delete_archives( $_POST['todo_to_delete'] );
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
            <!-- Va contenir la TODO liste (charger via Javascript) -->
        </div>

        <div class="list archives">
            <!-- Va contenir les arhives de la TODO liste (cahrger via Javascript) -->
        </div>
    </main>

    <?php
    // var_dump($_POST);
    ?>
</body>
<script src="js/todo-script.js"></script>
</html>

<?php
// Si une connexion à la BDD existait, on y met fin
if(isset($data_base)){
    $data_base = null;
}
?>