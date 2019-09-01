function getMovie() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "server.php", true);
    xmlhttp.send();
}

var edit=(obj)=>{
    var id=$(obj).val();
    getActor(id);
    getGenre(id);
    // <form action=\"/projects/server.php\" id='edit' method=\"POST\">
    $("#"+id+'a').html(" Actor name(Press ctrl/Command to select multiple):<br> <select name='actor' id='actorselect"+id+"' multiple name='actor'></select>"); 
    $("#"+id+'g').html("Genre (Press ctrl/Command to select multiple):<br> <select name='actor' id='genreselect"+id+"' multiple name='genre'></select>");
    $("#"+id+'y').html("Year: <input type='number' min='1900' max='2019' value='"+$('#'+id+'y').text()+"' id='year'>");
    $("#"+id+'r').html("Rating: <input type='number' min='1' max='10' value='"+$('#'+id+'r').text()+"' id='rating'>");
    $("#"+id).html("<button onclick='sentedit(this,"+id+")' >Submit</button>");
}

var sentedit = (obj,id)=>{
        console.log($("#actorselect").val());
        $.post(
            'server.php?req=edit',
            {
                name: $(obj).parents('#parent').find('#mname').text(), //finding corresponding movie name
                actor: $("#actorselect"+id).val(),
                year: $("#year").val(),
                rating: $("#rating").val(),
                genre: $("#genreselect"+id).val(),

            },
            function(result){
                if(result == 'successfull'){
                    getMovie();
                }else{
                    console.log(result);
                    // $("#result").html(result);
                }
            }
        )
}

var del = (obj)=>{
    $.ajax({
        type:'delete',
        url:'server.php',
        data:{name:$(obj).parents('#parent').find('#mname').text()},
        success: function(data){
             if(data=="successfully"){
                 getMovie();
             }else{
                 alert(data)
             }
        }
    
    })

}

var addactorgenre=(greq,id)=>{
    console.log($("#"+id).val());
    $.post(
        'actorgenre.php?req='+greq,
        {
            aname: $("#"+id).val()

        },
        function(result){
            $("#result").html(result);
        }
    )
}

function getActor(id){
    $.get(
        'actorgenre.php?req=a',
        function(result){
            $('#actorselect'+id).html(result);
        }
    )
}
function getGenre(id){
    $.get(
        'actorgenre.php?req=g',
        function(result){
            console.log(result)
            $('#genreselect'+id).html(result);
        }
    )
}

function showResult(value) {
    if(value.length>2 || $.isNumeric(value)){
        $.get(
            'search.php',{
                data: value
            },
            function(result){
                console.log(result)
                $('#table').html("suggestions:- "+result);
            }
        )
    }
    else{
        getMovie();
    }

}

var name,actor,rating,genre,img;
window.onload = function() {
    getMovie();

  };