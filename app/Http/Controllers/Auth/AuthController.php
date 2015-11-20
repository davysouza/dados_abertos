<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Session;
use App\Http\Requests;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Contracts\Auth\Guard;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/auth/login';

    /**
     * the model instance
     * @var User
     */
    protected $user;

    /**
     * The Guard implementation.
     *
     * @var Authenticator
     */
    protected $auth;

    /**
     * Create a new authentication controller instance.
     *
     * @param  Authenticator  $auth
     * @return void
     */
    public function __construct(Guard $auth, User $user) {
        $this->user = $user;
        $this->auth = $auth;

        $this->middleware('guest', ['except' => ['getLogout']]);
    }

    /**
     * Show the application registration form.
     *
     * @return Response
     */
    public function getRegister() {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return Response
     */
    public function postRegister(RegisterUserRequest $request) {
        $this->create($request->all());
        return redirect($this->redirectPath());
    }

    /**
     * Show the application login form.
     *
     * @return Response
     */
    public function getLogin() {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postLogin(LoginUserRequest $request) {
        // Option remember user...
        $remember = false;
        if($request['remember']) {
            $remember = true;
        }

        if ($this->auth->attempt($request->only('email', 'password'), $remember)) {
            $name = User::selectRaw('name')->where('email', $request['email'])->get();
            $id = User::selectRaw('id')->where('email', $request['email'])->get();
            Session::put('name',$name[0]['name']);
            Session::put('isLogged', true);
            return redirect('user');
        }

        return redirect('/auth/login')->withErrors([
            'email' => 'The credentials you entered did not match our records. Try again?',
        ]);
    }

    /**
     * Log the user out of the application.
     *
     * @return Response
     */
    public function getLogout() {
        $this->auth->logout();
        Session::flush();
        return redirect('/');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    private function redirectPath() {
        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
