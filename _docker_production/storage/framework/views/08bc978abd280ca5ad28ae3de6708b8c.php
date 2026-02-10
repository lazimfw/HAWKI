<template id="message-template">
	<div class="message" id="">
		<div class="message-wrapper">
			<div class="message-header">
				<div class="message-icon round-icon">
					<span class="user-inits"></span>
					<img class="icon-img"   alt="">
				</div>
				<div class="dot"></div>
				<div class="message-author"></div>
			</div>

			<div class="attachments"></div>

			<div class="message-content">
				<span class="assistant-mention"></span>
				<span class="message-text"></span>
			</div>
			<?php echo $__env->make('partials.home.templates.message_partials.message-controls', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		</div>
	</div>
</template>
<?php /**PATH /var/www/html/resources/views/partials/home/templates/message-template.blade.php ENDPATH**/ ?>