<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/admin_user/add']); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="email"><span class="required">*</span> <?php echo trans('backend::admin_user.email'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('email'); ?>
                <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="password"><span class="required">*</span> <?php echo trans('backend::admin_user.password'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('password'); ?>
                <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="retype_password"><span class="required">*</span> <?php echo trans('backend::admin_user.retype_password'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('retype_password'); ?>
                <span class="alert-danger"><?php echo $errors->first('retype_password', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="role_id"><span class="required">*</span> <?php echo trans('backend::admin_user.role'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('role_id', $roleList, null); ?>
                <span class="alert-danger"><?php echo $errors->first('role_id', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><span class="required">*</span> <?php echo trans('backend::admin_user.name'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('name'); ?>
                <span class="alert-danger"><?php echo $errors->first('name', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><span class="required">*</span> <?php echo trans('backend::admin_user.status'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('status', $statusList, 0); ?>
                <span class="alert-danger"><?php echo $errors->first('status', ':message'); ?></span>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::bsSubmit(trans('backend::global.submit')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/admin_user/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>