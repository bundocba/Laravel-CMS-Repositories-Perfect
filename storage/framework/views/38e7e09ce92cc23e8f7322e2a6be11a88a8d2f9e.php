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
                        <button data-form="" data-title="" data-message="" data-target="#select-content-type-form" data-toggle="modal" class="btn btn-success" class="select-content-type-form">
                            <?php echo trans('backend::global.addnew'); ?> &nbsp; <i class="fa fa-plus"></i>
                        </button>
                    </div>

                    <div class="form-group">

                        <?php echo $__env->make('backend::partials.mass_actions', [
                        'mass_activate_url' => url($data['prefix'] . '/post/massactivate'),
                        'mass_deactivate_url' => url($data['prefix'] . '/post/massdeactivate'),
                        'mass_delete_url' => url($data['prefix'] . '/post/massdelete')
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

                    document.location.href = '<?php echo url($data['prefix'] . '/post/list/'); ?>' + query;

                });

                $('#filter-btn').click(function (event) {

                    var lang = encodeURI($('#lang').val());
                    var title = encodeURI($('#title').val());
                    var contentTypeId = encodeURI($('#content_type_id').val());
                    var termId = encodeURI($('#term_id').val());

                    var query = '?lang=' + lang + '&title=' + title + '&content_type_id=' + contentTypeId + '&term_id=' + termId;

                    document.location.href = '<?php echo url($data['prefix'] . '/post/list/'); ?>' + query;

                });

                $('#filter-form').submit(function (event) {

                    event.preventDefault();

                    var lang = encodeURI($('#lang').val());
                    var title = encodeURI($('#title').val());
                    var contentTypeId = encodeURI($('#content_type_id').val());
                    var termId = encodeURI($('#term_id').val());

                    var query = '?lang=' + lang + '&title=' + title + '&content_type_id=' + contentTypeId + '&term_id=' + termId;

                    document.location.href = '<?php echo url($data['prefix'] . '/post/list/'); ?>' + query;

                });

            });

        </script>

        <div id="filter-panel">

            <form id="filter-form" class="form form-inline form-multiline" method="GET" action="<?php echo url($data['prefix'] . '/post/list/?lang=' . $data['lang']); ?>">

                <div class="form-inline">

                    <div class="form-group">
                        <label class="" for="title"><?php echo trans('backend::post.title'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsText('title', \Request::query('title')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('title', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="" for="content_type_id"><?php echo trans('backend::post.content_type'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsSelect('content_type_id', $contentTypeList, \Request::query('content_type_id')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('content_type_id', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <label class="" for="term_id"><?php echo trans('backend::post.category'); ?></label> &nbsp;&nbsp;
                        <?php echo Form::bsSelect('term_id', $termList, \Request::query('term_id')); ?> &nbsp;&nbsp;
                        <span class="alert-danger"><?php echo $errors->first('term_id', ':message'); ?></span>
                    </div>

                    <div class="form-group">
                        <input type="button" id="filter-btn" class="btn btn-primary" value="<?php echo trans('backend::global.filter'); ?>" />
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo url($data['prefix'] . '/post/list/?lang=' . $data['lang']); ?>">
                        <input type="button" class="btn btn-default" value="<?php echo trans('backend::global.clear'); ?>" /></a>
                    </div>

                </div>

            </form>

        </div>

        <?php if (!empty($models) && $models->total() > 0) : ?>

            <div class="clearfix"></div>

            <?php echo Form::bsOpen(['id' => 'list-form', 'name' => 'list-form']); ?>

            <?php echo Form::token(); ?>

            <div class="table-responsive-custom">

                <table class="table table-striped table-hover table-bordered dataTable no-footer dtr-inline">
                    <tr>
                        <td align="center" style="width: 5%">
                            <input type="checkbox" id="check_all" name="check_all" />
                        </td>
                        <td align="center" style="width: 5%"><strong><?php echo trans('backend::global.#') ?></strong></td>
                        <td align="left" style="width: 30%"><strong><?php echo Widget::column(trans('backend::post.title'), 'title'); ?></strong></td>
                        <td align="left" style="width: 10%"><strong><?php echo Widget::column(trans('backend::post.content_type'), 'content_types.name'); ?></strong></td>
                        <td align="left" style="width: 15%"><strong><?php echo trans('backend::post.category') ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo Widget::column(trans('backend::post.published_date'), 'published_date'); ?></strong></td>
                        <td align="center" style="width: 5%"><strong><?php echo Widget::column(trans('backend::post.view_count'), 'view_count'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo Widget::column(trans('backend::post.status'), 'status'); ?></strong></td>
                        <td align="center" style="width: 10%"><strong><?php echo trans('backend::global.actions') ?></strong></td>
                    </tr>
                    <?php $count = $models->firstItem(); ?>
                    <?php foreach ($models as $model): ?>
                        <tr class="<?php echo ($count % 2 ? '' : 'alternate'); ?>">
                            <td align="center" style="width: 5%">
                                <input type="checkbox" name="ids[]" value="<?php echo $model->id ?>" />
                            </td>
                            <td align="center"><?php echo $count; ?></td>
                            <td align="left">
                                <?php echo e($model->title); ?>

                                <div>
                                <!--
                                <?php if ($model->promoted) : ?>
                                    <span class="badge alert-danger"><?php echo $model->promoted; ?></span>
                                <?php endif; ?>
                                <?php if ($model->sticked) : ?>
                                    <span class="badge alert-info"><?php echo $model->sticked; ?></span>
                                <?php endif; ?>
                                </div>
                                -->
                                <div style="display: none"><?php echo e(url('/') . $model->url); ?></div>
                            </td>
                            <td align="left"><?php echo $model->contentType ? $model->contentType->name : ''; ?></td>
                            <td align="left">
                                <?php
                                    $index = 0;
                                    $terms = $model->terms;
                                    foreach ($terms as $term) {
                                        if ($index > 0) echo ', &nbsp;&nbsp;&nbsp;&nbsp;';
                                        echo ' <span>' . $term->name . '<span>';
                                        $index++;
                                    }
                                ?>
                            </td>
                            <td align="center"><?php echo ($model->published_date) != null ? date('Y-m-d', strtotime(($model->published_date))) : ''; ?></td>
                            <td align="center"><?php echo ($model->view_count) != null ? number_format(($model->view_count), 0, '.', ',') : ''; ?></td>
                            <td align="center"><?php echo ($model->status) == 1 ? '<span class="label label-success">Hoạt động</span>' : '<span class="label label-default">Ngưng</span>'; ?></td>
                            <td align="center">
                                <?php if ($model->content_type_id == 1) : ?>

                                    <?php echo $__env->make('backend::partials.row_actions',
                                    [
                                    'view_url' => url($data['prefix'] . '/page/view/' . $model->id),
                                    'edit_url' => url($data['prefix'] . '/page/edit/' . $model->id . '/?lang=' . $data['lang']),
                                    'delete_url' => url($data['prefix'] . '/post/delete/' . $model->id)
                                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php elseif ($model->content_type_id = 2) : ?>

                                    <?php echo $__env->make('backend::partials.row_actions',
                                    [
                                    'view_url' => url($data['prefix'] . '/article/view/' . $model->id),
                                    'edit_url' => url($data['prefix'] . '/article/edit/' . $model->id . '/?lang=' . $data['lang']),
                                    'delete_url' => url($data['prefix'] . '/post/delete/' . $model->id)
                                    ], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php endif; ?>
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

<div class="modal fade" id="select-content-type-form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo trans('backend::global.close'); ?></span></button>
                <h4 class="modal-title" id="frm_title"><?php echo trans('backend::post.select_content_type'); ?></h4>
            </div>
            <div class="modal-body" id="frm_body">

                <div class="form-group">
                    <h3><a href="<?php echo url($data['prefix'] . '/article/add/?lang=' . $data['lang']) ?>"><?php echo trans('backend::post.article'); ?></a></h3>
                    <span class=""><?php echo trans('backend::post.article_desc'); ?></span>
                </div>

                <div class="form-group">
                    <h3><a href="<?php echo url($data['prefix'] . '/page/add/?lang=' . $data['lang']) ?>"><?php echo trans('backend::post.basic_page'); ?></a></h3>
                    <span class=""><?php echo trans('backend::post.basic_page_desc'); ?></span>
                </div>

            </div>

        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>