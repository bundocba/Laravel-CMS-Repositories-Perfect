@extends('frontend::layouts.master')

@section('content')
    @parent

    <div style="padding: 10px 0px 0px 10px">
        <h4><?php echo $model->title; ?></h4>
    </div>
    
    <div><?php echo $model->body; ?></div>

@endsection