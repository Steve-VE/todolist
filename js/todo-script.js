$(function(){

    let $todoItems;
    let dataJSON;

    // Chargement de la TODO liste...
    $(".todo").load('php/parts/todo_list.php', function(){
        lookingForUpdate();
    });

    $.getJSON('assets/json/datalist.json', function(data){
        console.log("-- ! JSON loaded");
        
        dataJSON = data;
        console.log(dataJSON);
    });


    function lookingForUpdate(){
        // Ensuite, chargement des archives...
        $(".archives").load('php/parts/archives.php', function(){
            // Ensuite, récupération des items (éléments qui composent la TODO liste et les archives)
            $todoItems = $('.item');

            $todoItems.click(function(){
                let $checkbox = $(this).find("input");

                if( $checkbox.prop("checked") != dataJSON[ $checkbox.attr("value") ] ){
                    dataJSON[ $checkbox.attr("value") ]["archived"] = $checkbox.prop("checked");

                    $.ajax({
                        url: 'php/update_json.php',
                        type: "POST",
                        data: {
                            json_name: dataJSON[ $checkbox.attr("value") ]["content"], 
                            json_state:  dataJSON[ $checkbox.attr("value") ]["archived"]
                        },
                        success: function(){
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