<?php $__env->startSection('content'); ?>
    @parent

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend::shop.layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>