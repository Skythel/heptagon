// Misc functions. 

// Receives an error message from any other function and displays it in a user-friendly format. 
function throwError(e) { 
    var element = document.createElement("div");
    element.classList.add("error");
    element.innerHTML = e;
    document.body.appendChild(element);
}
function successMessage(m) {
    var element = document.createElement("div");
    element.classList.add("success");
    element.innerHTML = m;
    document.body.appendChild(element);
}