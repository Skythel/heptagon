class game {
    constructor(cols, rows, puzzleIcons, puzzleChoices) {
        this.cols = cols;
        this.rows = rows;
        this.puzzleIcons = puzzleIcons;
        this.puzzleChoices = puzzleChoices;
        this.map = setPath(cols, rows);
        this.currentCell = this.map[0][0];
        this.obstaclesHit = 0;
        this.timeTaken = 0;
        this.score = 0;
    }
}