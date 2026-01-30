<?php if($showLoginForm): ?>
    <form class="form-column" id="hawkiLoginForm">
        <?php echo csrf_field(); ?>
        <label for="account"><?php echo e($translation["username"]); ?></label>
        <input type="text" name="account" id="account" onkeypress="onLoginKeydown(event)">
        <label for="password"><?php echo e($translation["password"]); ?></label>
        <input type="password" name="password" id="password" onkeypress="onLoginKeydown(event)">
    </form>
    <div id="login-Button-panel">
        <div id="login-message"></div>
        <button id="loginButton" class="btn-lg-fill align-end top-gap-1" type="button"
                onclick="submitLogin()"><?php echo e($translation['Login']); ?></button>
    </div>
<?php else: ?>
    <form class="form-column" method="post" id="hawkiLoginForm" action="/req/login">
        <?php echo csrf_field(); ?>
        <?php if($errors->has('login_error')): ?>
            <div id="login-message">
                <?php echo e($errors->first('login_error')); ?>

            </div>
        <?php endif; ?>
        <button id="loginButton" class="btn-lg-fill align-end top-gap-1" type="submit"
                name="submit"><?php echo e($translation['Login']); ?></button>
    </form>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/partials/login/authForms.blade.php ENDPATH**/ ?>