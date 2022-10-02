let previousScrollPosition = window.pageYOffset;

window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}

window.onscroll = function() {
    let currentScrollPosition = window.pageYOffset;

    if(previousScrollPosition > currentScrollPosition) {
        document.getElementById("navbar").style.top = "0";
    } 
    else {
        document.getElementById("navbar").style.top = "-7rem";
    }

    previousScrollPosition = currentScrollPosition;
}

function shrinkHamburger() {

    if(document.getElementById("bar1").style.marginBottom == "") {
        document.getElementById("bar1").style.marginBottom = "-9px";
        document.getElementById("bar3").style.marginTop = "-9px";
        document.getElementById("sideNav").style.width = "350px";
    } else {
        document.getElementById("bar1").style.marginBottom = "";
        document.getElementById("bar3").style.marginTop = "";
        document.getElementById("sideNav").style.width = "0px";
    }
}