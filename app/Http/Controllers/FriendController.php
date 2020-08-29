<?php

namespace socialmpt\Http\Controllers;

use Auth;
use Mail;
use socialmpt\Models\User;
use Illuminate\Http\Request;

class FriendController extends Controller
{
	public function getIndex()
	{
		$friends = Auth::user()->friends();
		$requests = Auth::user()->friendRequests();
		return view('friends.index')->with('friends', $friends)->with('requests', $requests);
	}

	public function getAdd($username)
	{
		$user = User::where('username', $username)->first();
		if (!$user) {
			return redirect()->route('home')->with('info', 'Пользователь не найден!!!');
		}

		if (Auth::user()->id === $user->id) {
			return redirect()->route('home');
		}

		if (Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user())) {
			return redirect()->route('profile.index', ['username' => $user->username])->with('info', 'Запрос на дружбу уже отправлен!!!');
		}

		if (Auth::user()->isFriendsWith($user)) {
			return redirect()->route('profile.index', ['username' => $user->username])->with('info', 'Данный пользователь уже есть в вашем списке друзей.');
		}

		Auth::user()->addFriend($user);

		Mail::send(['text' => 'mail.friendadd'], ['name', 'SocialMPT'], function ($message){
			$message->to(Auth::user()->email, Auth::user()->username)->subject('Оповещение!!!');
			$message->from('callmejamesbond6@gmail.com', 'SocialMPT');
		});

		return redirect()->route('profile.index', ['username' => $username])->with('info', 'Запрос на дружбу отправлен.');
	}

	public function getAccept($username)
	{
		$user = User::where('username', $username)->first();

		if (!$user) {
			return redirect()->route('home')->with('info', 'Пользователь не найден!!!');
		}

		if (!Auth::user()->hasFriendRequestReceived($user)) {
			return redirect()->route('home');
		}

		Auth::user()->acceptFriendRequest($user);

		return redirect()->route('profile.index', ['username' => $username])->with('info', 'Запрос на дружбу принят!!!');
	}

	public function postDelete($username)
	{
		$user = User::where('username', $username)->first();

		if (!Auth::user()->isFriendsWith($user)) {
			return redirect()->back();
		}

		Auth::user()->deleteFriend($user);

		return redirect()->back()->with('info', 'Друг был удалён!!!');
	}
}