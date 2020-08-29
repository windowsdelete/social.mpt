<?php

namespace socialmpt\Http\Controllers;

use Auth;
use socialmpt\Models\User;
use socialmpt\Models\Status;
use Illuminate\Http\Request;
use Image;

class StatusController extends Controller
{
	public function postStatus(Request $request) {
		$this->validate($request, [
			'status' => 'required|max:120',
		]);

		$status = Auth::user()->statuses()->create([
			'body' => $request->input('status'),
		]);

		if ($request->hasFile('picture')) {
			$picture = $request->file('picture');
			$filename = time() . '.' . $picture->getClientOriginalExtension();
			Image::make($picture)->fit(400, 300)->save(public_path('/uploads/statuses/' . $filename));
			$status->picture = $filename;
			$status->save();
		}

		return redirect()->route('home')->with('info', 'Запись успешно добавлена!!!');
	}

	public function postReply(Request $request, $statusId)
	{
		$this->validate($request, [
			"reply-{$statusId}" => 'required|max:120',
		], [
			'required' => 'Вы ничего не написали!!!'
		]);
		
		$status = Status::notReply()->find($statusId);

		if (!$status){
			return redirect()->route('home');
		}

		if (!Auth::user()->isFriendsWith($status->user) && Auth::user()->id !== $status->user->id) {
			return redirect()->route('home');
		}

		$reply = Status::create([
			'body' => $request->input("reply-{$statusId}"),
		])->user()->associate(Auth::user());

		$status->replies()->save($reply);

		return redirect()->back();
	}

	public function getLike($statusId)
	{
		$status = Status::find($statusId);

		if (!$status) {
			return redirect()->route('home');
		}

		if (!Auth::user()->isFriendsWith($status->user)) {
			return redirect()->route('home');
		}

		if(Auth::user()->hasLikedStatus($status)) {
			return redirect()->back();
		}

		$like = $status->likes()->create([]);
		Auth::user()->likes()->save($like);

		return redirect()->back();
	}

	public function getDelete ($statusId)
	{
		$status = Status::find($statusId);

		if (!$status) {
			return redirect()->route('home');
		}

		if (Auth::user()->id !== $status->user->id)
		{
			return redirect()->route('home');
		}

		$status->delete();
		return redirect()->back();
	}
}