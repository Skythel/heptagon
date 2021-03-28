<?php include 'config.php'; ?>
<!doctype html>
<html>
<head> 
    <title>
        <?php if(isset($cfg_title)) { 
            echo $cfg_title; 
        } else { 
            echo "MemoryMaze";
        } ?>
    </title>
    <link rel="stylesheet" href="./style.css?v=<?php echo $assets_ver; ?>" type="text/css">
    <link rel="stylesheet" href="./scoretable.css?v=<?php echo $assets_ver; ?>" type="text/css">
    <link rel="stylesheet" href="./sidebar.css?v=<?php echo $assets_ver; ?>" type="text/css">
    <link rel="stylesheet" href="./mobile.css?v=<?php echo $assets_ver; ?>" type="text/css">
    <link href="./css/all.css" rel="stylesheet"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if($cfg_title == "Home - MemoryMaze" || $cfg_title == "Leaderboard - MemoryMaze") { ?>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
        </style>
    <?php } ?>
</head>
<body>
    <!-- Load standard dashboard module from file -->
    <?php include 'navbar.php'; ?>
    <!-- The wrapper div for all body content. -->
    <div class="wrapper"> 