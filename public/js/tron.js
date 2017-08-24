$(function(){
    $(".tron").mouseover(function(){
        $(this).find("td").css("background","#BBDDE5");
    });
    $(".tron").mouseout(function(){
        $(this).find("td").css("background","");
    });
});