function initGame(thisGame) {
    // Select the game div
    var gameDiv = document.getElementById("game-container");
    // Clear the game div
    gameDiv.innerHTML = "";
    // Set start and end points visuals
    thisGame.map[0][0].setContent('<i class="fas fa-play"></i>');
    thisGame.map[thisGame.rows-1][thisGame.cols-1].setContent('<i class="fas fa-flag"></i>');
    // Set the current player position to 0,0
    currentCell = thisGame.map[0][0];
    // Mark the cell as visited
    currentCell.setVisited();
    // currentCell.setContent('<i class="fas fa-walking"></i>');
    // Initialise variable we'll be writing all the cells into
    output = "<table class=\"gameBox\">";
    // First, draw the grid according to rows and cols. We are counting from 0
    for(var y=0; y<thisGame.rows; y++) {
        output += "<tr class=\"horiz-wrapper\" id=\"horiz-wrapper"+y+"\">";
        for(var x=0; x<thisGame.cols; x++) {
            output += generateCellHTML(thisGame,x,y);
        }
        output += "</tr>";
    }
    output += "</table>";
    // Write all the grid info to the game box
    gameDiv.innerHTML = output;

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
    return "<td class=\"cell x"+x+" y"+y+
    // (thisGame.map[y][x].visited ? " visited" : "")+
    (thisGame.map[y][x].top ? " border-top" : "")+
    (thisGame.map[y][x].down ? " border-down" : "")+
    (thisGame.map[y][x].left ? " border-left" : "")+
    (thisGame.map[y][x].right ? " border-right" : "")+
    "\" id=\"x"+x+"y"+y+"\" onclick=\"navigateMaze(thisGame,currentCell,x,y)\">"+thisGame.map[y][x].content+"</td>";
}

function navigateMaze(thisGame,currentCell,newX,newY) {
    // TODO: Record invalid moves. Flash cells when correct/wrong.
    // Event triggered onclick for each maze cell
    // We're going to set it so any cell to the right of the current one will move the player to the right, regardless of whether it's the immediate right or has some other cells in between. 
    
    // We ignore diagonal taps because you can't move diagonally, that's cheating!
    if(newY !== currentCell.y && newX !== currentCell.x) {
        console.log("Sorry, no diagonal moves"); 
        return;
    }

    // Check if wall exists on both ends. If not, mark the new cell as visited and set it as current.
    newCell = thisGame.map[newY][newX];
    if(newY > currentCell.y) { // Move down
        if(currentCell.down || newCell.top) {
            hitWall(); return;
        }
        else {
            newCell.visualSetVisited();
        }
    }
    else if(newY < currentCell.y) { // Move up
        if(currentCell.top || newCell.down) {
            hitWall(); return;
        }
        else {
            
        }
    }
    else if(newX > currentCell.x) { // Move right
        if(currentCell.right || newCell.left) {
            hitWall(); return;
        }
        else {
            
        }
    }
    else if(newX < currentCell.x) { // Move left
        if(currentCell.left || newCell.right) {
            hitWall(); return;
        }
        else {
            
        }
    }
}

function hitWall() {
    console.log("Ouch, you hit a wall!");
}

function visualSetVisited(cell) {
    console.log("Marking "+cell.x+","+cell.y+" as visited.");
    cell.setVisited();
    document.getElementById("x"+cell.x+"y"+cell.y).classList.add("visited");
}