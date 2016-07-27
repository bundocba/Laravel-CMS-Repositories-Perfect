
@extends('frontend::layouts.master')

@section('content')
@parent

<div class="login-box-body col-md-5">

    <?php echo Form::open(['url' => $data['lang'] . '/user/login']) ?>

    <?php echo Form::token() ?>

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group has-feedback">
        <label for="email"><?php echo trans('frontend::login.email') ?></label>
        <?php echo Form::bsText('email', '', ['placeholder' => trans('frontend::login.email.placeholder')]); ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <span class="alert-danger"><?php echo $errors->first('email', ':message'); ?></span>
    </div>

    <div class="form-group has-feedback">
        <label for="password"><?php echo trans('frontend::login.password') ?></label>
        <?php echo Form::bsPassword('password', ['placeholder' => trans('frontend::login.password.placeholder')]); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="alert-danger"><?php echo $errors->first('password', ':message'); ?></span>
    </div>

    <div class="checkbox">
        <label>
            <?php echo Form::checkbox('remember_me', 1); ?><?php echo trans('frontend::login.remember_me') ?>
        </label>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary"><?php echo trans('frontend::login.submit') ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>


@endsection