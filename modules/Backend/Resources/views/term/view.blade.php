@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><?php echo trans('backend::term.name'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->name }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="slug"><?php echo trans('backend::term.slug'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->slug }}</p>
                <div style="display: none"><?php echo $model->full_url; ?></div>
                <div style="display: none"><?php echo url('/') . '/' . $model->lang . $model->url; ?></div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="thumb_url"><?php echo trans('backend::term.icon'); ?></label>
            <div class="col-sm-10">
                <?php if ($model->thumb_url) : ?>
                    <img src="<?php echo $model->thumb_url; ?>" style="width: 90px; height: 90px" />
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="weight"><?php echo trans('backend::term.weight'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->weight }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><?php echo trans('backend::term.status'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">@status($model->status)</p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/term/list/' . $taxonomyId . '/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection