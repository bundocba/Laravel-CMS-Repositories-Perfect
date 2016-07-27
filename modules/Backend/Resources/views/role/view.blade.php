@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><?php echo trans('backend::role.name'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->name }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="description"><?php echo trans('backend::role.description'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->description }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="priority"><?php echo trans('backend::role.priority'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">{{ $model->priority }}</p>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><?php echo trans('backend::role.status'); ?></label>
            <div class="col-sm-10">
                <p class="form-control-static">@status($model->status)</p>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/role/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection