@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')


<div class="box box-primary">

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/page/add/?lang=' . $data['lang']]); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

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

<script src="{{ asset($data['settings']['ckeditor_url'] . '/ckeditor.js') }}"></script>
<script src="{{ asset($data['settings']['ckfinder_url'] . '/ckfinder.js') }}"></script>

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
        });

    });

</script>

@endsection