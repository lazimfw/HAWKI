<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(env('APP_NAME')); ?></title>

    <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/login_style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/settings_style.css')); ?>">

    <script src="<?php echo e(asset('js/functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/settings_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/announcements.js')); ?>"></script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    <?php echo $settingsPanel; ?>


    <script>
		InitializePreDomSettings(false);
        UpdateSettingsLanguage('<?php echo e(Session::get("language")['id']); ?>');
	</script>

</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <div class="logo"></div>

        <div class="loginPanel">
			<?php echo $authForms; ?>

        </div>


        <div class="footerPanel">

            <button class="btn-sm" onclick="toggleSettingsPanel(true)">
                <?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'settings-icon'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal606b6d7eddc2e418f11096356be15e19)): ?>
<?php $attributes = $__attributesOriginal606b6d7eddc2e418f11096356be15e19; ?>
<?php unset($__attributesOriginal606b6d7eddc2e418f11096356be15e19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal606b6d7eddc2e418f11096356be15e19)): ?>
<?php $component = $__componentOriginal606b6d7eddc2e418f11096356be15e19; ?>
<?php unset($__componentOriginal606b6d7eddc2e418f11096356be15e19); ?>
<?php endif; ?>
            </button>
            <div class="impressumPanel">
                <a href="/dataprotection" target="_blank"><?php echo e($translation["DataProtection"]); ?></a>
                <a href="<?php echo e(env("IMPRINT_LOCATION")); ?>" target="_blank"><?php echo e($translation["Impressum"]); ?></a>
            </div>
        </div>

    </div>

    <main>
        <div class="backgroundImageContainer">
            <video class="image_preview_container" src="" type="video/m4v" preload="none" autoplay loop muted></video>
            <a href="" target="_blank" class="video-credits"></a>
        </div>
    </main>
</div>

<?php echo $__env->make('partials.overlay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        if(window.innerWidth < 480){
            const bgVideo = document.querySelector(".image_preview_container");
            bgVideo.remove();
        }

        setTimeout(() => {
            if(<?php echo json_encode($activeOverlay, 15, 512) ?>){
                // console.log('close overlay');
                setOverlay(false, true)
            }
        }, 100);
    });

    function onLoginKeydown(event){
        if(event.key === "Enter"){
            const username = document.getElementById('account');
            // console.log(username.value);
            if(!username.value){
                return;
            }
            const password = document.getElementById('password');
            if(document.activeElement !== password){
                password.focus();
                return;
            }
            if(username.value && password.value){
                submitLogin();
            }
        }
    }

    async function submitLogin() {
        try {
            var formData = new FormData();
            formData.append('account', document.getElementById('account').value);
            formData.append('password', document.getElementById('password').value);
            const csrfToken = document.getElementById('hawkiLoginForm').querySelector('input[name="_token"]').value;

            const response = await fetch('/req/login', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Login request failed');
            }

            const data = await response.json();

            if (data.success) {
                await setOverlay(true, true);
                window.location.href = data.redirectUri;

            } else {
                // console.log('login failed');
                document.getElementById('login-message').textContent = 'Login Failed!';
            }
        } catch (error) {
            console.error(error);
        }
    }

    /**
     * @deprecated: use submitLogin() instead!
     */
    async function LoginLDAP() {
        await submitLogin();
    }
</script>
<?php /**PATH /var/www/html/resources/views/layouts/login.blade.php ENDPATH**/ ?>