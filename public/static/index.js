
document.getElementById("next_page").addEventListener("click",function(){
    var page = window.location.href.split("?page=")[1];
    if (page==undefined) {
        page = 0;
    }
    window.location.href = "?page=" + (parseInt(page)+1);
})


window.addEventListener("load", function(){
    var page = window.location.href.split("?page=")[1];
    if (page==undefined) {
        page = 0;
    }
    if(page==0){
        this.document.getElementById("previous_page").style.display="none";
    }
});

document.getElementById("previous_page").addEventListener("click",function(){
    var page = window.location.href.split("?page=")[1];
    if (page==undefined) {
        page = 0;
    }
    if(page>0)
        window.location.href = "?page=" + (parseInt(page)-1);
})

