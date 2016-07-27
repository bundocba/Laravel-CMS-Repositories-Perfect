@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <?php echo Form::bsOpen(); ?>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="alias"><?php echo trans('backend::slug.alias'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->alias }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="url"><?php echo trans('backend::slug.url'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->url }}</p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/slug/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection