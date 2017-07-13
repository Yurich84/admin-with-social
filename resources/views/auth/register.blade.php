@extends('frontend.layouts.main')

@section('head')
    {!! Html::style('/css/signin.css') !!}
@stop

@section('content')

    {!! Form::open(['url' => '#', 'class' => 'form-signin' ] ) !!}

    <h2 class="form-signin-heading">Зарегестрируйтесь</h2>

    <label for="inputEmail" class="sr-only">Email</label>
    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'required', 'autofocus', 'id' => 'inputEmail' ]) !!}

    <label for="inputFirstName" class="sr-only">First name</label>
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Имя', 'required', 'id' => 'inputFirstName' ]) !!}

    <label for="inputPassword" class="sr-only">Password</label>
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Пароль', 'required',  'id' => 'inputPassword' ]) !!}

    <label for="inputPasswordConfirm" class="sr-only">Confirm Password</label>
    {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Подтвердить пароль', 'required',  'id' => 'inputPasswordConfirm' ]) !!}

    <button class="btn btn-lg btn-primary btn-block" type="submit">Регистрация</button>

    <p class="or-social">Через социальные сети</p>

    <a href="{{ url('/social_login/vkontakte') }}" class="btn btn-lg btn-primary btn-block vk" type="submit">Вконтакте</a>
    <a href="{{ url('/social_login/odnoklassniki') }}" class="btn btn-lg btn-primary btn-block ok" type="submit">Одноклассники</a>
    <a href="{{ url('/social_login/facebook') }}" class="btn btn-lg btn-primary btn-block facebook" type="submit">Facebook</a>
    {!! Form::close() !!}


@stop