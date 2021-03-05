// Misc functions. 

// Receives an error message from any other function and displays it in a user-friendly format. 
function throwError(e) { 
    clearMessages("all");
    var wrapper = document.getElementsByClassName("wrapper")[0];
    var element = document.createElement("div");
    element.classList.add("error");
    element.classList.add("message");
    element.innerHTML = e;
    wrapper.appendChild(element);
}
// Receives a success message from any other function and displays it in a user-friendly format.
function successMessage(m) {
    clearMessages("all");
    var wrapper = document.getElementsByClassName("wrapper")[0];
    var element = document.createElement("div");
    element.classList.add("success");
    element.classList.add("message");
    element.innerHTML = m;
    wrapper.appendChild(element);
}
// Clears all message elements of a certain type.
function clearMessages(t) {
    if(t=="all") {
        var path = "document.getElementsByClassName(\"message\")";
    }
    else {
        var path = "document.getElementsByClassName(t)";
    }
    for(var i=0; i<path.length; i++) {
        path[i].parentNode.removeChild(path[i]);
    }
}