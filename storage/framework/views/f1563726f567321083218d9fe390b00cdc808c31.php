<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><?php echo trans('backend::term.name'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->name); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug"><?php echo trans('backend::term.slug'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->slug); ?></p>
                <div style="display: none"><?php echo $model->full_url; ?></div>
                <div style="display: none"><?php echo url('/') . '/' . $model->lang . $model->url; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="thumb_url"><?php echo trans('backend::term.icon'); ?></label>
            <div class="col-sm-10">
                <?php if ($model->thumb_url) : ?>
                    <img src="<?php echo $model->thumb_url; ?>" style="width: 90px; height: 90px" />
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="weight"><?php echo trans('backend::term.weight'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->weight); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><?php echo trans('backend::term.status'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/term/list/' . $taxonomyId . '/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>