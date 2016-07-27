<?php
    use PragmaRX\Google2FA\Google2FA;
?>

@extends('frontend::layouts.master')

@section('content')
    @parent


    <?php echo Form::model($model, ['url' => $data['lang'] . '/account/setting']); ?>

    <?php echo Form::token(); ?>

    <div class="form-group">
        <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
    </div>

    <div class="form-group">
        <label class="" for="two_factor_auth">Two-Factor Authentication</label>
        <div>
            <?php echo Form::checkbox('two_factor_auth'); ?>
            <span class="alert-danger"><?php echo $errors->first('two_factor_auth', ':message'); ?></span>
        </div>
    </div>

    <?php if ($model->two_factor_auth) : ?>

    <div class="form-group">
        <?php
            $google2fa = new Google2FA();
            $google2faUrl = $google2fa->getQRCodeGoogleUrl(
                $appName,
                $model->email,
                $secretKey
            );
        ?>
        <img src="<?php echo $google2faUrl ?>" />
        <div>
            <?php echo $model->secret_key; ?>
        </div>
    </div>

    <div class="form-group">
        <div>
            <?php echo $google2fa->getCurrentOtp($secretKey); ?>
        </div>
    </div>

    <?php endif; ?>

    <div class="box-footer">
        <input type="submit" class="btn btn-primary" value="Update" />
        <!--
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo url($data['lang'] . '/account/setting'); ?>">Cancel</a>
        -->
    </div>

    <?php echo Form::close(); ?>

@endsection