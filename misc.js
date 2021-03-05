// Misc functions. 

// Receives an error message from any other function and displays it in a user-friendly format. 
function throwError(e) { 
    var element = document.createElement("div");
    element.classList.add("error");
    element.innerHTML = e;
    document.body.appendChild(element);
}