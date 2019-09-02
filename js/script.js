function getMovie(i) {
    var link;
    i ? link='server.php?page='+i : link='server.php?page=1';
    
    console.log(link);
    $.ajax({
        type:'get',
        url: link,
        // dataType: "JSON",
        success:function(page) {
            $('#table').html(page.table);
            $('#pagination').html(page.pageno);
        }
    });
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
            'server.php?req=search',{
                data: value
            },
            function(result){
                if(result != 'none'){
                    $('#table').html(result);
                    $('#pagination').html(" ");
                }
                else {
                    $('#table').html("<b>No results<b>");
                }
                
            }
        )
    }
    else if(value.length==0){
        getMovie();
    }

}

function getActor(id){
    var link;
    id ? link = "#actorselect" + id : link = "#actorselect" ;
    console.log(link);
    $.get(
        'actorgenre.php?req=a',
        function(result){
            $(link).html(result);
        }
    )
}
function getGenre(id){
    var link;
    id ? link = "#genreselect" + id : link = "#genreselect" ;
    $.get(
        'actorgenre.php?req=g',
        function(result){
            console.log(result)
            $(link).html(result);
        }
    )
}

var name,actor,rating,genre,img;


