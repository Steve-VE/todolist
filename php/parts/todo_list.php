<?php
require "../functions.php";
?>

<h2>À faire</h2>
<form action="" method="post">
    <!-- <input type="submit" value="Archiver"> -->
    <div id="collect-todo" class="collect" ondragover="allowDrop(event)">   
        <?php
        $data_base = connect_to_db();
        $result = $data_base->query("SELECT * FROM todolist WHERE state = 0");
        
        while($data = $result->fetch()){
            echo '<div class="item';
            if( expirate( $data['expiration'] ) ){
                echo ' urgence';
            }
            echo '" draggable="true" ondragstart="drag(event)" ';
            echo ' id="id_'. $data['id'] .'" ';
            echo '>';
            echo '<input type="checkbox" name="todo_to_archive[]" value ="';
            echo $data['id'];
            echo '" />';
            
            echo '<label for="'. $data['id'] .'">';
            echo $data['content'];
            echo '</label></div>';
        }
        $result->closeCursor();
        ?>
    </div>
</form>