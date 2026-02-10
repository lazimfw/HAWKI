<?php $__env->startSection('content'); ?>



<div class="wrapper">

    <div class="container">

        <div class="slide" data-index="1">
            <h3><?php echo e($translation["HS_EnterPasskeyMsg"]); ?></h3>

            <form id="passkey-form"  autocomplete="off">

                <div class="password-input-wrapper">
                    <input
                        class="passkey-input"
                        placeholder="<?php echo e($translation['Reg_SL5_PH1']); ?>"
                        id="passkey-input"
                        type="text"
                        autocomplete="new-password"
                        autocorrect="off"
                        autocapitalize="off"
                        spellcheck="false"
                    />
                    <div class="btn-xs" id="visibility-toggle">
                        <?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'eye'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'eye']); ?>
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
                        <?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'eye-off'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Icon::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'eye-off','style' => 'display: none']); ?>
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
            </form>

            <div class="nav-buttons">
                <button id="verifyEnteredPassKey-btn" onclick="verifyEnteredPassKey(this)" class="btn-lg-fill align-end"><?php echo e($translation["Continue"]); ?></button>
            </div>
            <p class="red-text" id="alert-message"></p>
            <button onclick="switchSlide(2)" class="btn-md"><?php echo e($translation["HS_ForgottenPasskey"]); ?></button>

        </div>


        <div class="slide" data-index="2">
            <h3><?php echo e($translation["HS_EnterBackupMsg"]); ?></h3>

            <div class="backup-hash-row">
                <input id="backup-hash-input" type="text">
                <button class="btn-sm border" onclick="uploadTextFile()">
                    <?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'upload'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
            </div>

            <div class="nav-buttons">
                <button onclick="extractPasskey()" class="btn-lg-fill align-end"><?php echo e($translation["Continue"]); ?></button>
            </div>

            <p class="red-text" id="backup-alert-message"></p>
            <button onclick="switchSlide(3)" class="btn-md"><?php echo e($translation["HS_ForgottenBackup"]); ?></button>

        </div>

        <div class="slide" data-index="3">
            <h2><?php echo e($translation["HS_LostBothT"]); ?></h2>
            <h3><?php echo e($translation["HS_LostBothB"]); ?></h3>
            <div class="nav-buttons">
                <button onclick="requestProfileReset()" class="btn-lg-fill align-end"><?php echo e($translation["HS_ResetProfile"]); ?></button>
            </div>
        </div>


        <div class="slide" data-index="4">
            <h2><?php echo e($translation["HS_PasskeyIs"]); ?></h2>
            <h3 id="passkey-field" class="demo-hash"></h3>
            <div class="nav-buttons">
                <button onclick="redirectToChat()" class="btn-lg-fill align-end"><?php echo e($translation["Continue"]); ?></button>
            </div>
        </div>




    </div>
</div>

<div class="slide-back-btn" onclick="switchBackSlide()">
    <?php if (isset($component)) { $__componentOriginal606b6d7eddc2e418f11096356be15e19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal606b6d7eddc2e418f11096356be15e19 = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Icon::resolve(['name' => 'chevron-left'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

<script>
    let userInfo = <?php echo json_encode($userInfo, 15, 512) ?>;
    const serverKeychainCryptoData = <?php echo json_encode($keychainData, 15, 512) ?>

    window.addEventListener('DOMContentLoaded', async function (){

        if(await getPassKey()){
            console.log('keychain synced');
            await syncKeychain(serverKeychainCryptoData);
            window.location.href = '/chat';
        }
        else{
            console.log('opening passkey panel');
            switchSlide(1)
            setTimeout(() => {
                if(<?php echo json_encode($activeOverlay, 15, 512) ?>){
                    setOverlay(false, true)
                }
            }, 100);
        }
    });


    document.addEventListener('DOMContentLoaded', function () {
        const inputWrappers = document.querySelectorAll('.password-input-wrapper');

        inputWrappers.forEach(wrapper => {
            const input = wrapper.querySelector('.passkey-input');
            const toggleBtn = wrapper.querySelector('.btn-xs');
            input.dataset.visible = 'false'

            // Initialize the real value in a dataset
            input.dataset.realValue = '';

            //random name will prevent chrome from auto filling.
            const rand = generateTempHash();
            input.setAttribute('name', rand);

            // Handle Enter key
            input.addEventListener('keypress', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    verifyEnteredPassKey(document.querySelector('#verifyEnteredPassKey-btn'));
                }
            });

            // Mask input and store real value
            input.addEventListener('input', function (e) {
                const realValue = input.dataset.realValue || '';
                const newValue = e.target.value;
                const oldLength = realValue.length;
                const newLength = newValue.length;

                let updated = realValue;
                if (newLength > oldLength) {
                    updated += newValue.slice(oldLength);
                } else if (newLength < oldLength) {
                    updated = updated.slice(0, newLength);
                }

                input.dataset.realValue = updated;

                if(input.dataset.visible === 'false'){
                    input.value = '*'.repeat(updated.length);
                }

            });

            // Prevent copy/cut/paste
            ['copy', 'cut', 'paste'].forEach(evt =>
                input.addEventListener(evt, e => e.preventDefault())
            );

            // Toggle visibility
            toggleBtn.addEventListener('click', function () {
                const real = input.dataset.realValue || '';
                const icons = toggleBtn.querySelectorAll('svg');
                const eye = icons[0];
                const eyeOff = icons[1];

                const isVisible = input.dataset.visible === 'true';
                if (!isVisible) {
                    input.value = real;
                    eye.style.display = 'none';
                    eyeOff.style.display = 'inline-block';
                    input.dataset.visible = 'true';
                }
                else {
                    input.value = '*'.repeat(real.length);
                    eye.style.display = 'inline-block';
                    eyeOff.style.display = 'none';
                    input.dataset.visible = 'false';
                }
            });
        });
    });




</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.gateway', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/partials/gateway/handshake.blade.php ENDPATH**/ ?>