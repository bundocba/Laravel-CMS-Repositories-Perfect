<?php if(Session::has('message')): ?>
<div class="alert alert-success" style="padding: 10px 10px;"><?php echo e(Session::get('message')); ?></div>
<?php endif; ?>

<?php if(Session::has('error')): ?>
<div class="alert alert-error" style="padding: 10px 10px;"><?php echo e(Session::get('error')); ?></div>
<?php endif; ?>
