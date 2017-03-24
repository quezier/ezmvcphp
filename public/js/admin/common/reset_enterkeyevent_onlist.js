$(function(){
    document.onkeydown = function(e){ 
        var ev = document.all ? window.event : e;
        if(ev.keyCode==13) {
           e.preventDefault();
            doSearch();
         }
    };
    // $('.search_input').keyup(function(e){
    //     if(e.keyCode==13)
    //     {
    //         doSearch();
    //     }
    // });
});


