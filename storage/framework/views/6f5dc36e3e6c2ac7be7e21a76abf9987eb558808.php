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
                        <a href="<?php echo url($data['prefix'] . '/slug/add'); ?>">
                            <button class="btn btn-success">
                                <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                            </button>
                        </a>
                    </div>

                    <div class="form-group">

                        <?php echo $__env->make('backend::partials.mass_actions', [
                        'mass_delete_url' => url($data['prefix'] . '/slug/massdelete')
                        ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    </div>

                </div>

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

                    document.location.href = '<?php echo url($data['prefix'] . '/slug/list/'); ?>' + query;

                });

            });

        </script>


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
                        <td align="left" style="width: 40%"><strong><?php echo Widget::column(trans('backend::slug.alias'), 'alias'); ?></strong></td>
                        <td align="left" style="width: 40%"><strong><?php echo Widget::column(trans('backend::slug.url'), 'url'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center" style="width: 5%">
                                <input type="checkbox" name="ids[]" value="<?php echo $model->id ?>" />
                            </td>
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left"><?php echo e($model->alias); ?></td>
                            <td align="left"><?php echo e($model->url); ?></td>
                            <td align="center">
                                <?php echo $__env->make('backend::partials.row_actions',
                                [
                                'view_url' => url($data['prefix'] . '/slug/view/' . $model->id),
                                'edit_url' => url($data['prefix'] . '/slug/edit/' . $model->id),
                                'delete_url' => url($data['prefix'] . '/slug/delete/' . $model->id)
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