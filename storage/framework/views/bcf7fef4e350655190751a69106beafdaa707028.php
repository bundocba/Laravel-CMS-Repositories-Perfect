<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><?php echo trans('backend::menu_link.name'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->name); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="content_name"><?php echo trans('backend::menu_link.content_type'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->content_name); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="link_to"><?php echo trans('backend::menu_link.link_to'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->full_url); ?></p>
            </div>
        </div>

        <?php
            $contentType = '';
            $contentTypeId = $model->content_type_id;
            if ($contentTypeId == 1) {
                $contentType = trans('backend::menu_link.basic_page');
            } else if ($contentTypeId == 2) {
                $contentType = trans('backend::menu_link.category');;
            } else if ($contentTypeId == 3) {
                $contentType = trans('backend::menu_link.custom_link');;
            }
        ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="content_type"><?php echo trans('backend::menu_link.content_type'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($contentType); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="link_target"><?php echo trans('backend::menu_link.link_target'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->link_target); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="weight"><?php echo trans('backend::menu_link.weight'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo e($model->weight); ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><?php echo trans('backend::menu_link.status'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/menu_link/list/' . $menuId . '/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>