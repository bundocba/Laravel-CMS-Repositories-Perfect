@extends('frontend::layouts.master')

@section('content')
    @parent

    <?php echo Form::open(['url' => $data['lang'] . '/account/changepassword']); ?>

    <?php echo Form::token(); ?>

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="password">Password <span class="required">*</span></label>
        <?php echo Form::bsPassword('password'); ?>
        <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="new_password">New password <span class="required">*</span></label>
        <?php echo Form::bsPassword('new_password'); ?>
        <span class="alert-danger"><?php echo $errors->first('new_password', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="retype_password">Retype password <span class="required">*</span></label>
        <?php echo Form::bsPassword('retype_password'); ?>
        <span class="alert-danger"><?php echo $errors->first('retype_password', ':message'); ?></span>
    </div>

    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="Submit" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url($data['lang'] . '/account/profile'); ?>">Cancel</a>
    </div>

    <?php echo Form::close(); ?>

@endsection