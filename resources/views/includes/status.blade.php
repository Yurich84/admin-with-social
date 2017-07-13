@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('status') }} status-box">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        {{ Session::get('message') }}
    </div>
@endif

{{--if use ->withSuccess()--}}
@if (\Session::has('success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>
            <i class="fa fa-check-circle fa-lg fa-fw"></i> {{ \Session::get('success') }}
        </strong>
    </div>
@endif