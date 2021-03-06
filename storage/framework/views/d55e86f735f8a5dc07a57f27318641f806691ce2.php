<?php $__env->startSection('content'); ?>
@parent

<div class="box box-primary">

    <div id="u-l-list" class="box-body">


        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <script type="text/javascript">

            $(document).ready(function () {

                // Handle content-type modal
                $('.select-content-type-form').on('click', function (e) {
                    e.preventDefault();
                });

                $("[name='select-btn']").click(function (event) {

                    var btn = event.target;

                    //alert($(event.target).data('text'));
                    //var url = event.target.value;

                    var contentName = $(event.target).data('content-name');
                    var url = $(event.target).data('url');
                    var contentType = $(event.target).data('content-type');
                    var contentTypeId = $(event.target).data('content-type-id');

                    $('#content_name', window.parent.document).val(contentName);
                    $('#url', window.parent.document).val(url);
                    $('#content_type_id', window.parent.document).val(contentTypeId);
                    $('#content_type', window.parent.document).val(contentType);
                    $('#type', window.parent.document).val(1);

                    parent.$('#selector-modal').modal('hide');

                });

                $('#filter-btn').click(function (event) {

                    var title = encodeURI($('#title').val());

                    var query = '?title=' + title;

                    document.location.href = '<?php echo url($data['prefix'] . '/selector/page/'); ?>' + query;

                });

            });

        </script>

        <ul class="nav nav-tabs" style="padding: 20px 0px">
            <li class="active"><a href="<?php echo e(url($data['prefix'] . '/selector/page/?lang=' . $data['lang'])); ?>"><?php echo trans('backend::selector.basic_page'); ?></a></li>
            <li><a href="<?php echo e(url($data['prefix'] . '/selector/category/?lang=' . $data['lang'])); ?>"><?php echo trans('backend::selector.category'); ?></a></li>
            <li><a href="<?php echo e(url($data['prefix'] . '/selector/customlink/?lang=' . $data['lang'])); ?>"><?php echo trans('backend::selector.custom_link'); ?></a></li>
        </ul>

        <div id="filter-panel">

            <form id="filter-form" class="form form-inline form-multiline" method="GET" action="<?php echo url($data['prefix'] . '/selector/page/?lang=' . $data['lang']); ?>">

                <div class="form-inline">

                    <div class="form-group">
                        <label class="" for="title"><?php echo trans('backend::selector.title'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsText('title', \Request::query('title')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('title', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <input type="button" id="filter-btn" class="btn btn-primary" value="<?php echo trans('backend::global.filter'); ?>" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo url($data['prefix'] . '/selector/page/?lang=' . $data['lang']); ?>">
                            <input type="button" class="btn btn-default" value="<?php echo trans('backend::global.clear'); ?>" />
                        </a>
                    </div>

                </div>

            </form>

        </div>


        <?php if (!empty($models) && $models->total() > 0) : ?>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 30%"><strong><?php echo Widget::column(trans('backend::selector.title'), 'title'); ?></strong></td>
                        <td align="left" style="width: 25%"><strong><?php echo trans('backend::selector.category'); ?></strong></td>
                        <td align="center" style="width: 15%"><strong><?php echo Widget::column(trans('backend::selector.published_date'), 'published_date'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo Widget::column(trans('backend::selector.status'), 'status'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left">
                                <?php echo e($model->title); ?>

                            </td>
                            <td align="left">
                                <?php
                                $terms = $model->terms;
                                foreach ($terms as $term) {
                                    echo ' <span>' . $term->name . '<span> &nbsp;&nbsp;&nbsp;&nbsp;';
                                }
                                ?>
                            </td>
                            <td align="center"><?php echo ($model->published_date) != null ? date('Y-m-d', strtotime(($model->published_date))) : ''; ?></td>
                            <td align="center"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></td>
                            <td align="center"><button type="button" name="select-btn" data-content-name="<?php echo e($model->title); ?>" data-content-type-id="1" data-content-type="<?php echo trans('backend::selector.basic_page'); ?>" data-url="<?php echo e($model->url); ?>" class="btn btn-primary"><?php echo trans('backend::selector.select'); ?></button></td>
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

<?php echo $__env->make('backend::layouts.popup', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>