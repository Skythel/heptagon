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

// Define class game
class game {
    constructor(cols, rows, puzzleIcons, puzzleChoices) {
        this.cols = cols;
        this.rows = rows;
        this.puzzleIcons = puzzleIcons;
        this.puzzleChoices = puzzleChoices;
        // this.maze = new maze();
    }
    setPath() { 
        // Sets the path for a new maze. 
        // Assuming the start is at (0,0) and the end is at (cols-1,rows-1)
        var start = [0,0];
        var end = [cols-1,rows-1];

        // Let's draw a map of every cell. 0=not visited, 1=visited. For initialising we set all cells to 0
        var map = []
        for(var y=0; y<rows; y++) {
            map.push([]);
            for(var x=0; x<cols; x++) {
                map[y].push(0);
            }
        }
        console.log(map);

        // Trace a path through the map
        var thisCell = start;
        while(thisCell!=end) {
            // Mark the current cell as visited
            map[thisCell[0]][thisCell[1]] = 1;
            console.log("I visited "+thisCell);
            // Pick a random neighbour and move there.
            var neighbourOptions = [];
            // First check all 4 neighbours for invalid positions or already visited
            // Shift left
            if(typeof map[thisCell[0]-1][thisCell[1]]!=="undefined" && map[thisCell[0]-1][thisCell[1]]==0) {
                neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
            }
            // Shift right
            if(typeof map[thisCell[0]+1][thisCell[1]]!=="undefined" && map[thisCell[0]+1][thisCell[1]]==0) {
                neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
            }
            // Shift up
            if(typeof map[thisCell[0]][thisCell[1]+1]!=="undefined" && map[thisCell[0]][thisCell[1]+1]==0) {
                neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
            }
            // Shift down
            if(typeof map[thisCell[0]][thisCell[1]-1]!=="undefined" && map[thisCell[0]][thisCell[1]-1]==0) {
                neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
            }
            if(neighbourOptions !== []) {
                // Choose random neighbour
                thisCell = neighbourOptions[Math.floor(Math.random()*(neighbourOptions.length))];
                console.log("I'm going to "+thisCell);
            }
            else {
                // No valid neighbours, backtrack. Loop through all neighbouring visited cells and pick a random one.
                if(typeof map[thisCell[0]-1][thisCell[1]]!=="undefined" && map[thisCell[0]-1][thisCell[1]]==1) {
                    neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
                }
                // Shift right
                if(typeof map[thisCell[0]+1][thisCell[1]]!=="undefined" && map[thisCell[0]+1][thisCell[1]]==1) {
                    neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
                }
                // Shift up
                if(typeof map[thisCell[0]][thisCell[1]+1]!=="undefined" && map[thisCell[0]][thisCell[1]+1]==1) {
                    neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
                }
                // Shift down
                if(typeof map[thisCell[0]][thisCell[1]-1]!=="undefined" && map[thisCell[0]][thisCell[1]-1]==1) {
                    neighbourOptions.push([thisCell[0]-1,thisCell[1]]);
                }
                thisCell = neighbourOptions[Math.floor(Math.random()*(neighbourOptions.length))];
                console.log("I couldn't find a valid neighbour. I'm going back to "+thisCell);
            }
        }
        console.log("I reached the end!");
        console.log(map);
    }
    setObstacles() {
        // Sets obstacles for the maze. 

    }

}

// Define class maze
// class maze {
//     constructor() {

//     }
// }

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
    initGame();
}

function initGame() {
    // Select the game div
    var gameDiv = document.getElementById("game-container");
    // Clear the game div
    gameDiv.innerHTML = "";
    // Initialise variable we'll be writing all the cells into
    output = "";
    // First, draw the grid according to rows and cols. We are counting from 0
    for(var y=0; y<rows; y++) {
        for(var x=0; x<cols; x++) {
            output += "<div class=\"cell x"+x+" y"+y+"\" id=\"x"+x+"y"+y+"\"></div>\n";
        }
    }
    console.log(output);
}

