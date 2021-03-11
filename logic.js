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

    // Record the path taken in order 
    var path = [];
    
    // Trace a path through the map
    var thisCell = start;
    while(thisCell.x!==end.x || thisCell.y!==end.y) {
        // Mark the current cell as visited
        thisCell.setVisited();
        // Add cell to path
        path.push(thisCell);
        console.log("Move #"+path.length+": I visited "+thisCell.x+","+thisCell.y);
        // console.log("The map now looks like this: ");
        // console.log(map); 
        
        // Pick a random neighbour and move there.
        var neighbourOptions = [];
        var direction = ""; // For easy removing of border later
        // First check all 4 neighbours for invalid positions or already visited. 
        if(thisCell.y-1>-1 && map[thisCell.y-1][thisCell.x].visited==false) {
            direction = "up";
            neighbourOptions.push([map[thisCell.y-1][thisCell.x],direction]);
        }
        if(thisCell.y+1<rows && map[thisCell.y+1][thisCell.x].visited==false) {
            direction = "down";
            neighbourOptions.push([map[thisCell.y+1][thisCell.x],direction]);
        }
        if(thisCell.x+1<cols && map[thisCell.y][thisCell.x+1].visited==false) {
            direction = "right";
            neighbourOptions.push([map[thisCell.y][thisCell.x+1],direction]);
        }
        if(thisCell.x-1>-1 && map[thisCell.y][thisCell.x-1].visited==false) {
            direction = "left";
            neighbourOptions.push([map[thisCell.y][thisCell.x-1],direction]);
        }
        if(neighbourOptions.length>0) {
            console.log("Possible neighbours: ");
            console.log(neighbourOptions);
            // Choose random neighbour
            var randIndex = Math.floor(Math.random()*(neighbourOptions.length));
            var nextCell = neighbourOptions[randIndex][0];
            // Remove border between the cells
            switch(neighbourOptions[randIndex][1]) {
                case "up": // Remove top border of current cell and bottom border of new cell
                    thisCell.removeTopBorder(); 
                    nextCell.removeDownBorder();
                    break;
                case "down": // Remove bottom border and top border of new cell
                    thisCell.removeDownBorder(); 
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
                    console.log("An error occured when removing neighbouring borders.")
                    break;
            }
            console.log("I have removed a border in the direction of "+neighbourOptions[randIndex][1]);
            // Change cells
            thisCell = nextCell;
            console.log("I'm going to "+thisCell.x+","+thisCell.y);
        }
        else {
            // No valid neighbours, backtrack to prev cell. 
            // if((thisCell.x == path[path.length-1].x && thisCell.y == path[path.length-1].y) || path[path.length-1].deadend) {
            //     // We're going back and forth, this cell is a dead end
            //     console.log("We're going in circles around "+thisCell.x+","+thisCell.y+"!");
            //     // Set the cell as dead end
            //     thisCell.setDeadEnd();
            //     // Find a cell to backtrack to that isn't a dead end
            //     thisCell = findCell(path);
            //     if(thisCell==1) {
            //         console.log("An error occurred."); break;
            //     }
            // }
            // thisCell = path[path.length-1];
            console.log("I couldn't find a valid neighbour. I'm going back to "+path[path.length-1].x+","+path[path.length-1].y);
            thisCell.setDeadEnd();
            thisCell = findCell(map,path);
        }
    }
    console.log("I reached the end!");
    // Mark last cell as visited
    thisCell.setVisited();
    // Ensure no cells are left unvisited
    console.log("Looping through unvisited cells.");
    for(var y=0; y<rows; y++) {
        for(var x=0; x<cols; x++) {
            console.log(x+","+y+": "+map[y][x].visited);
            if(!map[y][x].visited) {
                // Mark visited
                map[y][x].setVisited();
                // Still has 4 borders, select a random one adjacent to a visited cell to unlock
                var options = [];
                if(y-1>-1 && map[y-1][x].visited) {
                    options.push(map[y-1][x]);
                }
                if(y+1<map.length && map[y+1][x].visited) {
                    options.push(map[y+1][x]);
                }
                if(x+1<map[0].length && map[y][x+1].visited) {
                    options.push(map[y][x+1]);
                }
                if(x-1>-1 && map[y][x-1].visited) {
                    options.push(map[y][x-1]);
                }
                var newCell = options[Math.floor(Math.random()*options.length)];
                // Remove borders
                if(y-1==newCell.y && x==newCell.x) {
                    map[y][x].removeTopBorder(); 
                    newCell.removeDownBorder();
                    console.log("Removing top border of "+x+","+y+" and bottom border of "+newCell.x+","+newCell.y);
                }
                else if(y+1==newCell.y && x==newCell.x) {
                    map[y][x].removeDownBorder(); 
                    newCell.removeTopBorder();
                    console.log("Removing bottom border of "+x+","+y+" and top border of "+newCell.x+","+newCell.y);
                }            
                else if(y==newCell.y && x+1==newCell.x) {
                    map[y][x].removeRightBorder(); 
                    newCell.removeLeftBorder();
                    console.log("Removing right border of "+x+","+y+" and left border of "+newCell.x+","+newCell.y);
                }
                else if(y==newCell.y && x-1==newCell.x) {
                    map[y][x].removeLeftBorder(); 
                    newCell.removeRightBorder();
                    console.log("Removing left border of "+x+","+y+" and right border of "+newCell.x+","+newCell.y);
                }   
            }
        }
    }
    return map;
}

// Find a suitable cell for backtracking. Returns object cell
function findCell(map,path) {
    // for(var i=path.length-1; i>=0; i--) {
        // if(!path[path.length-1].deadend) {
        //     return path[path.length-1];
        // }
        var thisCell = path[path.length-1];
        console.log("Checking "+thisCell.x+","+thisCell.y);
        var neighbourOptions = [];
        if(thisCell.y-1>-1 && map[thisCell.y-1][thisCell.x].visited==false) {
            neighbourOptions.push(map[thisCell.y-1][thisCell.x]);
        }
        if(thisCell.y+1<map.length && map[thisCell.y+1][thisCell.x].visited==false) {
            neighbourOptions.push(map[thisCell.y+1][thisCell.x]);
        }
        if(thisCell.x+1<map[0].length && map[thisCell.y][thisCell.x+1].visited==false) {
            neighbourOptions.push(map[thisCell.y][thisCell.x+1]);
        }
        if(thisCell.x-1>-1 && map[thisCell.y][thisCell.x-1].visited==false) {
            neighbourOptions.push(map[thisCell.y][thisCell.x-1]);
        }
        if(neighbourOptions.length > 0) {
            var newCell = neighbourOptions[Math.floor(Math.random()*neighbourOptions.length)];
            // Remove borders
            if(thisCell.y-1==newCell.y && thisCell.x==newCell.x) {
                thisCell.removeTopBorder(); 
                newCell.removeDownBorder();
                console.log("Removing top border of "+thisCell.x+","+thisCell.y+" and bottom border of "+newCell.x+","+newCell.y);
            }
            else if(thisCell.y+1==newCell.y && thisCell.x==newCell.x) {
                thisCell.removeDownBorder(); 
                newCell.removeTopBorder();
                console.log("Removing bottom border of "+thisCell.x+","+thisCell.y+" and top border of "+newCell.x+","+newCell.y);
            }            
            else if(thisCell.y==newCell.y && thisCell.x+1==newCell.x) {
                thisCell.removeRightBorder(); 
                newCell.removeLeftBorder();
                console.log("Removing right border of "+thisCell.x+","+thisCell.y+" and left border of "+newCell.x+","+newCell.y);
            }
            else if(thisCell.y==newCell.y && thisCell.x-1==newCell.x) {
                thisCell.removeLeftBorder(); 
                newCell.removeRightBorder();
                console.log("Removing left border of "+thisCell.x+","+thisCell.y+" and right border of "+newCell.x+","+newCell.y);
            }   
            return newCell;
        }
        else {
            console.log(thisCell.x+","+thisCell.y+" is also a dead end.");
            thisCell.setDeadEnd();
            path.pop();
            return findCell(map,path);
        }
    // }
    // console.log("Oops, something in the backtracking went wrong.")
    // console.log(path);
    // return 1;
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