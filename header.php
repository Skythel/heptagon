<?php include 'config.php'; ?>
<!doctype html>
<head> 
    <title><?php if(isset($cfg_title)) { echo $cfg_title } else { ?>Heptagon<?php } ?></title>
    <link rel="stylesheet" href="./style.css?v=<?php echo $assets_ver; ?>" type="text/css" />
    <link href="./css/all.css" rel="stylesheet"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <!-- Load standard dashboard module from file -->
    <?php include 'navbar.php'; ?>
    <!-- The wrapper div for all body content. -->
    <div class="wrapper"> 