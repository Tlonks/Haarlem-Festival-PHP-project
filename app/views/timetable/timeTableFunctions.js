function addTicket($ticketRowId, $button, $div) {

    if (sessionStorage.getItem("rowId") != $ticketRowId && sessionStorage.getItem("rowId") != null) {
        document.getElementById(sessionStorage.getItem("rowId")).style.height = "50px";
        document.getElementById(sessionStorage.getItem("buttonId")).style.display = "block";
        document.getElementById(sessionStorage.getItem("divId")).style.display = "none";
    }

    document.getElementById($ticketRowId).style.height = "200px";
    document.getElementById($button).style.display = "none";

    // Place the previous rowId and buttonId in the session storage
    sessionStorage.setItem("rowId", $ticketRowId);
    sessionStorage.setItem("buttonId", $button);
    sessionStorage.setItem("divId", $div);

    const div = document.getElementById($div);

    div.style.display = "flex";
    div.style.height = "75%";
    div.style.width = "80%";
    div.style.borderRadius = "20px";
    div.style.backgroundColor = "#0089D7";
    div.style.justifyContent = "center";
    div.style.alignItems = "center";
    div.style.flexDirection = "column";
}

function resetSessionStorage() {
    //https://stackoverflow.com/questions/45211303/how-to-connect-between-the-sessionstorage-in-php-to-js
    sessionStorage.clear();
}

function openPopUpMessage(){
    document.getElementById("popUpMessage").style.display = "block";
}

function closePopUpMessage(){
    document.getElementById("popUpMessage").style.display = "none";
}