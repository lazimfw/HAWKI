<div class="burger-dropdown" id="quick-actions">
	<div class="burger-expandable">

		<?php if($activeModule === 'groupchat'): ?>
			<button class="burger-item" onclick="closeBurgerMenus(); openRoomCP()"><?php echo e($translation["Info"]); ?></button>
			<button class="burger-item" id="mark-as-read-btn" onclick="markAllAsRead()" disabled><?php echo e($translation["MarkAllRead"]); ?></button>
		<?php endif; ?>

			
			

		<?php if($activeModule === 'chat'): ?>
			<button class="burger-item red-text" onclick="requestDeleteConv()"><?php echo e($translation["DeleteChat"]); ?></button>
		<?php elseif($activeModule === 'groupchat'): ?>
			<button class="burger-item red-text" onclick="leaveRoom()"><?php echo e($translation["LeaveRoom"]); ?></button>
		<?php endif; ?>
	</div>
</div>
<?php /**PATH /var/www/html/resources/views/partials/home/templates/burger-dropdown-template.blade.php ENDPATH**/ ?>