<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div id="toolbar">

            <div class="pull-left">

                <div class="form-inline">

                    <div class="form-group">
                        <a href="<?php echo url($data['prefix'] . '/role/add'); ?>">
                            <button class="btn btn-success">
                                <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                            </button>
                        </a>
                    </div>

                </div>

            </div>

            <div class="pull-right">

            </div>

            <div class="clearfix"></div>

        </div>


        <?php if (!empty($models) && $models->total() > 0) : ?>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive-custom">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 30%"><strong><?php echo Widget::column(trans('backend::role.name'), 'name'); ?></strong></td>
                        <td align="left" style="width: 35%"><strong><?php echo Widget::column(trans('backend::role.description'), 'description'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo Widget::column(trans('backend::role.priority'), 'priority'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo Widget::column(trans('backend::role.status'), 'status'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left"><?php echo e($model->name); ?></td>
                            <td align="left"><?php echo e($model->description); ?></td>
                            <td align="center"><?php echo e($model->priority); ?></td>
                            <td align="center"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></td>
                            <td align="center">
                                <?php echo $__env->make('backend::partials.row_actions',
                                [
                                'view_url' => url($data['prefix'] . '/role/view/' . $model->id),
                                'edit_url' => url($data['prefix'] . '/role/edit/' . $model->id),
                                'delete_url' => url($data['prefix'] . '/role/delete/' . $model->id)
                                ]
                                , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </td>
                        </tr>
                        <?php $count++; ?>
                    <?php endforeach; ?>
                </table>

            </div>

            <?php echo Form::close(); ?>

            <?php echo $__env->make('backend::partials.paginator', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php else: ?>

            <div class="alert"><?php echo trans('backend::global.no_record_found'); ?></div>

        <?php endif; ?>

        <div class="clearfix"></div>

        <?php echo $__env->make('backend::partials.delete_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>