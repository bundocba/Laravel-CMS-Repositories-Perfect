<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div id="toolbar">

            <div class="pull-left">

                <a href="<?php echo url($data['prefix'] . '/term/add/' . $taxonomyId . '/?lang=' . $data['lang']); ?>">
                    <button class="btn btn-success">
                        <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                    </button>
                </a>

            </div>

            <div class="pull-right">

                <?php echo Form::bsSelect('lang', $languageList, $data['lang']); ?> &nbsp;&nbsp;
                <span class="alert-danger"><?php echo $errors->first('lang', ':message'); ?></span>

            </div>

            <div class="clearfix"></div>

        </div>

        <script type="text/javascript">

            $(document).ready(function () {

                $('#lang').change(function (event) {

                    var lang = encodeURI($('#lang').val());
                    var query = '?lang=' + lang;

                    document.location.href = '<?php echo url($data['prefix'] . '/term/list/' . $taxonomyId . '/'); ?>' + query;
                });

                $('#update-weight-btn').click(function (event) {
                    $('#list-form').attr('action', '<?php echo url($data['prefix'] . '/term/updateweight/' . $taxonomyId . '/?lang=' . $data['lang']) ?>');
                    $('#list-form').submit();
                });

            });

        </script>


        <?php if (!empty($models) && $models->total() > 0) : ?>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive-custom">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 65%"><strong><?php echo trans('backend::term.name'); ?></strong></td>
                        <td align="center" style="width: 10%">
                            <strong><?php echo trans('backend::term.weight'); ?></strong>
                            <img id="update-weight-btn" style="cursor: pointer" src="<?php echo e(asset('assets/backend/img/refresh.png')); ?>"></img>
                        </td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::term.status'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = 1; ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left">
                                <?php echo \Widget::indentation($model->depth); ?>
                                <?php echo e($model->name); ?>

                                <div></div>
                            </td>
                            <td align="center">
                                <?php echo Form::hidden('weight_ids[]', $model->id); ?>
                                <?php echo Form::bsSelect('weights[]', $weightList, $model->weight, ['style' => 'width: 75px']); ?>
                            </td>
                            <td align="center"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></td>
                            <td align="center">
                                <?php echo $__env->make('backend::partials.row_actions',
                                [
                                'view_url' => url($data['prefix'] . '/term/view/' . $taxonomyId . '/' . $model->id . '/?lang=' . $data['lang']),
                                'edit_url' => url($data['prefix'] . '/term/edit/' . $taxonomyId . '/' . $model->id . '/?lang=' . $data['lang']),
                                'delete_url' => url($data['prefix'] . '/term/delete/' . $taxonomyId . '/' . $model->id . '/?lang=' . $data['lang'])
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