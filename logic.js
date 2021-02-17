// Logic script for the maze. 

// Define difficulty levels
var levels = { 
    easy: {
        cols: 4,
        rows: 4,
        puzzleIcons: 1,
        puzzleChoices: 3 
    },
    med: {
        cols: 5,
        rows: 5,
        puzzleIcons: 3,
        puzzleChoices: 5
    },
    hard: {
        cols: 6,
        rows: 6,
        puzzleIcons: 5,
        puzzleChoices: 7 
    }
};

// Define class maze
// class maze {
//     constructor() {
//     }
// }

function setPath(cols,rows) { 
    // Sets the path for a new maze. 
    // Let's draw a map of every cell. 
    var map = [];
    for(var y=0; y<rows; y++) {
        map.push([]);
        for(var x=0; x<cols; x++) {
            var newCell = new cell(x,y);
            map[y].push(newCell);
        }
    }
    
    // Assuming the start is at 0,0 (top left) and the end is at cols-1,rows-1 (bottom right).
    var start = map[0][0];
    var end = map[cols-1][rows-1];
    console.log("The end is at "+end.x+","+end.y);
    
    // Trace a path through the map
    var thisCell = start;
    while(thisCell.x!==end.x || thisCell.y!==end.y) {
        // Mark the current cell as visited
        map[thisCell.x][thisCell.y].setVisited();
        console.log("I visited "+thisCell.x+","+thisCell.y);
        // console.log("The map now looks like this: ");
        // console.log(map); 
        
        // Pick a random neighbour and move there.
        
        var neighbourOptions = [];
        var direction = ""; // For easy removing of border later
        // First check all 4 neighbours for invalid positions or already visited. 
        if(thisCell.y-1>-1 && map[thisCell.y-1][thisCell.x].visited==false) {
            direction = "left";
            neighbourOptions.push([map[thisCell.y-1][thisCell.x],direction]);
        }
        if(thisCell.y+1<rows && map[thisCell.y+1][thisCell.x].visited==false) {
            direction = "right";
            neighbourOptions.push([map[thisCell.y+1][thisCell.x],direction]);
        }
        if(thisCell.x+1<cols && map[thisCell.y][thisCell.x+1].visited==false) {
            direction = "down";
            neighbourOptions.push([map[thisCell.y][thisCell.x+1],direction]);
        }
        if(thisCell.x-1>-1 && map[thisCell.y][thisCell.x-1].visited==false) {
            direction = "up";
            neighbourOptions.push([map[thisCell.y][thisCell.x-1],direction]);
        }
        if(neighbourOptions.length>0) {
            // Choose random neighbour
            var randIndex = Math.floor(Math.random()*(neighbourOptions.length));
            var nextCell = neighbourOptions[randIndex][0];
            // Remove border between the cells
            switch(neighbourOptions[randIndex][1]) {
                case "up": // Remove top border of current cell and bottom border of new cell
                    thisCell.removeTopBorder(); 
                    nextCell.removeBottomBorder();
                    break;
                case "down": // Remove bottom border and top border of new cell
                    thisCell.removeBottomBorder(); 
                    nextCell.removeTopBorder();
                    break;
                case "left": // Remove left border and right border of new cell
                    thisCell.removeLeftBorder(); 
                    nextCell.removeRightBorder();
                    break;
                case "right": // Remove right border and left border of new cell
                    thisCell.removeRightBorder();
                    nextCell.removeLeftBorder(); 
                    break;
                default: // Something went wrong
                    break;
            }
            console.log("I have removed a border in the direction of "+neighbourOptions[randIndex][1]);
            // Change cells
            thisCell = nextCell;
            console.log("I'm going to "+thisCell.x+","+thisCell.y);
        }
        else {
            // No valid neighbours, backtrack. Loop through all neighbouring visited cells and pick a random one.
            if(typeof map[thisCell.y-1]!=="undefined") {
            	if(typeof map[thisCell.y-1][thisCell.x]!=="undefined") {
                    neighbourOptions.push(map[thisCell.y-1][thisCell.x]);
                }
            }
            if(typeof map[thisCell.y+1]!=="undefined") {
            	if(typeof map[thisCell.y+1][thisCell.x]!=="undefined"){ 
                    neighbourOptions.push(map[thisCell.y+1][thisCell.x]);
                }
            }
            if(typeof map[thisCell.y][thisCell.x+1]!=="undefined") {
                neighbourOptions.push(map[thisCell.y][thisCell.x+1]);
            }
            if(typeof map[thisCell.y][thisCell.x-1]!=="undefined") {
                neighbourOptions.push(map[thisCell.y][thisCell.x-1]);
            }
            thisCell = neighbourOptions[Math.floor(Math.random()*(neighbourOptions.length))];
            
            // Set current cell as dead end; not to revisit
            // thisCell.deadend = true;
            // // Select a random wall out of the open ones and cross to that cell
            // var openBorders = [];
            // if(!thisCell.top && !map[thisCell.y-1][thisCell.x].deadend) {
            //     openBorders.push("top");
            // }
            // if(!thisCell.left && !map[thisCell.y][thisCell.x-1].deadend) {
            //     openBorders.push("left");
            // }
            // if(!thisCell.right && !map[thisCell.y][thisCell.x+1].deadend) {
            //     openBorders.push("right");
            // }
            // if(!thisCell.down && !map[thisCell.y+1][thisCell.x].deadend) {
            //     openBorders.push("down");
            // }
            // var randBorder = Math.floor(Math.random()*(openBorders.length));
            // switch(openBorders[randBorder]) {
            //     case "top": // Move across the top border
            //         thisCell = map[thisCell.y-1][thisCell.x]; break;
            //     case "down": // Move across the bottom border
            //         thisCell = map[thisCell.y+1][thisCell.x]; break;
            //     case "left": // Move across the left border
            //         thisCell = map[thisCell.y][thisCell.x-1]; break;
            //     case "right": // Move across the right border
            //         thisCell = map[thisCell.y][thisCell.x+1]; break;
            //     default: // Something went wrong
            //         break;
            // }
            console.log("I couldn't find a valid neighbour. I'm going back to "+thisCell.x+","+thisCell.y);
        }
    }
    console.log("I reached the end!");
    // Mark last cell as visited
    map[thisCell.x][thisCell.y].setVisited();
    // console.log(map);
    return map;
}

// Create new game object and set variables
function setDifficulty(level) {
    if(level=="hard") {
        var cols = levels.hard.cols;
        var rows = levels.hard.rows;
        var puzzleIcons = levels.hard.puzzleIcons;
        var puzzleChoices = levels.hard.puzzleChoices;
    }
    else if(level=="med") {
        var cols = levels.med.cols;
        var rows = levels.med.rows;
        var puzzleIcons = levels.med.puzzleIcons;
        var puzzleChoices = levels.med.puzzleChoices;
    }
    else { // Default easy
        var cols = levels.easy.cols;
        var rows = levels.easy.rows;
        var puzzleIcons = levels.easy.puzzleIcons;
        var puzzleChoices = levels.easy.puzzleChoices;
    }

    // Create the object
    let thisGame = new game(cols,rows,puzzleIcons,puzzleChoices);

    console.log("Difficulty has been set to "+level+" with variables "+thisGame.cols+" cols, "+thisGame.rows+" rows, "+thisGame.puzzleIcons+" icons and "+thisGame.puzzleChoices+" choices.");
    // Call the initialise function
    initGame(thisGame);
}

function initGame(thisGame) {
    // Select the game div
    var gameDiv = document.getElementById("game-container");
    // Clear the game div
    gameDiv.innerHTML = "";
    // Set the current player position to 0,0
    currentCell = thisGame.map[0][0];
    // Mark the cell as visited
    currentCell.setVisited();
    // Initialise variable we'll be writing all the cells into
    output = "";
    // First, draw the grid according to rows and cols. We are counting from 0
    for(var y=0; y<thisGame.rows; y++) {
        for(var x=0; x<thisGame.cols; x++) {
            output += "<div class=\"cell x"+x+" y"+y+(map[y][x].visited ? " visited" : "")+"\" id=\"x"+x+"y"+y+"\" onclick=\"navigateMaze(thisGame,currentCell,x,y)\"></div>";
        }
        output += "<br/>";
    }
    // Write all the grid info to the game box
    gameDiv.innerHTML = output;
}

function navigateMaze(thisGame,currentCell,newX,newY) {
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