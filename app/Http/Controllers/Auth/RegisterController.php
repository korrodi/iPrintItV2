<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'department_id' => 'required',
            'phone' => 'required',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        /* Waiting for email approvel
        'blocked' => -1 */
        $user = new User;
        $user->name = $data['name'];
        $user->email= $data['email'];
        $user->password = bcrypt($data['password']);
        $user->department_id = $data['department_id'];
        $user->phone = $data['phone'];
        $user->password = bcrypt($data['password']);
        $user->print_evals = 0;
        $user->print_counts = 0;
        $user->admin = 0;
        $user->blocked = -1;

        
        $user->save();
        var_dump($user);
        /*$user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'department_id' => $data['department_id'],
            'phone' => $data['phone'],
            'admin' => 0,
            'blocked' => -1,
            'print_evals' => 0,
            'print_counts' => 0,
        ]);*/
        /* Send Email */
        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', '');

            $m->to($user->email, $user->name)->subject('Confirm your account!');
        });

        return $user;
    }
}