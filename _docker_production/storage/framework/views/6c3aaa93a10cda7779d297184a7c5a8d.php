
<div id="overlay"

<?php if($activeOverlay): ?>
    style =" visibility: visible; opacity: 1;"
<?php else: ?>
    style ="visibility: hidden; opacity: 0;"
<?php endif; ?>
>
    <div id="overlay-wrapper">
        <div id="overlay-logo">
            <img src="<?php echo e(asset('img/logo.png')); ?>" alt="">
        </div>  
    </div>
</div>

<?php /**PATH /var/www/html/resources/views/partials/overlay.blade.php ENDPATH**/ ?>