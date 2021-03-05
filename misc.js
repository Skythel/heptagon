// Misc functions. 

// Receives an error message from any other function and displays it in a user-friendly format. 
function throwError(e) { 
    var wrapper = document.getElementsByClassName("wrapper")[0];
    var element = document.createElement("div");
    element.classList.add("error");
    element.innerHTML = e;
    wrapper.appendChild(element);
}
function successMessage(m) {
    var wrapper = document.getElementsByClassName("wrapper")[0];
    var element = document.createElement("div");
    element.classList.add("success");
    element.innerHTML = m;
    wrapper.appendChild(element);
}