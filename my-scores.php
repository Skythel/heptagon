<?php // Personal scores
$cfg_title = (isset($_SESSION["username"]) ? $_SESSION["username"]."'s " : "")."Scores - MemoryMaze";
include 'config.php';
include 'header.php';
include "sidebar.html"?>

<!--main container start-->
<div class="container-1">
    <div class="card">
        <p><br><?php include 'placeholder_myscores.html'; ?></p>
    </div>
</div>
<!--main container end-->

