<!DOCTYPE html>
<html class="lightMode">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">


    <title><?php echo e(env('APP_NAME')); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/handshake_style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/settings_style.css')); ?>">

    <script src="<?php echo e(asset('js/functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/handshake_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/encryption.js')); ?>"></script>
    <script src="<?php echo e(asset('js/settings_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/announcements.js')); ?>"></script>
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

	<?php echo $settingsPanel; ?>


    <script>
		SwitchDarkMode(false);
		UpdateSettingsLanguage('<?php echo e(Session::get("language")['id']); ?>');
	</script>

</head>
<body>
    <?php echo $__env->make('partials.overlay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/gateway.blade.php ENDPATH**/ ?>