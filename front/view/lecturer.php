<?php
    require __DIR__ . "/includes/header.php";
?>
<!-- page wrapper -->
<div class="dev-page" ng-controller="lecturerController">
    
    <!-- page header -->    
    <?php
        include __DIR__."/includes/pages/page-header.php";
    ?>
    <!-- ./page header -->
    
    <!-- page container -->
    <div class="dev-page-container">

        <!-- page sidebar -->
        <?php
            include __DIR__."/includes/pages/page-sidebar.php";
        ?>
        <!-- ./page sidebar -->
        
        <!-- page content -->
        <div class="dev-page-content">                    
            <!-- page content container -->
            <?php
                include __DIR__."/includes/pages/page-content.php";
            ?>
            <!-- ./page content container -->
                                
        </div>
        <!-- ./page content -->                                               
    </div>  
    <!-- ./page container -->                                                
    
    <!-- page footer -->    
    <?php
        include __DIR__."/includes/pages/page-footer.php";
    ?> 
    <!-- ./page footer --> 
</div>
<!-- ./page wrapper -->
<?php
    require __DIR__ . "/includes/footer.php";
?>