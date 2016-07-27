
@extends('frontend::layouts.master')

@section('content')
    @parent

    <div class="login-box-body col-md-5">

    <?php echo Form::open(['url' => $data['lang'] . '/user/register']); ?>

    <?php echo Form::token(); ?>

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="email"><?php echo trans('frontend::register.email') ?> <span class="required">*</span></label>
        <?php echo Form::bsText('email', null); ?>
        <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for=""><?php echo trans('frontend::register.password') ?> <span class="required">*</span></label>
        <?php echo Form::bsPassword('password'); ?>
        <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for=""><?php echo trans('frontend::register.retype_password') ?> <span class="required">*</span></label>
        <?php echo Form::bsPassword('retype_password'); ?>
        <span class="alert-danger"><?php echo $errors->first('retype_password', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for=""><?php echo trans('frontend::register.first_name') ?> <span class="required">*</span></label>
        <?php echo Form::bsText('first_name', null); ?>
        <span class="alert-danger"><?php echo $errors->first('first_name', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for=""><?php echo trans('frontend::register.last_name') ?> <span class="required">*</span></label>
        <?php echo Form::bsText('last_name', null); ?>
        <span class="alert-danger"><?php echo $errors->first('last_name', ':message'); ?></span>
    </div>

    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="<?php echo trans('frontend::register.submit') ?>" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url($data['lang'] . '/user/register'); ?>"><?php echo trans('frontend::register.cancel') ?></a>
    </div>

    <?php echo Form::close(); ?>

    </div>

@endsection