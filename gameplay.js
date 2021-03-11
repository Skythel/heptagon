const playerMarker = "<i class=\"fas fa-walking fa-3x playerMarker\"></i>";
function initGame(thisGame) {
    // Select the game div
    var gameDiv = document.getElementById("game-container");
    // Clear the game div
    gameDiv.innerHTML = "";
    // Set start and end points visuals
    thisGame.map[0][0].setContent('<i class="fas fa-play"></i>');
    thisGame.map[thisGame.rows-1][thisGame.cols-1].setContent('<i class="fas fa-flag"></i>');

    // Commenting because already defined in class
    // Set the current player position to 0,0 
    // thisGame.currentCell = thisGame.map[0][0];

    // Mark the cell as visited
    thisGame.currentCell.setVisited();
    thisGame.currentCell.setContent(playerMarker);
    // Initialise variable we'll be writing all the cells into
    // output = "<table class=\"gameBox\">";
    var t = document.createElement("table");
    t.classList.add("gameBox");

    // First, draw the grid according to rows and cols. We are counting from 0
    for(var y=0; y<thisGame.rows; y++) {
        var tr = document.createElement("tr");
        tr.classList.add("horiz-wrapper");
        tr.id = "horiz-wrapper"+y;
        t.appendChild(tr);
        // output += "<tr class=\"horiz-wrapper\" id=\"horiz-wrapper"+y+"\">";
        for(var x=0; x<thisGame.cols; x++) {
            tr.appendChild(generateCellHTML(thisGame,x,y));
        }
        // output += "</tr>";
    }
    // output += "</table>";
    // Write all the grid info to the game box
    // gameDiv.innerHTML = output;
    gameDiv.appendChild(t);
    visualSetVisited(thisGame.currentCell);
    // Adjust border styling for edges of game grid
    // var tRows = document.getElementsByClassName("horiz-wrapper");
    // for(var t=0; t<tRows.length; t++) {
    //     tRows[t].style.borderLeft = "3px solid var(--sub-font-color)";
    //     tRows[t].style.borderRight = "3px solid var(--sub-font-color)";
    //     if(t==0) {
    //         tRows[t].style.borderTop = "3px solid var(--sub-font-color)"
    //     }
    //     if(t==tRows-1) {
    //         tRows[t].style.borderBottom = "3px solid var(--sub-font-color)"
    //     }
    // }
}

function generateCellHTML(thisGame,x,y) {
    var cell = document.createElement("td");
    cell.className = "cell x"+x+" y"+y;
    cell.id = "x"+x+"y"+y;
    if (thisGame.map[y][x].top) cell.classList.add("border-top");
    if (thisGame.map[y][x].down) cell.classList.add("border-down");
    if (thisGame.map[y][x].left) cell.classList.add("border-left");
    if (thisGame.map[y][x].right) cell.classList.add("border-right");
    cell.innerHTML = thisGame.map[y][x].content;
    cell.onclick = function() {
        navigateMaze(thisGame,x,y);
    }
    return cell;
    // "<td class=\"cell x"+x+" y"+y+
    // (thisGame.map[y][x].visited ? " visited" : "")+
    // (thisGame.map[y][x].top ? " border-top" : "")+
    // (thisGame.map[y][x].down ? " border-down" : "")+
    // (thisGame.map[y][x].left ? " border-left" : "")+
    // (thisGame.map[y][x].right ? " border-right" : "")+
    // "\" id=\"x"+x+"y"+y+"\" onclick='navigateMaze("+thisGame,currentCell,x,y+"')>"+thisGame.map[y][x].content+"</td>";
}

// Fix to allow keyboard moves with arrow keys
document.onkeydown = checkKey;
function checkKey(e) {
    e = e || window.event;
    // Find player current position cause we don't have thisGame object on keypress
    var id = "";
    for(var i=0; i<document.getElementsByClassName("cell").length; i++) {
        if(document.getElementsByClassName("cell")[i].innerHTML == playerMarker) {
            id = document.getElementsByClassName("cell")[i].id; // x0y0
            break;
        }
    }
    // Somehow the player icon was not found, return
    if(id == "") return;

    if (e.keyCode == '38') {
        // up arrow
        var newCoord = Number(id.substr(3,1))-1;
        if(newCoord >= 0) {
            var newId = id.substr(0,3)+newCoord;
            document.getElementById(newId).click();
        }
    }
    else if (e.keyCode == '40') {
        // down arrow
        var newCoord = Number(id.substr(3,1))+1;
        if(newCoord < document.getElementsByClassName("horiz-wrapper").length) {
            var newId = id.substr(0,3)+newCoord;
            document.getElementById(newId).click();
        }
    }
    else if (e.keyCode == '37') {
       // left arrow
       var newCoord = Number(id.substr(1,1))-1;
       if(newCoord >= 0) {
           var newId = "x"+newCoord+id.substr(2,2);
           document.getElementById(newId).click();
       }
    }
    else if (e.keyCode == '39') {
       // right arrow
       var newCoord = Number(id.substr(1,1))+1;
       if(newCoord < document.getElementsByClassName("horiz-wrapper")[0].getElementsByClassName("cell").length) {
           var newId = "x"+newCoord+id.substr(2,2);
           document.getElementById(newId).click();
       }
    }
}

function navigateMaze(thisGame,newX,newY) {
    // TODO: Record invalid moves. Flash cells when correct/wrong.
    // Event triggered onclick for each maze cell
    // We're going to set it so any cell to the right of the current one will move the player to the right, regardless of whether it's the immediate right or has some other cells in between. 
    
    var currentCell = thisGame.currentCell;

    // We ignore diagonal taps because you can't move diagonally, that's cheating!
    if(newY !== currentCell.y && newX !== currentCell.x) {
        // Should we flash the cell red here also? 
        console.log("Sorry, no diagonal moves"); 
        return;
    }

    // Check if wall exists on both ends. If not, mark the new cell as visited and set it as current.
    newCell = thisGame.map[newY][newX];
    if(newY > currentCell.y) { // Move down
        newCell = thisGame.map[currentCell.y+1][currentCell.x];
        if(currentCell.down || newCell.top) {
            hitWall(newCell); return;
        }
        else {
            movePlayer(thisGame,newCell);
        }
    }
    else if(newY < currentCell.y) { // Move up
        newCell = thisGame.map[currentCell.y-1][currentCell.x];
        if(currentCell.top || newCell.down) {
            hitWall(newCell); return;
        }
        else {
            movePlayer(thisGame,newCell);
        }
    }
    else if(newX > currentCell.x) { // Move right
        newCell = thisGame.map[currentCell.y][currentCell.x+1];
        if(currentCell.right || newCell.left) {
            hitWall(newCell); return;
        }
        else {
            movePlayer(thisGame,newCell);
        }
    }
    else if(newX < currentCell.x) { // Move left
        newCell = thisGame.map[currentCell.y][currentCell.x-1];
        if(currentCell.left || newCell.right) {
            hitWall(newCell); return;
        }
        else {
            movePlayer(thisGame,newCell);
        }
    }
}

function hitWall(cell) {
    // Flash cell (wall?) red
    setTimeout(hitWall(cell),500);
    // console.log("Ouch, you hit a wall!");
}

function visualSetVisited(cell) {
    console.log("Marking "+cell.x+","+cell.y+" as visited.");
    cell.setVisited();
    document.getElementById("x"+cell.x+"y"+cell.y).classList.add("visited");
}

function movePlayer(thisGame,newCell) {
    // Function to move the visible player to the new cell.
    // Check if it is the finish cell
    if(newCell.x == thisGame.rows-1 && newCell.y == thisGame.cols-1) {
        console.log("Hooray, you finished the maze!");
    }
    // Remove player marker from current cell
    thisGame.currentCell.setContent("");
    document.getElementById("x"+thisGame.currentCell.x+"y"+thisGame.currentCell.y).innerHTML = "";
    // Set player marker on the new cell
    newCell.setContent(playerMarker);
    thisGame.currentCell = newCell;
    document.getElementById("x"+thisGame.currentCell.x+"y"+thisGame.currentCell.y).innerHTML = playerMarker;
    // Call visualSetVisited()
    visualSetVisited(newCell);
}