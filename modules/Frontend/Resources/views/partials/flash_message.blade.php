@if (Session::has('message'))
    <div class="alert alert-success" style="padding: 10px 10px;">{{ Session::get('message') }}</div>
@endif

@if (Session::has('error'))
    <div class="alert alert-error" style="padding: 10px 10px;">{{ Session::get('error') }}</div>
@endif
