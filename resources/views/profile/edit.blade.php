@extends('templates.default')

@section('content')
	<h3>Редактирование профиля</h3>
	<div class="row">
		<div class="col-lg-6">
			<form class="form-vertical" enctype="multipart/form-data" role="form" method="post" action="{{ route('profile.edit') }}">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('first_name') ? ' has-error': '' }}">
							<label for="first_name" class="control-label">Имя</label>
							<input type="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
							@if ($errors->has('first_name'))
							<span class="help-block">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('last_name') ? ' has-error': '' }}">
							<label for="last_name" class="control-label">Фамилия</label>
							<input type="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
							@if ($errors->has('last_name'))
							<span class="help-block">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="form_group{{ $errors->has('location') ? ' has-error': '' }}">
					<label for="location" class="control-label">Местоположение</label>
					<input type="text" name="location" class="form-control" id="location" value="{{ Request::old('location') ?: Auth::user()->location }}">
					@if ($errors->has('location'))
							<span class="help-block">{{ $errors->first('location') }}</span>
							@endif
				</div>
				<br>
				<div class="form_group{{ $errors->has('guest') ? ' has-error': '' }}">
					<label for="guest" class="control-label">Закрытый профиль</label>
					<br>
					@if ($guestAcc)
					<input type="checkbox" name="guest" id="guest">
					@else
					<input type="checkbox" name="guest" id="guest" checked>
					@endif
				</div>
				</br>
				<div class="form_group{{ $errors->has('avatar') ? ' has-error': '' }}">
					<label for="location" class="control-label">Аватар</label>
					<img class="media-object" src="/uploads/avatars/{{ Request::old('avatar') ?: Auth::user()->avatar }}" style="width: 100px; height: 100px; border-radius: 50%;"><br>
					<input type="file" name="avatar" class="custom-file-input" id="avatar">
					@if ($errors->has('avatar'))
					<span class="help-block">{{ $errors->first('avatar') }}</span>
					@endif
				</div>
				<br>
				<div class="form-group">
					<button tupe="submit" class="btn btn-success">Обновить</button>
				</div>
				<input type="hidden" name="_token" value="{{ Session::token() }}">
			</form>
		</div>
	</div>
@stop