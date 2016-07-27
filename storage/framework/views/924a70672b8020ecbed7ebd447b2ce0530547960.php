<?php $__env->startSection('content'); ?>
    @parent


    <div class="error-page">
        <h2 class="headline text-red">404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
            <p>
                We will work on fixing that right away.
                Meanwhile, you may <a href="<?php echo url('/') ?>">return to homepage</a> or try using the search form.
            </p>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>