@extends('templates.default')

@section('content')
		 <div class="row">
	 	<div class="col-lg-6">
	 		<h3>Друзья</h3>
			 	@if (!$friends->count())
					<p>Список друзей пуст.</p>
				@else
					@foreach($friends as $user)
						@include('user/partials/userblock')
					@endforeach
				@endif
	 	</div>
	 	<div class="col-lg-6">
	 		<h4>Запросы на дружбу</h4>
	 		@if (!$requests->count())
	 			<p>Нет активных заявок в друзья.</p>
	 		@else
	 			@foreach ($requests as $user)
	 				@include('user.partials.userblock')
	 			@endforeach
	 		@endif
	 	</div>
	 </div>
@stop