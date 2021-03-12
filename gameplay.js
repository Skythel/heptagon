const playerMarker = "<i class=\"fas fa-walking fa-3x playerMarker\"></i>";

function initGame(thisGame) {
    // Select the game div
    var gameDiv = document.getElementById("game-container");
    // Clear the game div
    gameDiv.innerHTML = "";
    // Set start and end points visuals
    thisGame.map[0][0].setContent('<i class="fas fa-play"></i>');
    thisGame.map[thisGame.rows - 1][thisGame.cols - 1].setContent('<i class="fas fa-flag"></i>');

    // Set score, time, obstacles and countdown displays
    var stats = document.createElement("div");
    stats.classList.add("stats");

    var scoreDisplay = document.createElement("div");
    scoreDisplay.classList.add("gameDisplay", "score");

    var timerDisplay = document.createElement("div");
    timerDisplay.classList.add("gameDisplay", "timer");
    timerDisplay.style.display = "none";

    var obstacleCountDisplay = document.createElement("div");
    obstacleCountDisplay.classList.add("gameDisplay", "obstacleCount");

    var countdownDisplay = document.createElement("div");
    countdownDisplay.classList.add("gameDisplay", "countdown");

    stats.appendChild(scoreDisplay);
    stats.appendChild(timerDisplay);
    stats.appendChild(countdownDisplay);
    stats.appendChild(obstacleCountDisplay);
    gameDiv.appendChild(stats);

    document.getElementsByClassName("score")[0].innerHTML = 0;
    document.getElementsByClassName("timer")[0].innerHTML = 0;
    document.getElementsByClassName("countdown")[0].innerHTML = 3;
    document.getElementsByClassName("obstacleCount")[0].innerHTML = 0;

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
    for (var y = 0; y < thisGame.rows; y++) {
        var tr = document.createElement("tr");
        tr.classList.add("horiz-wrapper");
        tr.id = "horiz-wrapper" + y;
        t.appendChild(tr);
        // output += "<tr class=\"horiz-wrapper\" id=\"horiz-wrapper"+y+"\">";
        for (var x = 0; x < thisGame.cols; x++) {
            tr.appendChild(generateCellHTML(thisGame, x, y));
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

    countdown(thisGame, 3);
}

function generateCellHTML(thisGame, x, y) {
    var cell = document.createElement("td");
    cell.className = "cell x" + x + " y" + y;
    cell.id = "x" + x + "y" + y;
    if (thisGame.map[y][x].top) cell.classList.add("border-top");
    if (thisGame.map[y][x].down) cell.classList.add("border-down");
    if (thisGame.map[y][x].left) cell.classList.add("border-left");
    if (thisGame.map[y][x].right) cell.classList.add("border-right");
    cell.innerHTML = thisGame.map[y][x].content;
    cell.onclick = function() {
        navigateMaze(thisGame, x, y);
    }
    return cell;
}

// Fix to allow keyboard moves with arrow keys
document.onkeydown = checkKey;

function checkKey(e) {
    e = e || window.event;
    // Find player current position cause we don't have thisGame object on keypress
    var id = "";
    for (var i = 0; i < document.getElementsByClassName("cell").length; i++) {
        if (document.getElementsByClassName("cell")[i].innerHTML == playerMarker) {
            id = document.getElementsByClassName("cell")[i].id; // x0y0
            break;
        }
    }
    // Somehow the player icon was not found, return
    if (id == "") return;

    if (e.keyCode == '38') {
        // up arrow
        var newCoord = Number(id.substr(3, 1)) - 1;
        if (newCoord >= 0) {
            var newId = id.substr(0, 3) + newCoord;
            document.getElementById(newId).click();
        }
    } else if (e.keyCode == '40') {
        // down arrow
        var newCoord = Number(id.substr(3, 1)) + 1;
        if (newCoord < document.getElementsByClassName("horiz-wrapper").length) {
            var newId = id.substr(0, 3) + newCoord;
            document.getElementById(newId).click();
        }
    } else if (e.keyCode == '37') {
        // left arrow
        var newCoord = Number(id.substr(1, 1)) - 1;
        if (newCoord >= 0) {
            var newId = "x" + newCoord + id.substr(2, 2);
            document.getElementById(newId).click();
        }
    } else if (e.keyCode == '39') {
        // right arrow
        var newCoord = Number(id.substr(1, 1)) + 1;
        if (newCoord < document.getElementsByClassName("horiz-wrapper")[0].getElementsByClassName("cell").length) {
            var newId = "x" + newCoord + id.substr(2, 2);
            document.getElementById(newId).click();
        }
    }
}

function navigateMaze(thisGame, newX, newY) {
    // Invalidate the move if countdown has not yet finished
    if (document.getElementsByClassName("countdown")[0].style.display !== "none") return;

    // TODO: Record invalid moves. 
    // Event triggered onclick for each maze cell
    // We're going to set it so any cell to the right of the current one will move the player to the right, regardless of whether it's the immediate right or has some other cells in between. 

    var currentCell = thisGame.currentCell;
    var newCell = thisGame.map[newY][newX];

    // Also save the "actual" new cell in a variable (adjusted to single move, so if the player taps on a cell in the general direction of the current cell, we assume they want to move one space in that direction).
    var relationalNewCell = "";
    // Adjust for diagonals first
    if (newY > currentCell.y && newX > currentCell.x) { // Move SE
        relationalNewCell = thisGame.map[currentCell.y + 1][currentCell.x + 1];
    } else if (newY < currentCell.y && newX > currentCell.x) { // Move NE
        relationalNewCell = thisGame.map[currentCell.y - 1][currentCell.x + 1];
    } else if (newY > currentCell.y && newX < currentCell.x) { // Move SW
        relationalNewCell = thisGame.map[currentCell.y + 1][currentCell.x - 1];
    } else if (newY < currentCell.y && newX < currentCell.x) { // Move NW
        relationalNewCell = thisGame.map[currentCell.y - 1][currentCell.x - 1];
    } else if (newY > currentCell.y) { // Move down
        relationalNewCell = thisGame.map[currentCell.y + 1][currentCell.x];
    } else if (newY < currentCell.y) { // Move up
        relationalNewCell = thisGame.map[currentCell.y - 1][currentCell.x];
    } else if (newX > currentCell.x) { // Move right
        relationalNewCell = thisGame.map[currentCell.y][currentCell.x + 1];
    } else if (newX < currentCell.x) { // Move left
        relationalNewCell = thisGame.map[currentCell.y][currentCell.x - 1];
    }

    // We ignore diagonal taps because you can't move diagonally, that's cheating!
    // *** Still not sure if we should use relationalNewCell or raw newCell coordinates here. Will check and adjust if needed. ***
    if (newY !== currentCell.y && newX !== currentCell.x) {
        // Should we flash the cell red here also? 
        flashCell(relationalNewCell);
        console.log("Sorry, no diagonal moves");
        return;
    }

    // Check if wall exists on both ends. If not, mark the new cell as visited and set it as current.
    if (newY > currentCell.y) { // Move down
        if (currentCell.down || newCell.top) {
            hitWall(thisGame, relationalNewCell);
            return;
        } else {
            movePlayer(thisGame, relationalNewCell);
        }
    } else if (newY < currentCell.y) { // Move up
        if (currentCell.top || newCell.down) {
            hitWall(thisGame, relationalNewCell);
            return;
        } else {
            movePlayer(thisGame, relationalNewCell);
        }
    } else if (newX > currentCell.x) { // Move right
        if (currentCell.right || newCell.left) {
            hitWall(thisGame, relationalNewCell);
            return;
        } else {
            movePlayer(thisGame, relationalNewCell);
        }
    } else if (newX < currentCell.x) { // Move left
        if (currentCell.left || newCell.right) {
            hitWall(thisGame, relationalNewCell);
            return;
        } else {
            movePlayer(thisGame, relationalNewCell);
        }
    }
}

function hitWall(thisGame, cell) {
    // Flash cell (wall?) red
    flashCell(cell);
    // console.log("Ouch, you hit a wall!");

    // Add to obstacle count
    thisGame.obstaclesHit += 1;
    document.getElementsByClassName("obstacleCount")[0].innerHTML = thisGame.obstaclesHit;

    // Note I am NOT counting diagonals as mistakes because the player might not know that diagonal moves are invalid
}

function flashCell(cell) {
    var cellElem = document.getElementById("x" + cell.x + "y" + cell.y);
    if (cellElem.style.backgroundColor == "rgba(255, 0, 0, 0.8)") {
        cellElem.style.backgroundColor = cellElem.classList.contains("visited") ? "" : "#333333";
    } else {
        cellElem.style.backgroundColor = "rgba(255, 0, 0, 0.8)";
        setTimeout(flashCell, 500, cell);
    }
}

function visualSetVisited(cell) {
    console.log("Marking " + cell.x + "," + cell.y + " as visited.");
    cell.setVisited();
    document.getElementById("x" + cell.x + "y" + cell.y).classList.add("visited");
    document.getElementById("x" + cell.x + "y" + cell.y).style.background = "";
    document.getElementById("x" + cell.x + "y" + cell.y).style.border = "";
}

function movePlayer(thisGame, newCell) {
    // Function to move the visible player to the new cell.
    // Check if it is the finish cell
    if (newCell.x == thisGame.rows - 1 && newCell.y == thisGame.cols - 1) {
        console.log("Hooray, you finished the maze!");
        launchPuzzle(thisGame);
        return;
    }
    // Remove player marker from current cell
    thisGame.currentCell.setContent("");
    document.getElementById("x" + thisGame.currentCell.x + "y" + thisGame.currentCell.y).innerHTML = "";
    // Set player marker on the new cell
    newCell.setContent(playerMarker);
    thisGame.currentCell = newCell;
    document.getElementById("x" + thisGame.currentCell.x + "y" + thisGame.currentCell.y).innerHTML = playerMarker;
    // Call visualSetVisited()
    visualSetVisited(newCell);
}

function countdown(thisGame, seconds) {
    // Black out the maze grid after specified number of seconds.     
    // Get vars
    var countdownDisplay = document.getElementsByClassName("countdown")[0];
    var count = setInterval(function() {
        countdownDisplay.innerHTML = seconds;
        if (--seconds == -1) {
            clearInterval(count);
            maskMaze(thisGame);
            setTimer(thisGame);
        }
    }, 1000);
}

function maskMaze(thisGame) {
    console.log("The game is masked!");
    document.getElementsByClassName("timer")[0].style.display = "";
    document.getElementsByClassName("countdown")[0].style.display = "none";

    for (var i = 0; i < thisGame.rows; i++) {
        for (var j = 0; j < thisGame.cols; j++) {
            document.getElementById("x" + j + "y" + i).style.backgroundColor = "#333333";
            document.getElementById("x" + j + "y" + i).style.border = "2px solid #aaaaaa";
        }
    }
    document.getElementById("x0y0").style.backgroundColor = "";
    document.getElementById("x0y0").style.border = "";
    document.getElementById("x" + (thisGame.cols - 1) + "y" + (thisGame.rows - 1)).style.color = "#cccccc";
}

function setTimer(thisGame) {
    var timer = document.getElementsByClassName("timer")[0];
    var beginTime = new Date().getTime();
    setInterval(function() {
        var now = new Date().getTime();
        var newTime = now - beginTime;
        thisGame.timeTaken = newTime;
        timer.innerHTML = Math.floor(newTime / 1000);
    }, 100);
}

function launchPuzzle(thisGame) {
    // Player has reached the end of the maze, generate fruit puzzle
    var choices = randFruits(thisGame);
    var answers = randFruitAnswers(thisGame, choices);
    var fruitChoicesHTML = "";
    var fruitAnswersHTML = "";
    console.log(choices);
    console.log(answers);

    for (var i = 0; i < thisGame.puzzleIcons; i++) {
        fruitAnswersHTML += '<div class="fruit" id="' + answers[i]["name"] + '"><img src="' + answers[i]["image"] + '"/></div>';
    }
    for (var i = 0; i < thisGame.puzzleChoices; i++) {
        fruitChoicesHTML += '<div class="fruit" id="' + choices[i]["name"] + '"><img src="' + choices[i]["image"] + '"/></div>';
    }

    // Write to game div
    var gameDiv = document.getElementById("game-container");
    var showAnswer = '<div class="puzzle">' +
        'Memorise these icons!<br/>' +
        fruitAnswersHTML +
        '</div>';
    var puzzle = '<div class="puzzle">' +
        'Select the correct icons in order<br/>' +
        fruitChoicesHTML +
        '</div>';
    gameDiv.innerHTML = showAnswer;
    setTimeout(function() { gameDiv.innerHTML = puzzle; }, (2000 * thisGame.puzzleIcons));

    // Create onclicks
    const f = document.getElementsByClassName("fruit")[0];
    f.addEventListener('click', function(event) {
        console.log(`You selected ` + this.id);
    });

}

function randFruits(thisGame) {
    // Select the choices
    var puzzleChoices = [];
    for (var i = 0; i < thisGame.puzzleChoices; i++) {
        var rand = Math.floor(Math.random() * fruits.length);
        puzzleChoices.push(fruits.pop(rand));
        console.log(puzzleChoices);
    }
    return puzzleChoices;
}

function randFruitAnswers(thisGame, choices) {
    // Select the answers
    var puzzleAnswers = [];
    for (var i = 0; i < thisGame.puzzleIcons; i++) {
        var rand = Math.floor(Math.random() * choices.length);
        puzzleAnswers.push(choices[rand]);
        console.log(puzzleAnswers);
    }
    return puzzleAnswers;
}