
document.getElementById("next_page").addEventListener("click",function(){
    var page = window.location.href.split("page=")[1];
    if (page==undefined) {
        page = 0;
    }
    var url = window.location.href;

    if(url.indexOf("/search?q=")>0) {
        var pageIndex = url.indexOf("page=");
        if(pageIndex>0) {

            window.location.href = window.location.href.substring(0,pageIndex-1) +  "&page=" + (parseInt(page)+1);
        }
        else {
            window.location.href+= "&page=" + (parseInt(page)+1);
        }
    }
    else {
        window.location.href = "?page=" + (parseInt(page)+1);        
    }
})


window.addEventListener("load", function(){
    var page = window.location.href.split("page=")[1];
    if (page==undefined) {
        page = 0;
    }
    if(page==0){
        this.document.getElementById("previous_page").style.display="none";
    }
});

document.getElementById("previous_page").addEventListener("click",function(){
    var page = window.location.href.split("page=")[1];
    if (page==undefined) {
        page = 0;
    }
    if(page>0) {
        var url = window.location.href;

        if(url.indexOf("/search?q=")>0) {
            var pageIndex = url.indexOf("page=");
            if(pageIndex>0) {

                window.location.href = window.location.href.substring(0,pageIndex-1) +  "&page=" + (parseInt(page)-1);
            }
            else {
                window.location.href+= "&page=" + (parseInt(page)-1);
            }
        }
        else {
            window.location.href = "?page=" + (parseInt(page)-1);        
        }
    }
})

