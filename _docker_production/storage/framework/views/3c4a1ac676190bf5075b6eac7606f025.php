
<!DOCTYPE html>
<html class="lightMode">
<head>


	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">


	<title><?php echo e(env('APP_NAME')); ?></title>

	<link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>">


    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/home-style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/settings_style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/hljs_custom.css')); ?>">

    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <script src="<?php echo e(asset('js/functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/home_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/stream_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/ai_chat_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/chatlog_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/inputfield_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/message_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/groupchat_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/syntax_modifier.js')); ?>"></script>
    <script src="<?php echo e(asset('js/settings_functions.js')); ?>"></script>
    <script src="<?php echo e(asset('js/encryption.js')); ?>"></script>
    <script src="<?php echo e(asset('js/image-selector.js')); ?>"></script>
    <script src="<?php echo e(asset('js/export.js')); ?>"></script>
    <script src="<?php echo e(asset('js/user_profile.js')); ?>"></script>
    <script src="<?php echo e(asset('js/file_manager.js')); ?>"></script>
    <script src="<?php echo e(asset('js/attachment_handler.js')); ?>"></script>
    <script src="<?php echo e(asset('js/model_list_filtering.js')); ?>"></script>
    <script src="<?php echo e(asset('js/announcements.js')); ?>"></script>

	<?php if(config('sanctum.allow_external_communication')): ?>
        <script src="<?php echo e(asset('js/sanctum_functions.js')); ?>"></script>
    <?php endif; ?>


	<?php echo $settingsPanel; ?>

    <script>
		SwitchDarkMode(false);
		UpdateSettingsLanguage('<?php echo e(Session::get("language")['id']); ?>');
	</script>

</head>
<body>


	<div class="wrapper">

		<?php echo $__env->make('partials.home.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<div class="main">
			<?php echo $__env->yieldContent('content'); ?>
		</div>
	</div>

	<?php echo $__env->make('partials.home.modals.guidelines-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo $__env->make('partials.home.modals.add-member-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo $__env->make('partials.home.modals.session-expiry-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo $__env->make('partials.home.modals.file-viewer-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
	<?php echo $__env->make('partials.home.modals.announcements-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

	<?php echo $__env->make('partials.overlay', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php
        $templates = collect(File::files(resource_path('views/partials/home/templates')))
            ->sortBy(fn($file) => $file->getFilename())
            ->values();
    ?>
    <?php $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $temp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('partials.home.templates.' . $viewName = str_replace('.blade', '',  $temp->getFilenameWithoutExtension()), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('partials.home.modals.confirm-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

</body>
</html>

<script>

	const userInfo = <?php echo json_encode($user, 15, 512) ?>;
	const userAvatarUrl = <?php echo json_encode($userData['avatar_url'], 15, 512) ?>;
	const hawkiAvatarUrl = <?php echo json_encode($userData['hawki_avatar_url'], 15, 512) ?>;
	const activeModule = <?php echo json_encode($activeModule, 15, 512) ?>;
    const hawkiUsername = <?php echo json_encode($userData['hawki_username'], 15, 512) ?>

    const activeLocale = <?php echo json_encode(Session::get('language')); ?>;
	const translation = <?php echo json_encode($translation, 15, 512) ?>;

	const modelsList = <?php echo json_encode($models, 15, 512) ?>.models;
	const defaultModels = <?php echo json_encode($models, 15, 512) ?>.defaultModels;
	const systemModels = <?php echo json_encode($models, 15, 512) ?>.systemModels;

	const aiHandle = "<?php echo e(config('hawki.aiHandle')); ?>";

    const announcementList = <?php echo json_encode($announcements, 15, 512) ?>;

    const converterActive = <?php echo json_encode($converterActive, 15, 512) ?>;


    window.addEventListener('DOMContentLoaded', async (event) => {
        setModel();

		const passkey = await getPassKey()
		if(!passkey){
			console.log('passkey not found!');
			window.location.href = '/handshake';
		}

		setSessionCheckerTimer(0);
		CheckModals()

		const tempLink = <?php echo json_encode(session('invitation_tempLink'), 15, 512) ?>;
	    if (tempLink){
			await handleTempLinkInvitation(tempLink);
		}

		handleUserInvitations();


		//Module Checkup
		setActiveSidebarButton(activeModule);

		const sidebarBtn = document.getElementById('profile-sb-btn');
		if(userAvatarUrl){
			sidebarBtn.querySelector('.user-inits').style.display = 'none';
			sidebarBtn.querySelector('.icon-img').style.display = 'flex';
			sidebarBtn.querySelector('.icon-img').setAttribute('src', userAvatarUrl);
		}
		else{
			sidebarBtn.querySelector('.icon-img').style.display = 'none';
			const userInitials =  userInfo.name.slice(0, 1).toUpperCase();
			sidebarBtn.querySelector('.user-inits').style.display = "flex";
			sidebarBtn.querySelector('.user-inits').innerText = userInitials
		}


		initializeGUI();
		checkWindowSize(800, 200);

        initAnnouncements(announcementList);


		setTimeout(() => {
			if(<?php echo json_encode($activeOverlay, 15, 512) ?>){
				setOverlay(false, true)
			}
		}, 100);
    });


</script>
<?php /**PATH /var/www/html/resources/views/layouts/home.blade.php ENDPATH**/ ?>