
$(function(){
    let $todoItems;
    let todoList, todoListCounter = 0;
    let todoArchives, todoArchivesCounter = 0;
    let draggedElement = null;
    
    
    // Chargement de la TODO liste...
    $(".todo").load('php/parts/todo_list.php', function(){
        lookingForUpdate();

        // Récupération des deux listes
        todoList = document.querySelector('.todo');
        todoArchives = document.querySelector('.archives');

        // Ajouts des EventsListeners pour la TodoList...
        todoList.addEventListener('dragenter', function(){
            todoListCounter++;
            // todoList.style.backgroundColor = "rgba(240, 255, 255, 0.8)";
            todoList.style.boxShadow = "0 0 2px 2px rgba(20, 50, 100, 0.8)";
        });
        todoList.addEventListener('dragleave', function(){
            todoListCounter--;
            if(todoListCounter <= 0){
                todoList.style.boxShadow = "0 0 2px 2px rgba(0, 0, 0, 0.3)";
                // todoList.style.backgroundColor = "rgba(255, 255, 255, 0.8)";
            }
        });
        todoList.addEventListener('drop', function(ev){
            ev.preventDefault();

            todoListCounter = 0;
            todoList.style.boxShadow = "0 0 2px 2px rgba(0, 0, 0, 0.3)";

            console.log(ev.target.id + " : Something drop here !");
            alert(ev.dataTransfer.getData('text/plain'));
        });    
    });

    document.addEventListener('dragend', function(){
        // alert("Drag over");
    });
    
    let dataJSON;

    // Gère l'archivage et le "désarchivage" d'une élément de la TODO liste
    function lookingForUpdate(){
        // (... appelé lors du chargement de la 'div.todo'...)

        // Récupération du JSON
        $.getJSON('assets/json/datalist.json', function(data){
            dataJSON = data;
        });
        // Ensuite, chargement des archives...
        $(".archives").load('php/parts/archives.php', function(){
            // Ensuite, récupération des items (éléments qui composent la TODO liste et les archives)
            $todoItems = $('.item');
            // $todoItems.attr("draggable", true);

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


function drag(ev) {
    console.log("Drag Start on : " + ev.target.id);

    draggedElement = ev.target;
    ev.dataTransfer.setData('text/plain', ev.target.id);
}


// $todoItems.addEventListener('dragstart', function(e) {
//     console.log("Drag Start...");
//     e.dataTransfer.setData('text/plain', "Ce texte sera transmis à l'élément HTML de réception");
// });


function allowDrop(ev) {
    ev.preventDefault();
}

// function drag(ev) {
//     console.log("drag on...");
//     ev.dataTransfer.setData("text/plain", ev.target.id);
// }

// function drop(ev) {
//     ev.preventDefault();
//     var data = ev.dataTransfer.getData("text/plain");
//     ev.target.appendChild(document.getElementById(data));
// }