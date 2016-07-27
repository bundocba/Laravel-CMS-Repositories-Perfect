<?php $__env->startSection('content'); ?>
    @parent

<script type="text/javascript">

    $(document).ready(function () {

        var preventBack = function () {

            history.pushState(null, null, document.title);
            window.history.forward();
            setTimeout(preventBack, 100);
        };

        setTimeout(preventBack, 100);

        $('form').submit();
    });

</script>

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/auth/logout']); ?>

    <?php echo Form::token(); ?>

    <?php //echo Form::bsSubmit(trans('backend::global.submit')); ?>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.logout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>