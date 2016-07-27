<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="email"><?php echo trans('backend::admin_user.email'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->email; ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="role"><?php echo trans('backend::admin_user.role'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->role()->first()->name); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><?php echo trans('backend::admin_user.name'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->name); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><?php echo trans('backend::post.status'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/admin_user/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>