@extends('backend.layouts.main')

@section('head')
    {!! Html::style('/css/signin.css') !!}
@stop

@section('content')

    <h1>Персональная страница</h1>

    @role('unconfirmed')
        <p class="alert-warning">Активируйте аккаунт, пройдя по ссылке которую мы прислали на почту.</p>
    @endrole

    <div class="row">
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

            <div class="row">
                {!! Form::open(['route' => 'backend.user.changeuserinfo', 'method' => 'PUT', 'class'=>'form', 'id'=>'change_theme_form' ])!!}

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    {!! Form::label('name', 'Имя: ') !!}
                    <br/>
                    {!! Form::label('email', 'E-Mail: ') !!}
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    {!! Form::text('name', $user->name) !!}
                    <br>
                    {!! Form::text('email', $user->email) !!}
                </div>

                {!! Form::submit('Сохранить') !!}

                {!! Form::close() !!}
            </div>

            <hr/>
            @inject('themes', 'App\Http\Controllers\Backend\ThemeController')

            {!! Form::open(['route' => 'backend.user.changetheme', 'method' => 'PUT', 'class'=>'form', 'id'=>'change_theme_form' ])!!}

            Тема оформления: &nbsp;&nbsp;

            {!! Form::select('theme', $themes->getlist(), (!is_null($user->theme)) ? $user->theme->id : 1,
                    [
                        'id' => 'change_theme',
                        'onchange' => 'this.form.submit()'
                    ]) !!}

            {!! Form::hidden('user_id', $user->id) !!}

            {!! Form::close() !!}

        </div>

        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <p class="or-social">Связать учетную запись</p>

            @if( in_array( 'vkontakte', $user->socials()->pluck('provider')->all() ) )
                <p>Вы авторизированы Вконтакте
                    @if( $user->socials()->count() > 1 )
                        <a class="btn btn-danger" href="{{ route('backend.user.delsocial', ['provider' => 'vkontakte', 'user_id' => $user->id]) }}">Отвязать</a>
                    @endif
                </p>
            @else
                <a href="{{ route('soc.login', ['provider' => 'vkontakte', 'user_id' => $user->id]) }}" class="btn btn-lg btn-primary btn-block vk" type="submit">Вконтакте</a>
            @endif
            <br/>

            @if( in_array( 'odnoklassniki', $user->socials()->pluck('provider')->all() ) )
                <p>Вы авторизированы в Одноклассниках
                    @if( $user->socials()->count() > 1 )
                        <a class="btn btn-danger" href="{{ route('backend.user.delsocial', ['provider' => 'vkontakte', 'user_id' => $user->id]) }}">Отвязать</a>
                    @endif
                </p>
            @else
                <a href="{{ route('soc.login', ['provider' => 'odnoklassniki', 'user_id' => $user->id]) }}" class="btn btn-lg btn-primary btn-block ok" type="submit">Одноклассники</a>
            @endif
            <br/>

            @if( in_array( 'facebook', $user->socials()->pluck('provider')->all() ) )
                <p>Вы авторизированы в Facebook
                    @if( $user->socials()->count() > 1 )
                        <a class="btn btn-danger" href="{{ route('backend.user.delsocial', ['provider' => 'vkontakte', 'user_id' => $user->id]) }}">Отвязать</a>
                    @endif
                </p>
            @else
                <a href="{{ route('soc.login', ['provider' => 'facebook', 'user_id' => $user->id]) }}" class="btn btn-lg btn-primary btn-block facebook" type="submit">Facebook</a>
            @endif

        </div>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

        </div>
    </div>


@endsection

