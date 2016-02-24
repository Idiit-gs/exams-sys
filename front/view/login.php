<?php
	require __DIR__ . "/includes/header-login.php";
?>
<div class="dev-page dev-page-login dev-page-login-v2">

    <div class="dev-page-login-block">
        <a class="dev-page-login-block__logo"><?= Res::PROJECTNAME; ?></a>
        <?php
        	include __DIR__."/includes/login/login-form.php";
        ?>
        <div class="dev-page-login-block__footer">
            <?= Res::COPYRIGHT; ?>
        </div>
    </div>
    
</div>
<?php
	require __DIR__ . "/includes/footer-login.php";
?>



