<div class="dev-page-login-block__form" data-ng-controller="loginController">
    <div class="title alert" data-ng-bind="information" style="text-align='center'"><center><?= Res::LOGIN_WELCOME_TEXT; ?></center></div>
    <form role = "form">                        
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input 
                    type="text" 
                    class="form-control" 
                    placeholder="<?= Res::LOGIN_PLACEHOLDER_USERNAME; ?>" 
                    data-ng-model="username"
                    name="username"
                    required>
            </div>
        </div>                        
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input 
                    type="password" 
                    class="form-control" 
                    placeholder="<?= Res::LOGIN_PLACEHOLDER_PASSWORD; ?>" 
                    data-ng-model="password"
                    required
                    minLength="2"
                    maxLength="30">
            </div>
        </div>
        <div class="form-group no-border margin-top-20">
            <button class="btn btn-success btn-block" data-ng-click="processLogin();"><?= Res::LOGIN_LOGIN_BUTTON; ?></button>
        </div>
        <p><a href="#"><?= Res::LOGIN_FORGET_PASSWORD_TEXT; ?></a></p>                        
    </form>
</div>