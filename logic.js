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

// Set variables to initials
function setDifficulty(level) {
    if(level=="hard") {
        const cols = levels.hard.cols;
        const rows = levels.hard.rows;
        const puzzleIcons = levels.hard.puzzleIcons;
        const puzzleChoices = levels.hard.puzzleChoices;
    }
    else if(level=="med") {
        const cols = levels.med.cols;
        const rows = levels.med.rows;
        const puzzleIcons = levels.med.puzzleIcons;
        const puzzleChoices = levels.med.puzzleChoices;
    }
    else { // Default easy
        const cols = levels.easy.cols;
        const rows = levels.easy.rows;
        const puzzleIcons = levels.easy.puzzleIcons;
        const puzzleChoices = levels.easy.puzzleChoices;
    }
    console.log("Difficulty has been set to "+level+" with variables "+cols+" cols, "+rows+" rows, "+puzzleIcons+" icons and "+puzzleChoices+" choices.");
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
    // First, draw the grid according to rows and cols
    for(var y=0; y<rows; y++) {
        for(var x=0; x<cols; x++) {
            output += "<div class=\"cell x"+x+" y"+y+"\" id=\"x"+x+"y"+y+"\"></div>\n";
        }
    }
    console.log(output);
}

