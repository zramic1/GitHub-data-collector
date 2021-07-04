<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class GithubLoginController extends Controller
{


    /**
     * Method used to display the login form.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Method that redirects Inertia request.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function loginRedirect()
    {
        return response('', 409)
            ->header('X-Inertia-Location', env('APP_URL') . '/github/redirect');
    }

    /**
     * Method that redirects the user to the OAuth provider.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Method for receiving the callback from the provider after authentication.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('email', $githubUser->email)->first();
        if(!$user) {
            $user = new User();
            $user->fill([
                'nickname' => $githubUser->nickname,
                'email' => $githubUser->email,
                'github_token' => $githubUser->token
            ]);
            $user->save();
        }
        else
            $user->update([
                'github_token' => $githubUser->token
            ]);

        Auth::login($user);

        return Redirect::route('web.home');
    }

    /**
     * Method for user logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        User::find(Auth::user()->id)->update([
            'github_token' => null
        ]);

        Auth::logout();

        return Redirect::route('web.home');
    }
}
