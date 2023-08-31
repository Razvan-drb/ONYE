let popUp = document.getElementById("cookiePopup");

const acceptCookies = () => {
    // Create date object
    let d = new Date();
    // Increment the current time by 7 days (cookie will expire after 7 days)
    d.setDate(d.getDate() + 7);
    // Create Cookie with name = myCookieName, value = thisIsMyCookie and expiry time = 7 days
    document.cookie = "myCookieName=thisIsMyCookie; expires=" + d.toUTCString() + "; path=/; domain=http://localhost:8888/index.php;";
    // Hide the popup
    popUp.classList.add("hide");
    popUp.classList.remove("show");
};

const refuseCookies = () => {
    // Hide the popup
    popUp.classList.add("hide");
    popUp.classList.remove("show");
};

document.getElementById("acceptCookie").addEventListener("click", acceptCookies);
document.getElementById("refuseCookie").addEventListener("click", refuseCookies);

const checkCookie = () => {
    let input = document.cookie.split("=");
    if (input[0] == "myCookieName") {
        popUp.classList.add("hide");
        popUp.classList.remove("show");
    } else {
        popUp.classList.add("show");
        popUp.classList.remove("hide");
    }
};

window.onload = () => {
    setTimeout(() => {
        checkCookie();
    }, 2000);
};



/* clear cart */

