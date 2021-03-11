class game {
    constructor(cols, rows, puzzleIcons, puzzleChoices) {
        this.cols = cols;
        this.rows = rows;
        this.puzzleIcons = puzzleIcons;
        this.puzzleChoices = puzzleChoices;
        this.map = setPath(cols,rows);
        // this.maze = new maze();
    }
    setObstacles() { // Sets obstacles for the maze. 
    }

}
