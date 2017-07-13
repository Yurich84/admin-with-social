@if($errors->has())
    <div class="alert alert-danger fade in">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>Ошибки</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif