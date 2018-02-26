<?php
require "../functions.php";
?>

<h2>À faire</h2>
<form action="" method="post">
    <!-- <input type="submit" value="Archiver"> -->
    <div id="collect-todo" class="collect" ondragover="allowDrop(event)">   
        <?php
        $data = load_json("../../assets/json/datalist.json");
        
        if( !empty($data) ){
            for($i = 0; $i < count($data); $i++){
                $current_item = $data[$i];
                
                if($current_item->archived == false){
                    echo '<div class="item" draggable="true" ondragstart="drag(event)" ';
                    echo ' id="id_'. $i .'" ';
                    echo '>';
                    echo '<input type="checkbox" name="todo_to_archive[]" value ="';
                    echo $i;
                    echo '" />';
                    
                    echo '<label for="'. $i .'">';
                    echo $current_item->content;
                    echo '</label></div>';
                }
            }
        }
        ?>
    </div>
</form>