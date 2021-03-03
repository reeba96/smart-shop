<?php

namespace Webkul\Customer\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_config = request('_config');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function create($token = null)
    {
        return view($this->_config['view'])->with(
            ['token' => $token, 'email' => request('email')]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //try {
            $data = $this->validate(request(), [
                'token'    => 'required',
                'email'    => 'required|email',
                'password' => 'required|confirmed|min:6',
            ]);

            $formdata = [];
            $formdata['hash'] = Hash::make($data['password']);
            $formdata['email'] = $data['email'];
    
            $client = new \GuzzleHttp\Client();
            $api_url = config('app.bodywave_api').'shop_change_password';
    
            $token = config('app.bodywave_token');
    
            $headers = [
                'Authorization' => 'Bearer ' . $token,        
                'Accept'        => 'application/json',
            ];
            
            $res = $client->request('post',$api_url, [
                'headers' => $headers,
                'form_params' => $formdata
            ]);
         
            $result = json_decode($res->getBody()->getContents());
            if ($result->status =='OK'){
                return redirect()->route($this->_config['redirect']);    
            }
            
    
        /*    $response = $this->broker()->reset(
                request(['email', 'password', 'password_confirmation', 'token']), function ($customer, $password) {
                    $this->resetPassword($customer, $password);
                }
            );

            if ($response == Password::PASSWORD_RESET) {
                return redirect()->route($this->_config['redirect']);
            }
*/
            return back()
                ->withInput(request(['email']))
                ->withErrors([
                    'email' => trans($response),
                ]);
      /*  } catch(\Exception $e) {
            session()->flash('error', trans($e->getMessage()));

            return redirect()->back();
        }*/
    }

    /**
     * Reset the given customer password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $customer
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($customer, $password)
    {
        
        $formdata = [];
        $formdata['hash'] = Hash::make($password);

        $client = new \GuzzleHttp\Client();
        $api_url = config('app.bodywave_api').'/changePassword';

        $token = config('app.bodywave_token');

        $headers = [
            'Authorization' => 'Bearer ' . $token,        
            'Accept'        => 'application/json',
        ];
        
        $res = $client->request('post',$api_url, [
            'headers' => $headers,
            'form_params' => $formdata
        ]);

        $customer->setRememberToken(Str::random(60));

        $customer->save();

        event(new PasswordReset($customer));

        auth()->guard('customer')->login($customer);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('customers');
    }

}