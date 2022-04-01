<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\Setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login(Request $request)
    // {
    //     $this->validate(
    //         $request, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //         ]
    //     );

    //     $user = User::where(['email' => $request->email])->first();

    //     if (auth()->guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
    //         Auth::login($user);
    //         $ua = $request->server('HTTP_USER_AGENT');
    //         LoginHistory::create([
    //             'user_id' => $user->id,
    //             'user_agent' => $ua
    //         ]);
    //         if ($user->designation_id == 1) {
    //             return redirect('/dashboard');
    //         }
    //         return redirect('/sales-pos');
    //     } else {
    //         Auth::logout();
    //         return Redirect::back()->withErrors(['These credentials do not match our records.']);
    //     }


    // }

    public function showLoginForm()
    {
        if (auth()->user()) {
            return redirect('/dashboard');
        }

        $banner = Setting::where('attribute', 'banner')->first();
        $app = Setting::where('attribute', 'app_name')->first();
        $logo = Setting::where('attribute', 'logo')->first();

        return view('auth.login', compact('banner', 'app', 'logo'));
    }

    public function login(Request $request)
    {   
        $input = $request->all();
  
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            $user = User::where([$fieldType => $request->username])->first();
            if ($user->designation_id === 1) {
                return redirect('/dashboard');
            }
            return redirect('/sales-pos');
        } else {
            return Redirect::back()
                ->withErrors(['These credentials do not match our records.']);
        }
          
    }


}
