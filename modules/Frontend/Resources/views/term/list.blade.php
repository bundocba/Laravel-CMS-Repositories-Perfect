@extends('frontend::layouts.master')

@section('content')
    @parent

    <?php foreach($models as $model) : ?>

    <div style="padding: 10px 0px 0px 10px">
        <h4><?php echo $model->title; ?></h4>
    </div>

    <div style="height: 10px">&nbsp;</div>

    <div class="col-md-12">

        <?php if ($model->thumb_url) : ?>

        <div class="col-md-2">
            <img src="<?php echo $model->thumb_url ?>" width="160" height="120" />
        </div>

        <div class="col-md-10">
            <?php echo $model->intro_text; ?>
        </div>

        <?php else : ?>

        <div class="col-md-12">
            <?php echo $model->intro_text; ?>
        </div>

        <?php endif; ?>

        <div class="clearfix"></div>

        <br />

        <div style="float: right"><a href="<?php echo $model->url; ?>"><?php echo trans('frontend::global.readmore') ?></a></div>

        <div style="height: 20px">&nbsp;</div>

    </div>

    <div class="clearfix"></div>

    <div style="height: 20px">&nbsp;</div>


    <?php endforeach; ?>

    @include('frontend::partials.paginator')

@endsection