<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Http\Response;

class SiteController extends Controller
{
    
    /**
     * Form login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect('/panel');
        }        
        
        return view('site.login');
    }
    
    /**
    * Sing in.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        
        $http = new Client(['base_uri'=>'http://api.lobeliaservices.com.dev/api/v1/']);
        $response = $http->post('auth/login', [
            'body' => json_encode([
                'email' => $request->email,
                'password' => $request->password,
                'remember_me'=>$request->remember_me??null
            ]),
            'headers'=>[
                'Content-Type'=>'application/json',
                'X-Requested-With'=>'XMLHttpRequest'
            ],
            'version'=>'v1'
        ]);
        
        
        if($response->getStatusCode() == 200)
        {         
            
            $credentials = request(['email', 'password']);
            
            if (Auth::attempt($credentials, $request->remember_me)){
                
                $data = json_decode((string) $response->getBody(), true);
                $cookie = $this->setCookie($request,'api-cookie', $data['access_token']);            
                
                return redirect('/panel')->withCookie($cookie);
            }
            
            
        }        
        
        return redirect('/');
        
    }
    
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    
    public function getCookie($key){
        $value = request::cookie('name');
        echo $value;
    }
    
    
    
    protected function setCookie(Request $request, $key, $value, $time = false){
        $minutes = $time ?? 30;
        return $request->cookie($key, $value, $minutes);
    }
    
    
    
    
    public function panel(Request $request)
    {
        $clients = \Laravel\Passport\Client::where('user_id', Auth::user()->id)->get();
        return view('site.index', compact('clients'));
    }    
    
    
    
    public function new(Request $request)
    {
        $returnHTML = view('site.form')->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    
    
    
    public function edit(Request $request)
    {
        $client = \Laravel\Passport\Client::findOrFail($request->get('userid'));
        //dd($request->get('userid'));
        $returnHTML = view('site.edit')->with('client', $client)->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }
    
    
}
