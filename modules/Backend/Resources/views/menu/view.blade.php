@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Name</label>
            <div class="col-sm-10">{{ $model->name }}</div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="description">Description</label>
            <div class="col-sm-10">{{ $model->description }}</div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status">Status</label>
            <div class="col-sm-10">@status($model->status)</div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/menu_link/list/' . $menuId . '/?lang=' . $data['lang']); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection