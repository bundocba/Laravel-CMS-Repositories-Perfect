@extends('backend::layouts.master')


@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsModel($model, ['url' => $data['prefix'] . '/term/edit/' . $taxonomyId . '/' . $model->id . '/?lang=' . $data['lang']]); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><span class="required">*</span> <?php echo trans('backend::term.name'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('name'); ?>
                <span class="alert-danger"><?php echo $errors->first('name', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug"><?php echo trans('backend::term.slug'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('slug'); ?>
                <span class="alert-danger"><?php echo $errors->first('slug', ':message'); ?></span>
                <div style="display: none"><?php echo $model->full_url; ?></div>
                <div style="display: none"><?php echo url('/') . '/' . $model->lang . $model->url; ?></div>
            </div>
        </div>

        <!--
        <div class="form-group">
            <label class="col-sm-2 control-label" for="thumb_url"><?php echo trans('backend::term.icon'); ?></label>
            <div class="form-inline col-sm-10">
                <?php if ($model->thumb_url) : ?>
                    <div style="padding: 5px 0px"><img id="thumb_img" src="<?php echo $model->thumb_url ?>" style="width: 90px; height: 90px" /></div>
                <?php else : ?>
                    <div style="padding: 5px 0px"><img id="thumb_img" src="{{ asset('assets/backend/img/no-image.png') }}" style="width: 90px; height: 90px" /></div>
                <?php endif; ?>
                <div>
                    <?php echo Form::bsText('thumb_url', null, ['style' => 'width: 80%']); ?>
                    <button type="button" id="thumb-browse-btn" class="btn glyphicon glyphicon-search"></button>
                    <button type="button" id="thumb-remove-btn" class="btn glyphicon glyphicon-remove"></button>
                </div>
                <span class="alert-danger"><?php echo $errors->first('thumb_url', ':message'); ?></span>
            </div>
        </div>
        -->

        <div class="form-group">
            <label class="col-sm-2 control-label" for="thumb_url"><?php echo trans('backend::post.thumbnail'); ?></label>
            <div class="form-inline col-sm-10">
                <?php if ($model->thumb_url) : ?>
                    <div style="padding: 5px 0px"><img id="thumb_img" src="<?php echo $model->thumb_url ?>" class="no-icon" /></div>
                <?php else : ?>
                    <div style="padding: 5px 0px"><img id="thumb_img" src="{{ asset('assets/backend/img/no-image.png') }}" class="no-icon" /></div>
                <?php endif; ?>
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
            <label class="col-sm-2 control-label" for="parent_id"><?php echo trans('backend::term.parent'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('parent_id', $termList, $model->parent_id); ?>
                <span class="alert-danger"><?php echo $errors->first('parent_id', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="weight"><span class="required">*</span> <?php echo trans('backend::term.weight'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('weight', $weightList); ?>
                <span class="alert-danger"><?php echo $errors->first('weight', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><span class="required">*</span> <?php echo trans('backend::term.status'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('status', $statusList); ?>
                <span class="alert-danger"><?php echo $errors->first('status', ':message'); ?></span>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::bsSubmit(trans('backend::global.submit')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/term/list/' . $taxonomyId . '/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

<script src="{{ asset($data['settings']['ckfinder_url'] . '/ckfinder.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function () {

        $('#name').on('change keyup paste', function () {
            $('#slug').val(stringToSlug($('#name').val()));
        });

        function browseServer() {
            var config = {};
            config.startupPath = 'Images:/icons/';
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

//            CKFinder.modal({
//                chooseFiles: true,
//                width: 800,
//                height: 600,
//                onInit: function (finder) {
//                    finder.on('files:choose', function (evt) {
//                        var file = evt.data.files.first();
//                        $('#thumb_url').val(file.getUrl());
//                        $('#thumb_img').attr('src', file.getUrl());
//                    });
//
//                    finder.on('file:choose:resizedImage', function (evt) {
//                        $('#thumb_url').val(evt.data.resizedUrl);
//                        $('#thumb_img').attr('src', evt.data.resizedUrl);
//                    });
//                }
//            });
        });

        $('#thumb-remove-btn').click(function () {
            $('#thumb_url').val('');
            $('#thumb_img').attr('src', "{{ asset('assets/backend/img/no-image.png') }}");
        });

    });

</script>

@endsection