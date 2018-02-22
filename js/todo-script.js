$(function(){

    let $todoItems;
    let dataJSON;

    // Chargement de la TODO liste...
    $(".todo").load('php/parts/todo_list.php', function(){
        // Ensuite, chargement des archives...
        $(".archives").load('php/parts/archives.php', function(){
            // Ensuite, récupération des items (éléments qui composent la TODO liste et les archives)
            $todoItems = $( '.item' );
            

            $todoItems.click(function(){
                let $checkbox = $(this).find("input");

                console.log($checkbox.prop("checked"));
                if( $checkbox.prop("checked") != dataJSON[ $checkbox.attr("value") ] ){
                    dataJSON[ $checkbox.attr("value") ]["archived"] = $checkbox.prop("checked");
                    console.log( dataJSON[ $checkbox.attr("value") ] );

                    $.ajax({
                        url: 'php/functions.php',
                        type: "POST",
                        data: { action: "save_json"},
                        timeout: 3000,
                        success: function(msg){
                            console.log(msg);
                        },
                        error: function(){
                            console.log("-- ! Warning: Failed to save JSON file...");
                        }
                    });
                }
            });
        });
    });


    $.getJSON('assets/json/datalist.json', function(data){
        console.log("-- ! JSON loaded");
        
        dataJSON = data;
        console.log(dataJSON);
    });

});