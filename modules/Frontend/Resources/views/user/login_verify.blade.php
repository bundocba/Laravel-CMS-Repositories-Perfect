
@extends('frontend::layouts.master')

@section('content')
@parent

<div class="login-box-body col-md-5">

    <?php echo Form::open(['url' => $data['lang'] . '/user/login-verify']) ?>

    <?php echo Form::token() ?>

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group has-feedback">
        <label for="token"><?php echo trans('frontend::login.token') ?></label>
        <?php echo Form::bsText('token', null, ['placeholder' => trans('frontend::login.token.placeholder')]); ?>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="alert-danger"><?php echo $errors->first('token', ':message'); ?></span>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary"><?php echo trans('frontend::login.submit') ?></button>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>


@endsection