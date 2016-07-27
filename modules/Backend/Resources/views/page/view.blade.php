@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="title"><?php echo trans('backend::post.title'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->title }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug"><?php echo trans('backend::post.slug'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->slug }}</p>
                <div style="display: none"><?php echo $model->full_url; ?></div>
                <div style="display: none"><?php echo url('/') . '/' . $model->lang . $model->url; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="term_id"><?php echo trans('backend::post.category'); ?></label>
            <div class="col-sm-10 checkbox">
                <?php foreach ($terms as $term) : ?>
                <span class="tag">
                    <?php echo $term->name; ?>
                </span> &nbsp;&nbsp;&nbsp;&nbsp;
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="intro_text"><?php echo trans('backend::post.intro_text'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->intro_text ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="body"><?php echo trans('backend::post.body'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->body ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="created_by"><?php echo trans('backend::post.created_by'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->creator_name; ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="created_date"><?php echo trans('backend::post.created_date'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->created_date; ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="modified_by"><?php echo trans('backend::post.modified_by'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->modifier_name; ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="modified_date"><?php echo trans('backend::post.modified_date'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static"><?php echo $model->modified_date; ?></p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><?php echo trans('backend::post.status'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">@status($model->status)</p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url('admin/post/list/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection