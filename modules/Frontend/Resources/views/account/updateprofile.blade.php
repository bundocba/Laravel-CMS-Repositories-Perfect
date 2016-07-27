@extends('frontend::layouts.master')

@section('content')
    @parent

    <?php echo Form::model($model, ['url' => $data['lang'] . '/account/updateprofile']); ?>

    <?php echo Form::token(); ?>

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="email">Email <span class="required">*</span></label>
        <?php echo Form::bsText('email'); ?>
        <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="first_name">First name <span class="required">*</span></label>
        <?php echo Form::bsText('first_name'); ?>
        <span class="alert-danger"><?php echo $errors->first('first_name', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="last_name">Last name <span class="required">*</span></label>
        <?php echo Form::bsText('last_name'); ?>
        <span class="alert-danger"><?php echo $errors->first('last_name', ':message'); ?></span>
    </div>

    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="Submit" />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url($data['lang'] . '/account/profile'); ?>">Cancel</a>
    </div>

    <?php echo Form::close(); ?>

@endsection