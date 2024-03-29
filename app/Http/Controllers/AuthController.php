<?php

namespace socialmpt\Http\Controllers;

use Auth;
use socialmpt\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	public function getSignup()
	{
		return view('auth.signup');
	}

	public function postSignup(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|unique:users|email|max:255',
			'username' => 'required|unique:users|alpha_dash|max:20',
			'password' => 'required|min:8',
		]);

		User::create([
			'email' => $request->input('email'),
			'username' => $request->input('username'),
			'password' => bcrypt($request->input('password')),
		]);

		return redirect()
		->route('home')
		->with('info', 'Аккаунт был создан и вы можете зайти!!!');
	}

	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
		]);

		if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
			return redirect()->back()->with('info', 'Неверный email или пароль!!!');
		}

		return redirect()->route('home')->with('info', 'Вы были успешно авторизованы!!!');
	}

	public function getSignout()
	{
		Auth::logout();
		return redirect()->route('home');
	}
}