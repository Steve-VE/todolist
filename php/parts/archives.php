<?php
require "../functions.php";
?>

<h2>Archives</h2>
<form method="post">
    <input type="submit" value="Supprimer les archives">
    <div id="collect-archive" class="collect" ondragover="allowDrop(event)">
        <?php
        $data_base = connect_to_db();
        $result = $data_base->query("SELECT * FROM todolist WHERE state = 1");
        
        while($data = $result->fetch()){
            echo '<div class="item" draggable="true" ondragstart="drag(event)" ';
            echo ' id="id_'. $data['id'] .'" ';
            echo '>';
            echo '<input type="checkbox" name="todo_to_delete[]" value ="';
            echo $data['id'];
            echo '" checked="checked"/>';
            
            echo '<label for="'. $data['id'] .'">';
            echo $data['content'];
            echo '</label></div>';
        }
        $result->closeCursor();
        ?>
    </div>
</form>