<div class="model-selection-panel">
    <?php $__currentLoopData = $models['models']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $model): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button class="model-selector burger-item"
                onclick="selectModel(this); closeBurgerMenus()"
                data-model-id="<?php echo e($model['id']); ?>"
                value="<?php echo e(json_encode($model)); ?>"
                data-status="<?php echo e($model['status']); ?>"
                <?php if($model['status'] === 'offline'): ?>
                    disabled
                <?php endif; ?>>

                <?php switch($model['status']):
                    case ('online'): ?>
                        <span class="dot grn-c"></span>
                        <?php break; ?>
                    <?php case ('unknown'): ?>
                        <span class="dot org-c"></span>
                        <?php break; ?>
                    <?php case ('offline'): ?>
                        <span class="dot red-c"></span>
                        <?php break; ?>
                    <?php default: ?>
                        <span class="dot red-c"></span>
                <?php endswitch; ?>
            <span><?php echo e($model['label']); ?></span>

        </button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /var/www/html/resources/views/partials/home/components/models-list.blade.php ENDPATH**/ ?>