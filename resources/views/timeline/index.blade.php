@extends('templates.default')

@section('content')
	<div class="row">
	    <div class="col-lg-6">
	        <form role="form" enctype="multipart/form-data" action="{{ route('status.post') }}" method="post">
	            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
	                <textarea placeholder="Что у вас нового?" name="status" class="form-control" rows="4" style="resize: none;"></textarea>
	                @if ($errors->has('status'))
	                	<span class="help-block">{{ $errors->first('status') }}</span>
	                @endif
	            </div>
	            <input type="file" name="picture" class="custom-file-input" id="picture">
	            <br>
	            <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Запостить</button>
	            <input type="hidden" name="_token" value="{{ Session::token() }}">
	        </form>
	        <hr>
	    </div>
	</div>

	<div class="row">
	    <div class="col-lg-5">
	        @if (!$statuses->count())
	        	<p>Здесь пусто! Но вы можете это исправить :)</p>
	        @else
	        	@foreach ($statuses as $status)
	        		<div class="media">
    <a class="pull-left" href="{{ route('profile.index', ['username' => $status->user->username]) }}">
        <img class="media-object" alt="{{ $status->user->getNameOrUsername() }}" src="/uploads/avatars/{{ $status->user->avatar }}" style="width: 45px; height: 45px; border-radius: 50%;">
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
            <li><a href="{{ route('status.delete', ['statusId' => $status->id]) }}" style="text-decoration: none;"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></a></li>
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
	                    <!-- diffForHumans() -->
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
    </div>
</div>
	        	@endforeach

	        	{!! $statuses->render() !!}
	        @endif
	    </div>
	</div>
@stop