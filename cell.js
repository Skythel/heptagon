class cell {
    constructor(x, y) {
        // The 4 sides attributes indicate whether a border exists on that edge
        this.x = x;
        this.y = y;
        this.left = true;
        this.right = true;
        this.top = true;
        this.down = true;
        this.visited = false;
        this.deadend = false;
    }
}
