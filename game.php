<!-- File for the game container and everything within. -->
<div class="game">
    Select Difficulty:<br/>
    <div class="button difficulty" onclick="setDifficulty('easy')" id="sel-easy">Easy</div>
    <div class="button difficulty" onclick="setDifficulty('med')" id="sel-med"> Medium</div>
    <div class="button difficulty" onclick="setDifficulty('hard')" id="sel-hard">Hard</div>
</div>
<!-- Include game logic -->
<script src="logic.js?v=<?php echo $app_ver; ?>"></script>