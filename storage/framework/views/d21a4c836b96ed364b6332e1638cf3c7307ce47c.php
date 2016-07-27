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
                        <a href="<?php echo url($data['prefix'] . '/admin_user/add'); ?>">
                            <button class="btn btn-success">
                                <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                            </button>
                        </a>
                    </div>

                    <?php echo $__env->make('backend::partials.mass_actions', [
                    'mass_activate_url' => url($data['prefix'] . '/admin_user/massactivate'),
                    'mass_deactivate_url' => url($data['prefix'] . '/admin_user/massdeactivate'),
                    'mass_delete_url' => url($data['prefix'] . '/admin_user/massdelete')
                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>

            </div>

            <div class="pull-right">

            </div>

            <div class="clearfix"></div>

        </div>

        <div id="filter-panel">

            <script type="text/javascript">

                $(document).ready(function () {

                    $('#filter-btn').click(function (event) {

                        var email = encodeURI($('#email').val());
                        var name = encodeURI($('#name').val());
                        var roleId = encodeURI($('#role_id').val());
                        var status = encodeURI($('#status').val());

                        var query = '?email=' + email + '&name=' + name + '&role_id=' + roleId + '&status=' + status;

                        document.location.href = '<?php echo url($data['prefix'] . '/admin_user/list/'); ?>' + query;

                    });

                });

            </script>

            <form id="filter-form" class="form form-inline form-multiline" method="GET" action="<?php echo url($data['prefix'] . '/admin_user/list'); ?>">

                <div class="form-inline">

                    <div class="form-group">
                        <label class="" for="email"><?php echo trans('backend::admin_user.email'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsText('email', \Request::query('email')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="" for="name"><?php echo trans('backend::admin_user.name'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsText('name', \Request::query('name')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('name', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="" for="role_id"><?php echo trans('backend::admin_user.role'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsSelect('role_id', $roleList, \Request::query('role_id')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('role_id', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="" for="status"><?php echo trans('backend::admin_user.status'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsSelect('status', $statusList, \Request::query('status')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('status', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <input type="button" id="filter-btn" class="btn btn-primary" value="<?php echo trans('backend::global.filter'); ?>" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo url($data['prefix'] . '/admin_user/list'); ?>"><input type="button" class="btn btn-default" value="<?php echo trans('backend::global.clear'); ?>" /></a>
                    </div>

                </div>

            </form>

        </div>

        <?php if (!empty($models) && $models->total() > 0) : ?>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive-custom">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%">
                            <input type="checkbox" id="check_all" name="check_all" />
                        </td>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 20%"><strong><?php echo Widget::column(trans('backend::admin_user.email'), 'email'); ?></strong></td>
                        <td align="left" style="width: 30%"><strong><?php echo Widget::column(trans('backend::admin_user.name'), 'name'); ?></strong></td>
                        <td align="left" style="width: 20%"><strong><?php echo Widget::column(trans('backend::admin_user.role'), 'role_name'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo Widget::column(trans('backend::admin_user.status'), 'status'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center" style="width: 5%">
                                <input type="checkbox" name="ids[]" value="<?php echo $model->id ?>" />
                            </td>
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left"><?php echo $model->email; ?></td>
                            <td align="left"><?php echo e($model->name); ?></td>
                            <td align="left"><?php echo e($model->role_name); ?></td>
                            <td align="center"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></td>
                            <td align="center">
                                <?php echo $__env->make('backend::partials.row_actions',
                                [
                                'view_url' => url($data['prefix'] . '/admin_user/view/' . $model->id),
                                'edit_url' => url($data['prefix'] . '/admin_user/edit/' . $model->id),
                                'delete_url' => url($data['prefix'] . '/admin_user/delete/' . $model->id)
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