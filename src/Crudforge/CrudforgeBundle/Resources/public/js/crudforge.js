//default functions
$(function(){
    //theme buttons
    $( ".cssButton" ).button();

    $( "#accordion" ).accordion({ heightStyle: "fill" });
    
    $( "#main-menu" ).menu();

    //theme tables
    $("table th").each(function(){
        $(this).addClass("ui-state-default");
    });
    $("table td").each(function(){
        $(this).addClass("ui-widget-content");
    });
    $("table tr").hover(function(){
        //$(this).children("td").addClass("ui-state-hover");
     },function(){
        //$(this).children("td").removeClass("ui-state-hover");
     }
    );
    $("table tr").click(function(){
        $(this).children("td").toggleClass("ui-state-highlight");
    });
});