<?php

namespace BookStack\Http\Controllers\Auth;

use BookStack\Auth\User as AuthUser;
use BookStack\Http\Controllers\ActivityLogController;
use BookStack\Models\User;
use BookStack\Models\Group;
use Illuminate\Http\Request;
use League\OAuth2\Client\Token;
use BookStack\Http\Controllers\OAuthController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use BookStack\Http\Controllers\Controller;

/**
 * This controller handles authenticating users for the application and
 * redirecting them to your home screen. The controller uses a trait
 * to conveniently provide its functionality to your applications.
 */
class OauthLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $provider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->provider = new OAuthRootController();
    }

    /**
     * Login the user
     * 
     * @param \Illuminate\Http\Request $request request to proccess
     * @return mixed
     */
    public function login(Request $request)
    {
        if (! $request->has('code') || ! $request->has('state')) {
            $authorizationUrl = $this->provider->getAuthorizationUrl(); // Generates state
            $request->session()->put('oauthstate', $this->provider->getState());
			return redirect()->away($authorizationUrl);
        } else if ($request->input('state') !== session()->pull('oauthstate')) {
            return redirect()->route('front')->withError("Something went wrong, please try again (state mismatch).");
        } else {
            return $this->verifyLogin($request);
        }
    }

    /**
     * Verify the login of the user's request before proceeding
     * 
     * @param \Illuminate\Http\Request $request request to proccess
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function verifyLogin(Request $request)
    {
        try {
            $accessToken = $this->provider->getAccessToken('authorization_code', [
                'code' => $request->input('code')
            ]);
            
        } catch (IdentityProviderException $e) {
            return redirect()->route('front')->withError("Authentication error: ".$e->getMessage());
        }
        $resourceOwner = json_decode(json_encode($this->provider->getResourceOwner($accessToken)->toArray()));

        if (!isset($resourceOwner->data->cid)) {
            return redirect()->route('authorize.login')->withError("You did not grant all data which is required to use this service.");
        }

        $account = $this->completeLogin($resourceOwner, $accessToken);

        // Login the user and don't remember the session forever
        auth()->login($account, false);

        // $authLevel = "User";
        // if(\Auth::user()->groups->count() > 0){
        //     $authLevel = User::find(\Auth::user()->id)->groups->sortBy('id')->first()->name;
        //     ActivityLogController::warning('ACCESS', "Logged in with ".$authLevel." access");
        // } else {
        //     ActivityLogController::info('ACCESS', "Logged in with ".$authLevel." access");
        // }

        

        return redirect()->intended(route('/'))->withSuccess('Login Successful');
    }

    /**
     * Complete the login by creating or updating the existing account and last login timestamp
     * 
     * @param mixed $resourceOwner
     * @param mixed $token
     * @return \App\Models\User User's account data
     */
    protected function completeLogin($resourceOwner, $token)
    {
        $account = AuthUser::updateOrCreate(
            ['id' => $resourceOwner->data->cid]
        );

        $account->save();

        return $account;
    }

    /**
     * Log out he user and redirect to front page
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // ActivityLogController::info('ACCESS', "Logged out.");
        auth()->logout();

        return redirect(route('login'))->withSuccess('You have been successfully logged out');
    }
}