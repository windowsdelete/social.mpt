@extends('templates.default')

@section('content')
<div class="row">
	<div class="col-lg-5">
		@include('user.partials.userblock')
		<hr>
	@if ($guest || $authUserIsFriend || Auth::user()->id === $user->id)
		@if (!$statuses->count())
	        	<p>Здесь пусто!</p>
	        @else
	        	@foreach ($statuses as $status)
	        		<div class="media">
    <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
        <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="/uploads/avatars/{{ $user->avatar }}" style="width: 45px; height: 45px; border-radius: 50%;">
    </a>
    <div class="media-body">
        <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
        <p>{{ $status->body }}
        	@if ($status->picture)
        	<img class="media-object" src="/uploads/statuses/{{ $status->picture }}">
        	@endif
        </p>
        <ul class="list-inline">
            <li>{{ $status->created_at->format('d.m.Y H:i') }}</li>
            @if ($status->user->id === Auth::user()->id)
            <li><a href="{{ route('status.delete', ['statusId' => $status->id]) }}" style="text-decoration: none;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></li>
            @endif
            @if ($status->user->id !== Auth::user()->id)
                <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}" style="text-decoration: none;">&#128153;</a></li>
                @endif
            <li>Количество лайков: {{ $status->likes->count() }}</li>
        </ul>

        @foreach ($status->replies as $reply)
	        <div class="media">
	            <a class="pull-left" href="{{ route('profile.index', ['username' => $reply->user->username]) }}">
	                <img class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" src="/uploads/avatars/{{ $reply->user->avatar }}" style="width: 45px; height: 45px; border-radius: 50%;">
	            </a>
	            <div class="media-body">
	                <h5 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
	                <p>{{ $reply->body }}</p>
	                <ul class="list-inline">
	                    <li>{{ $reply->created_at->format('d.m.Y H:i') }}</li>
	                    @if ($reply->user->id === Auth::user()->id)
			            <li><a href="{{ route('status.delete', ['statusId' => $reply->id]) }}" style="text-decoration: none;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></a></li>
			            @endif
	                    @if ($reply->user->id !== Auth::user()->id)
	                    <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}" style="text-decoration: none;">&#128153;</a></li>
	                    @endif
	                    <li>Количество лайков: {{ $reply->likes->count() }}</li>
	                </ul>
	            </div>
	        </div>
        @endforeach

        @if ($authUserIsFriend || Auth::user()->id === $status->user->id)
	        <form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
	            <div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error': '' }}">
	                <textarea name="reply-{{ $status->id }}" class="form-control" rows="2" placeholder="Ответить на запись" style="resize: none;"></textarea>
	                @if ($errors->has("reply-{$status->id}"))
	                	<span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
	                @endif
	            </div>
	            <input type="submit" value="Ответить" class="btn btn-default btn-sm">
	            <input type="hidden" name="_token" value="{{ Session::token() }}">
	        </form>
        @endif
    </div>
</div>
	        	@endforeach
	        @endif

	        @else
	        <p>Этот профиль скрыт.</p>
	  @endif
	</div>
	<div class="col-lg-4 col-lg-offset-3">

		@if (Auth::user()->hasFriendRequestPending($user))
	 				<p>Заявка на дружбу была отправлена.</p>
	 			@elseif (Auth::user()->hasFriendRequestReceived($user))
	 				<a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-success">Принять запрос дружбы</a>
	 			@elseif (Auth::user()->isFriendsWith($user))
	 				<p>У вас в друзьях.</p>

	 				<form action="{{ route('friend.delete', ['username' => $user->username]) }}" method="post">
	 					<input type="submit" value="Удалить из друзей" class="btn btn-danger">
	 					<input type="hidden" name="_token" value="{{ csrf_token() }}">
	 				</form>
	 			@elseif(Auth::user()->id !== $user->id)
	 				<a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-success">Добавить в друзья</a>

	 			@endif

		<h4>Друзья</h4>


		@if (!$user->friends()->count())
			<p>Список друзей пуст.</p>
		@else
			@foreach($user->friends() as $user)
				@include('user/partials/userblock')
			@endforeach
		@endif
	</div>
</div>
@stop