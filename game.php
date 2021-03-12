<!-- File for the game container and everything within. -->
<div class="game" id="game-container">
    Select Difficulty:<br/>
    <div class="button difficulty" onclick="setDifficulty('easy')" id="sel-easy">Easy</div> &nbsp;
    <div class="button difficulty" onclick="setDifficulty('med')" id="sel-med"> Medium</div> &nbsp;
    <div class="button difficulty" onclick="setDifficulty('hard')" id="sel-hard">Hard</div>
</div>
<!-- Include game logic -->
<script src="game.js?v=<?php echo $scripts_ver; ?>"></script>
<script src="cell.js?v=<?php echo $scripts_ver; ?>"></script> 
<script src="logic.js?v=<?php echo $scripts_ver; ?>"></script>
<script src="gameplay.js?v=<?php echo $scripts_ver; ?>"></script>
<script src="fruits.js?v=<?php echo $scripts_ver; ?>"></script>