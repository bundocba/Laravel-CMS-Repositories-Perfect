@extends('backend::layouts.master')

@section('content')
@parent

@include('backend::partials.breadcrumbs')

<div class="box box-primary">

    <?php echo Form::bsOpen(['url' => $data['prefix'] . '/slug/add']); ?>

    <?php echo Form::token(); ?>

    <div id="u-l-list" class="box-body">

        @include('backend::partials.flash_message')

        <div class="form-group">
            <span class="alert-danger"><?php echo $errors->first('summary', ':message'); ?></span>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="alias"><span class="required">*</span> <?php echo trans('backend::slug.alias'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('alias', null); ?>
                <span class="alert-danger"><?php echo $errors->first('alias', ':message'); ?></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="url"><span class="required">*</span> <?php echo trans('backend::slug.url'); ?></label>
            <div class="col-sm-10">
                <?php echo Form::bsText('url', null); ?>
                <span class="alert-danger"><?php echo $errors->first('url', ':message'); ?></span>
            </div>
        </div>

    </div>

    <div class="box-footer">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::bsSubmit(trans('backend::global.submit')); ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $data['back_url'] ? $data['back_url'] : url($data['prefix'] . '/slug/list'); ?>"><?php echo trans('backend::global.back'); ?></a>
        </div>
    </div>

    <?php echo Form::close(); ?>

</div>

@endsection

