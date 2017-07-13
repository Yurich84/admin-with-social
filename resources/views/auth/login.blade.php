@extends('frontend.layouts.main')

@section('head')
    {!! Html::style('/css/signin.css') !!}
@stop

@section('content')


    {!! Form::open(['url' => '#', 'class' => 'form-signin' ] ) !!}

    <h2 class="form-signin-heading">Войти</h2>
    <label for="inputEmail" class="sr-only">Email</label>
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-mail', 'required', 'autofocus', 'id' => 'inputEmail' ]) !!}
    <label for="inputPassword" class="sr-only">Пароль</label>
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Пароль', 'required',  'id' => 'inputPassword' ]) !!}

    <div class="checkbox">
        <label>
            {!! Form::checkbox('remember', 1) !!} Запомнить
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p><a href="{{ url('/password/reset') }}">Забыли пароль?</a> &nbsp; &nbsp;
        <a href="{{ url('/register') }}">Зарегистрироваться</a></p>

    <p class="or-social">Войти через</p>

    <a href="{{ url('/social_login/vkontakte') }}" class="btn btn-lg btn-primary btn-block vk" type="submit">Вконтакте</a>
    <a href="{{ url('/social_login/odnoklassniki') }}" class="btn btn-lg btn-primary btn-block ok" type="submit">Одноклассники</a>
    <a href="{{ url('/social_login/facebook') }}" class="btn btn-lg btn-primary btn-block facebook" type="submit">Facebook</a>

    {!! Form::close() !!}

@stop
