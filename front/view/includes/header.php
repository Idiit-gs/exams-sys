<?php require_once __DIR__."/server.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- meta section -->
        <title><?= Res::PROJECTNAME; ?> | user</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
        <meta http-equiv="X-UA-Compatible" content="IE=edge" >
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" >
        
        <link rel="icon" href="favicon.ico" type="image/x-icon" >
        <!-- /meta section -->        
        
        <!-- css styles -->
        <link rel="stylesheet" type="text/css" href="<?= BINDIRABSOLUTE."/css/lightblue-white.css"; ?>" id="dev-css">
        <!-- ./css styles -->                                    
                
        <!--[if lte IE 9]>
        <link rel="stylesheet" type="text/css" href="<?= BINDIRABSOLUTE."/css/dev-other/dev-ie-fix.css"; ?>">
        <![endif]-->
        
        <!-- javascripts -->
        <script type="text/javascript" src="<?= BINDIRABSOLUTE."/js/plugins/modernizr/modernizr.js"; ?>"></script>
        <!-- ./javascripts -->
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-rc.2/angular.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-rc.2/angular-cookies.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-rc.2/angular-animate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-rc.2/angular-route.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0-rc.2/angular-messages.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.min.js"></script>
        <style>.dev-page{visibility: hidden;}</style>
    </head>
    <body data-ng-app="Examsys" class="dev-page-boxed">
        <!-- set loading layer -->
        <div class="dev-page-loading preloader"></div>
        <!-- ./set loading layer -->     