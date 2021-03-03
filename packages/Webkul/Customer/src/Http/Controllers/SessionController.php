<?php

namespace Webkul\Customer\Http\Controllers;

use Illuminate\Support\Facades\Event;
use Cookie;
use Illuminate\Support\Facades\Hash;
use Webkul\Customer\Models\Customer;
use Illuminate\Support\Facades\Auth;
class SessionController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * Create a new Repository instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('customer')->except(['show','create']);

        $this->_config = request('_config');
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('customer.profile.index');
        } else {
            return view($this->_config['view']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->validate(request(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        
        $client = new \GuzzleHttp\Client();
        $api_url = config('app.bodywave_api').'/shop_get_hash';

        $token = config('app.bodywave_token');

        $headers = [
            'Authorization' => 'Bearer ' . $token,        
            'Accept'        => 'application/json',
        ];

        $res = $client->request('post',$api_url, [
            'headers' => $headers,
            'form_params' => ['email' => $data['email']]
        ]);

        $result = json_decode($res->getBody()->getContents());
//dd($result->hash);
//dd($data['password'],Hash::check($data['password'], $result->hash));
        if (Hash::check($data['password'], $result->hash)) {
            
            $user = Customer::where('email',$data['email'])->first();

            if ( $user){
                auth()->guard('customer')->login($user);
                Event::dispatch('customer.after.login', request('email'));
                return redirect()->intended(route($this->_config['redirect']));
            }
        }
        else{
            session()->flash('error', trans('shop::app.customer.login-form.invalid-creds'));

            return redirect()->back();
        }
      /*  if (! auth()->guard('customer')->attempt(request(['email', 'password']))) {
            session()->flash('error', trans('shop::app.customer.login-form.invalid-creds'));

            return redirect()->back();
        }

        if (auth()->guard('customer')->user()->status == 0) {
            auth()->guard('customer')->logout();

            session()->flash('warning', trans('shop::app.customer.login-form.not-activated'));

            return redirect()->back();
        }

        if (auth()->guard('customer')->user()->is_verified == 0) {
            session()->flash('info', trans('shop::app.customer.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', request('email'), 1));

            auth()->guard('customer')->logout();

            return redirect()->back();
        }

        //Event passed to prepare cart after login
        Event::dispatch('customer.after.login', request('email'));

        return redirect()->intended(route($this->_config['redirect']));*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        auth()->guard('customer')->logout();

        Event::dispatch('customer.after.logout', $id);

        return redirect()->route($this->_config['redirect']);
    }
}