@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/role/add']); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><span class="required">*</span> <?php echo trans('backend::role.name'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('name', null); ?>
                <span class="alert-danger"><?php echo $errors->first('name', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="description"><?php echo trans('backend::role.description'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsTextarea('description', null); ?>
                <span class="alert-danger"><?php echo $errors->first('description', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="priority"><span class="required">*</span> <?php echo trans('backend::role.priority'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('priority', $priorityList, null); ?>
                <span class="alert-danger"><?php echo $errors->first('priority', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><span class="required">*</span> <?php echo trans('backend::role.status'); ?></label>
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
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/role/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection

