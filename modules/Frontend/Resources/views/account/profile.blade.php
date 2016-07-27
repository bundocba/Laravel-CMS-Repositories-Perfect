@extends('frontend::layouts.master')

@section('content')
    @parent

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="">Email</label>
        <div>{{ $model->email }}</div>
    </div>

    <div class="form-group">
        <label class="" for="">First name</label>
        <div>{{ $model->first_name }}</div>
    </div>

    <div class="form-group">
        <label class="" for="">Last name</label>
        <div>{{ $model->last_name }}</div>
    </div>

    <div class="box-footer">
        <a href="<?php echo url($data['lang'] . '/account/updateprofile'); ?>">Update profile</a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url($data['lang'] . '/account/changepassword'); ?>">Change password</a>
    </div>


@endsection