@extends('templates.default')

@section('content')
	<h3>Авторизация</h3>
	<div class="row">
		<div class="col-lg-6">
			<form class="form-vertical" role="form" method="post" action="{{ route('auth.signin') }}">
				<div class="form-group{{ $errors->has('email') ? ' has-error' : ''  }}">
					<label for="email" class="control-label">Email</label>
					<input type="text" name="email" class="form-control" id="email">
					@if ($errors->has('email'))
					<span class="help-block">{{ $errors->first('email') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('password') ? ' has-error' : ''  }}">
					<label for="password" class="control-label">Пароль</label>
					<input type="password" name="password" class="form-control" id="password">
					@if ($errors->has('password'))
					<span class="help-block">{{ $errors->first('password') }}</span>
					@endif
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="remember"> Запомнить меня :з
					</label>
				</div>
				<div class="form-gorup">
					<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Войти</button>
				</div>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
		</div>
	</div>
@stop