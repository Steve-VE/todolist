<?php
require "../functions.php";
?>

<h2>Archives</h2>
<form method="post">
    <input type="submit" value="Supprimer les archives">
    <?php
    $data = load_json("../../assets/json/datalist.json");
    
    if( !empty($data) ){
        for($i = 0; $i < count($data); $i++){
            $current_item = $data[$i];
            
            if($current_item->archived == true){
                echo '<div class="item">';
                echo '<input type="checkbox" name="todo_to_delete[]" value ="';
                echo $i;
                echo '" checked="checked">';
                echo '<label>';
                echo $current_item->content;
                echo '</label></div>';
            }
        }
    }
    ?>
</form>