<div class="form-inline" style="margin-bottom: 15px">

    <div class="form-group col-md-4">
    </div>

    <div class="form-group col-md-4" style="text-align: center">
        {!! $models->appends(\Input::except('page'))->render() !!}
    </div>

    <div class="form-group col-md-4" style="text-align: right">
    </div>

    <div class="clearfix"></div>

</div>