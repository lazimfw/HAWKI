<?php $__env->startSection('content'); ?>
<div class="main-panel-grid">
	<div class="dy-sidebar expanded" id="chat-sidebar">
		<div class="dy-sidebar-wrapper">
			<!-- <div class="welcome-panel">
				<h1><?php echo e(Auth::user()->name); ?></h1>
			</div> -->
			<div class="header">
				<button class="btn-md-stroke" onclick="startNewChat()">
					<div class="icon">
						<?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'plus'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
					</div>
					<div class="label"><strong><?php echo e($translation["StartNewChat"]); ?></strong></div>
				</button>
				<h3 class="title"><?php echo e($translation["History"]); ?></h3>

			</div>
			<div class="dy-sidebar-content-panel">
				<div class="dy-sidebar-scroll-panel">
					<div class="selection-list" id="chats-list">


					</div>
				</div>
			</div>

			<div class="dy-sidebar-expand-btn" onclick="togglePanelClass('chat-sidebar', 'expanded')">
				<?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'chevron-right'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
			</div>

		</div>
	</div>



	<div class="dy-main-panel">

		<div class="dy-main-content" id="chat">

			<div class="chat-info">
				<div class="system-prompt"></div>
			</div>


			<div class="chatlog">
				<div class="chatlog-container">

					<div class="scroll-container">
						<div class="scroll-panel">

							<div class="thread trunk" id="0">

							</div>
						</div>
					</div>

				</div>
				<h1 id="start-title"><?php echo e($translation["StartBanner"]); ?></h1>

				<?php echo $__env->make('partials.home.input-field', ['lite' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

			</div>
			<p class="warning"><?php echo e($translation["MistakeWarning"]); ?></p>

		</div>
	</div>

</div>


<script>


window.addEventListener('DOMContentLoaded', async function (){

	initializeAiChatModule(<?php echo json_encode($userData['convs'], 15, 512) ?>)

	const slug = <?php echo json_encode($slug, 15, 512) ?>;

	if (slug){
		await loadConv(null, slug);
	}
	else{
        switchDyMainContent('chat');
	}
});



</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.home', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/modules/chat.blade.php ENDPATH**/ ?>