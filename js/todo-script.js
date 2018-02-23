$(function(){

    let $todoItems;
    
    // Chargement de la TODO liste...
    $(".todo").load('php/parts/todo_list.php', function(){
        lookingForUpdate();
    });
    
    let dataJSON;

    // Gère l'archivage et le "désarchivage" d'une élément de la TODO liste
    function lookingForUpdate(){
        // Récupération du JSON
        $.getJSON('assets/json/datalist.json', function(data){
            dataJSON = data;
        });
        // (... appelé lors du chargement de la 'div.todo'...)
        // Ensuite, chargement des archives...
        $(".archives").load('php/parts/archives.php', function(){
            // Ensuite, récupération des items (éléments qui composent la TODO liste et les archives)
            $todoItems = $('.item');
            $todoItems.attr("draggable", true);

            $todoItems.find("input").click(function(){
                // let $checkbox = $(this).find("input");
                let $checkbox = $(this);

                if( $checkbox.prop("checked") != dataJSON[ $checkbox.attr("value") ] ){
                    // dataJSON[ $checkbox.attr("value") ]["archived"] = $checkbox.prop("checked");

                    let cName = dataJSON[ $checkbox.attr("value") ]["content"];
                    let cState = dataJSON[ $checkbox.attr("value") ]["archived"];
                    // console.log($checkbox.attr("value") + ". " + cName + " : " + cState);

                    $.ajax({
                        url: 'php/update_json.php',
                        type: "POST",
                        data: {
                            json_name: cName, 
                            json_state: cState
                        },
                        success: function(msg){
                            // console.log(msg);
                            $(".todo").load('php/parts/todo_list.php', function(){
                                lookingForUpdate();
                            });
                        },
                        error: function(){
                            console.log("-- ! Warning: Failed to save JSON file...");
                        }
                    });
                }
            });
        });
    }

});