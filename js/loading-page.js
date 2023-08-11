document.getElementById("body").classList.add('body-loading');
document.getElementById("body-content").style.display = "none";
document.getElementById("page-waiting").style.display = "block";

window.addEventListener('load', function () {
    //set page loading time
    //1000 = 1s 
    setTimeout(function () {
        document.getElementById("page-waiting").style.display = "none";
        document.getElementById("body-content").style.display = "block";
        document.getElementById("body").classList.remove('body-loading');
    }, 1000);
});