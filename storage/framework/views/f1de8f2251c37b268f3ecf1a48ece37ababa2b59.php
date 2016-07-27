<?php $__env->startSection('content'); ?>
@parent

<?php echo $__env->make('backend::partials.breadcrumbs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="box box-primary">

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/article/add/?lang=' . $data['lang']]); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        <?php echo $__env->make('backend::partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="title"><span class="required">*</span> <?php echo trans('backend::post.title'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('title'); ?>
                <span class="alert-danger"><?php echo $errors->first('title', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug"><?php echo trans('backend::post.slug'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('slug'); ?>
                <span class="alert-danger"><?php echo $errors->first('slug', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="thumb_url"><?php echo trans('backend::post.thumbnail'); ?></label>
            <div class="form-inline col-sm-10">
                <img id="thumb_img" src="<?php echo e(asset('assets/backend/img/no-image.png')); ?>" class="no-image" />
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="input-group col-sm-12">
                    <?php echo Form::bsText('thumb_url'); ?>
                    <div class="input-group-btn">
                        <button type="button" id="thumb-browse-btn" class="btn btn-primary glyphicon glyphicon-search"></button>
                        <button type="button" id="thumb-remove-btn" class="btn btn-danger glyphicon glyphicon-remove"></button>
                    </div>
                </div>
                <span class="alert-danger"><?php echo $errors->first('thumb_url', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="term_id"><?php echo trans('backend::post.category'); ?></label>
            <div class="col-sm-2 checkbox">
                <?php foreach ($termList as $term) : ?>
                    <label class="checkbox">
                        <?php echo Form::checkbox('term_id[]', $term['id']); ?> <?php echo $term['name']; ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="intro_text"><?php echo trans('backend::post.intro_text'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsTextarea('intro_text', null, ['height' => '40px', 'rows' => 5]); ?>
                <span class="alert-danger"><?php echo $errors->first('intro_text', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="body"><?php echo trans('backend::post.body'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsTextarea('body'); ?>
                <span class="alert-danger"><?php echo $errors->first('body', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="published_date"><?php echo trans('backend::post.published_date'); ?></label>
            <div class="col-sm-10 form-inline">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <?php echo Form::bsText('published_date', date('Y-m-d', strtotime(\Carbon\Carbon::now($data['settings']['time_zone'])))); ?>
                </div>
            </div>
        </div>

        <!--
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
        <?php echo Form::checkbox('allow_comment', 1); ?> &nbsp;&nbsp;Allow comment
                <span class="alert-danger"><?php echo $errors->first('allow_comment', ':message'); ?></span>
            </div>
        </div>
        -->

        <div class="form-group">
            <label class="col-sm-2 control-label" for="promoted"><?php echo trans('backend::post.promoted'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('promoted', $promotedList); ?>
                <div class="help-block"><?php echo trans('backend::post.promoted_desc'); ?></div>
                <span class="alert-danger"><?php echo $errors->first('promoted', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="sticked"><?php echo trans('backend::post.sticked'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('sticked', $stickedList); ?>
                <div class="help-block"><?php echo trans('backend::post.sticked_desc'); ?></div>
                <span class="alert-danger"><?php echo $errors->first('sticked', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="view_count"><?php echo trans('backend::post.view_count'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('view_count', null, ['size' => '6', 'maxlength' => '6']); ?>
                <span class="alert-danger"><?php echo $errors->first('view_count', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><span class="required">*</span> <?php echo trans('backend::post.status'); ?></label>
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
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/post/list/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

<script src="<?php echo e(asset($data['settings']['ckeditor_url'] . '/ckeditor.js')); ?>"></script>
<script src="<?php echo e(asset($data['settings']['ckfinder_url'] . '/ckfinder.js')); ?>"></script>


<script type="text/javascript">

$(document).ready(function () {

    CKEDITOR.replace('body', {
        filebrowserBrowseUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/ckfinder.html'); ?>',
        filebrowserImageBrowseUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/ckfinder.html?type=Images'); ?>',
        filebrowserFlashBrowseUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/ckfinder.html?type=Flash') ?>',
        filebrowserUploadUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/core/connector/php/connector.php?command=QuickUpload&type=Files'); ?>',
        height: '800px'
    });

    CKEDITOR.replace('intro_text', {
        filebrowserBrowseUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/ckfinder.html'); ?>',
        filebrowserImageBrowseUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/ckfinder.html?type=Images'); ?>',
        filebrowserFlashBrowseUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/ckfinder.html?type=Flash') ?>',
        filebrowserUploadUrl: '<?php echo url($data['settings']['ckfinder_url'] . '/core/connector/php/connector.php?command=QuickUpload&type=Files'); ?>',
        height: '200px'
    });


    $('#title').on('change keyup paste', function () {
        $('#slug').val(stringToSlug($('#title').val()) + '.html');
        //$('#slug').val(stringToSlug($('#title').val()));
    });

    function browseServer() {
        var config = {};
        //config.startupPath = 'Images:/thumbs/';
        var finder = new CKFinder(config);
        finder.selectActionFunction = setFileField;
        finder.popup();
    }

    function setFileField(fileUrl) {
        //var file = fileUrl.replace(/\/\//g, '/');
        $('#thumb_url').val(fileUrl);
        $('#thumb_img').attr('src', fileUrl);
    }

    $('#thumb-browse-btn').click(function () {

        browseServer();

//        CKFinder.modal({
//            chooseFiles: true,
//            width: 800,
//            height: 600,
//            onInit: function (finder) {
//                finder.on('files:choose', function (evt) {
//                    var file = evt.data.files.first();
//                    $('#thumb_url').val(file.getUrl());
//                    $('#thumb_img').attr('src', file.getUrl());
//                });
//
//                finder.on('file:choose:resizedImage', function (evt) {
//                    $('#thumb_url').val(evt.data.resizedUrl);
//                    $('#thumb_img').attr('src', evt.data.resizedUrl);
//                });
//            }
//        });
    });

    $('#thumb-remove-btn').click(function () {
        $('#thumb_url').val('');
        $('#thumb_img').attr('src', "<?php echo e(asset('assets/backend/img/no-image.png')); ?>");
    });

    $('#published_date').datepicker({
        calendarWeeks: true,
        todayHighlight: true,
        autoclose: true,
        toggleActive: true,
        format: "yyyy-mm-dd"
    });

});

</script>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('backend::layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>