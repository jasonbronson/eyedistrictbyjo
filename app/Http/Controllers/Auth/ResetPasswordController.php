<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\PasswordResetModel;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/account/details';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest');
    }

    

    public function showResetForm(Request $request, $token = null)
    {
        
        $email = isset($request->email)?$request->email:null;
        if(empty($email) && isset($token)){
            
            /*$tokenHashed = Hash::make($token);
            dd($tokenHashed);
            $tmp = PasswordResetModel::where('token', $tokenHashed)->first();
            */
            
        }

        return view('account.passwords-reset')->with(
            ['token' => $token, 'email' => $email, 'link' => true, 'checkout' => true]
        );
    }

    

}
