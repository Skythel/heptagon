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
    console.log("Difficulty has been set to "+level+" with variables "+cols+" cols, "+rows+"rows, "+puzzleIcons+"icons and "+puzzleChoices+" choices.");
    // Call the initialise function
    initGame();
}

function initGame() {
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

