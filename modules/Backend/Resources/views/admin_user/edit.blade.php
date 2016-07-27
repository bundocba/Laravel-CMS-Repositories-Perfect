@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsModel($model, ['url' => $data['prefix'] . '/admin_user/edit/' . $model->id]); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="email"><span class="required">*</span> <?php echo trans('backend::admin_user.email'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('email'); ?>
                <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="password"><?php echo trans('backend::admin_user.password'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('password'); ?>
                <span class="help-block"><?php echo trans('backend::admin_user.password_desc'); ?></span>
                <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="retypte_password"><?php echo trans('backend::admin_user.retype_password'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('retype_password'); ?>
                <span class="help-block"><?php echo trans('backend::admin_user.retype_password_desc'); ?></span>
                <span class="alert-danger"><?php echo $errors->first('retype_password', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="role_id"><span class="required">*</span> <?php echo trans('backend::admin_user.role'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsSelect('role_id', $roleList, $model->role_id); ?>
                <span class="alert-danger"><?php echo $errors->first('role_id', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="name"><span class="required">*</span> <?php echo trans('backend::admin_user.name'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('name'); ?>
                <span class="alert-danger"><?php echo $errors->first('name', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="status"><span class="required">*</span> <?php echo trans('backend::admin_user.status'); ?></label>
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
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/admin_user/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection