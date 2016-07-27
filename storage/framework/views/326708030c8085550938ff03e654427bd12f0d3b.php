<?php $__env->startSection('content'); ?>
@parent


<div class="login-box">
    <div class="login-logo">
        <b>CMS Login</b>
    </div>

    <div class="login-box-body">
        <p class="login-box-msg"><?php echo trans('backend::auth.sign_to_start_session') ?></p>

        <?php echo Form::bsOpen(['url' => $data['prefix'] . '/auth/login', 'id' => 'login-form', 'class' => '']) ?>

        <?php echo Form::token() ?>

        <div class="form-group has-feedback">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group has-feedback">
            <label class="control-label" for="email"><?php echo trans('backend::auth.email') ?></label>
            <?php echo Form::bsText('email', '', ['placeholder' => trans('backend::auth.email_placeholder')]); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
        </div>

        <div class="form-group has-feedback">
            <label class="control-label" for="password"><?php echo trans('backend::auth.password') ?></label>
            <?php echo Form::bsPassword('password', ['placeholder' => trans('backend::auth.password_placeholder')]); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
        </div>

        <div class="form-group has-feedback checkbox">
            <label class="checkbox">
            <?php echo Form::checkbox('remember_me'); ?> <?php echo trans('backend::auth.remember_me') ?>
            </label>
        </div>

        <div class="row">
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo trans('backend::auth.login') ?></button>
            </div>
        </div>

        <?php echo Form::close(); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend::layouts.login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>