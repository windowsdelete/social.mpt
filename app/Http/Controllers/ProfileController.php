<?php

namespace socialmpt\Http\Controllers;

use Auth;
use socialmpt\Models\User;
use Illuminate\Http\Request;
use Image;

class ProfileController extends Controller
{
	public function getProfile($username)
	{
		$user = User::where('username', $username)->first();
		$guest = $user->guestAccept($user);

		if (!$user) {
			abort(404);
		}

		if (!Auth::check()) {
			return redirect()->route('auth.signin');
		}

		$statuses = $user->statuses()->orderBy('created_at', 'desc')->notReply()->get();

		return view('profile.index')->with('user', $user)
		->with('statuses', $statuses)
		->with('authUserIsFriend', Auth::user()->isFriendsWith($user))
		->with('guest', $guest);
	}

	public function getEdit()
	{
		$thuser = Auth::user();
		$guestAcc = $thuser->guestAccept($thuser);
		return view('profile.edit')->with('guestAcc', $guestAcc);
	}

	public function postEdit(Request $request)
	{
		$guser = Auth::user();
		$this->validate($request, [
			'first_name' => 'alpha|max:50',
			'last_name' => 'alpha|max:50',
			'location' => 'max:20',
		]);

		if ($request->guest == "on")
			$guser->guest_accept = '0';
		else
			$guser->guest_accept = '1';

		Auth::user()->update([
			'first_name' => $request->input('first_name'),
			'last_name' => $request->input('last_name'),
			'location' => $request->input('location'),
		]);

		if ($request->hasFile('avatar')) {
			$avatar = $request->file('avatar');
			$filename = time() . '.' . $avatar->getClientOriginalExtension();
			Image::make($avatar)->fit(100, 100)->save(public_path('/uploads/avatars/' . $filename));
			$user = Auth::user();
			$user->avatar = $filename;
			$user->save();
		}

		return redirect()
		->route('profile.edit')
		->with('info', 'Ваш профиль был обновлён!!!');
	}
}