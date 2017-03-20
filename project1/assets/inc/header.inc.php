<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="a ecommerce website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>succulent garden</title>
    <!--    css-->
    <link href="<?php echo URL_CSS . "normalize.css"?>" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,200,300,400,500,700" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!--    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-orange.min.css">-->
    <link href="<?php echo URL_CSS . "materialize.css"?>" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="<?php echo URL_CSS . "style.css" ?>" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<nav class="white" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="<?php echo URL_BASE . "index.php"?>" class="brand-logo">Home</a>
        <ul class="right hide-on-med-and-down">
            <li><a href="<?php echo URL_BASE . "templates/cart.php"?>">My Cart</a></li>
            <li><a href="<?php echo URL_BASE . "templates/admin.php"?>">Admin</a></li>
        </ul>

        <ul id="nav-mobile" class="side-nav">
            <li><a href="<?php echo URL_BASE . "templates/cart.php"?>">My Cart</a></li>
            <li><a href="<?php echo URL_BASE . "templates/admin.php"?>">Admin</a></li>
        </ul>
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
</nav>