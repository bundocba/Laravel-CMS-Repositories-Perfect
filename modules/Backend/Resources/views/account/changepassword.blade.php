@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/account/changepassword']); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="password"><span class="required">*</span> Password</label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('password'); ?>
                <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="new_password"><span class="required">*</span> New password</label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('new_password'); ?>
                <span class="alert-danger"><?php echo $errors->first('new_password', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="retypte_password"><span class="required">*</span> Retype password</label>
            <div class="col-sm-10">
                <?php echo Form::bsPassword('retype_password'); ?>
                <span class="alert-danger"><?php echo $errors->first('retype_password', ':message'); ?></span>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::bsSubmit(trans('backend::global.submit')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/account/changepassword'); ?>">Cancel</a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection