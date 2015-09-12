<?php

// This here blocks direct access to this file (so an attacker can't look into application/views/_templates/header.php).
// "$this" only exists if header.php is loaded from within the app, but not if THIS file here is called directly.
// If someone called header.php directly we completely stop everything via exit() and send a 403 server status code.
// Also make sure there are NO spaces etc. before "<!DOCTYPE" as this might break page rendering.
if (!$this) {
    exit(header('HTTP/1.0 403 Forbidden'));
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable = no">
<meta name="description" content="A layout example that shows off a blog page with a list of pages.">

    <title>The Daily Sky</title>
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<!--[if lte IE 8]>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-old-ie-min.css">
<![endif]-->
<!--[if gt IE 8]><!-->
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/grids-responsive-min.css">
<!--<![endif]-->

    <!--[if lte IE 8]>
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/layouts/layout-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]><!-->
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/layouts/layout.css">
    <!--<![endif]-->
   <link rel="stylesheet" href="<?php echo URL; ?>public/css/c3.css">
   <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
<?php 
if ($this->model->checkTable()){
$today = $this->model->getCurrentDay();
if($today['AvT']<50){
    echo "<style>
    .sidebar{background-color:#3498db;}
    .brand-tagline{color:#ecf0f1;}
    .nav-item a{border-color:#ecf0f1;}
    </style>";
} else if ($today['AvT']>80){
    echo "<style>
    .sidebar{background-color:#f1c40f;} 
    .brand-tagline{color:#f39c12;} 
    .nav-item a{border-color:#f39c12;}
    </style>";
}
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>
<script src="<?php echo URL; ?>public/js/c3.js"></script>
</head>
<body>

<div id="layout" class="pure-g">
    <div class="sidebar pure-u-1 pure-u-md-1-4">
        <div class="header">
            <div class="brand-title"><a href="<?= URL_WITH_INDEX_FILE ?>"><img src="<?php echo URL; ?>public/img/logo.png" alt="The Daily Sky"></a></div>
            <h2 class="brand-tagline">A Daily Forecast App By <span class="italic">YOU!</span></h2>

            <nav class="nav">
                <ul class="nav-list"><?php if($this->model->checkTable()){echo "
                    <li class=\"nav-item\">
                        <a class=\"pure-button\" href=\"". URL_WITH_INDEX_FILE ."list/\">List</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"pure-button\" href=\"". URL_WITH_INDEX_FILE ."report/\">Report</a>
                    </li>";
}
?>
                    
                    <li class="nav-item">
                        <a class="pure-button" href="<?= URL_WITH_INDEX_FILE ?>upload/">Upload</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="content pure-u-1 pure-u-md-3-4">
        <div>
            <!-- A wrapper for all the content -->
            <div class="page">
