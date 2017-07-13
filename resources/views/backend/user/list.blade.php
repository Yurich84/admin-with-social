@extends('backend.layouts.main')

@section('content')

    <h1>Пользователи</h1>

    <table class="table">
        <tr>
            <td>Пользователь</td>
        @foreach($roles as $role)
            <td>{{ $role->name }}</td>
        @endforeach
            <td> - </td>
            <td> - </td>
            <td> - </td>
            <td> - </td>
        </tr>
        @foreach($users as $user)
            <tr><form action="{{ route('backend.user.updaterole') }}">
                <td>
                    <input type="hidden" name="user_id" value="{{ $user->id }}"/>
                    {{ $user->name }}
                    @if($user->token)
                        <br><a onclick="alert('{{ $user->token }}')" href="#">токен</a>
                    @endif
                </td>
            @foreach($roles as $role)
                <td><input class="role_check" name="roles[]" value="{{ $role->id }}" type="checkbox" @if($user->hasRole($role->name)) checked @endif /></td>
            @endforeach
                <td><input class="btn btn-sm" type="submit" value="Применить"/></td>
                <td><a class="btn btn-danger" onclick="return confirm('Удалить пользователя {{ $user->name }}?');" href="{{ route('backend.user.del', ['id' => $user->id]) }}">Удалить</a></td>
                <td><a class="btn btn-default" href="{{ route('backend.admin.tokenforuser', ['id' => $user->id]) }}">Токен</a></td>
                <td><a class="btn btn-default" href="{{ route('backend.admin.loginbyuser', ['id' => $user->id]) }}">Войти</a></td>
                </form>
            </tr>
        @endforeach
    </table>


@endsection
