<?php if ($data['lang'] == 'vi') : ?>

    <a href="<?php echo url('/vi'); ?>"><img src="<?php echo e(asset('assets/frontend/img/flags/vn-active.jpg')); ?>" /></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?php echo url('/en'); ?>"><img src="<?php echo e(asset('assets/frontend/img/flags/en-deactive.jpg')); ?>" /></a>

<?php else : ?>

    <a href="<?php echo url('/vi'); ?>"><img src="<?php echo e(asset('assets/frontend/img/flags/vn-deactive.jpg')); ?>" /></a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?php echo url('/en'); ?>"><img src="<?php echo e(asset('assets/frontend/img/flags/en-active.jpg')); ?>" /></a>

<?php endif; ?>
