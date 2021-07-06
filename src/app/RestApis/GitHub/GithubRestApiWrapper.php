<?php


namespace App\RestApis\GitHub;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GithubRestApiWrapper
{
    /**
     * Method used to return all followers of the authenticated user.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function followersForAuthenticatedUser()
    {
        $route = GithubRestApiRoutes::getFollowersRouteForAuthenticatedUser();
        $followers = self::makeGetRequest($route, true);

        return $followers->collect();
    }

    /**
     * Method used to return all user repositories using a nickname.
     *
     * @param string $nickname
     * @return \Illuminate\Support\Collection
     */
    public static function repositories(string $nickname)
    {
        $route = GithubRestApiRoutes::getRepositoriesRoute($nickname);
        $response = self::makeGetRequest($route)->collect();
        $repositories = collect();

        if(!$response->get('message'))
            $repositories = $response->collect();

        return $repositories;
    }

    /**
     * Method used to create a GET request.
     *
     * @param string $route
     * @param bool $auth
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private static function makeGetRequest(string $route, bool $auth = false)
    {
        $headers = [];

        if($auth)
            $headers = [
                'Authorization' => 'token ' . Auth::user()->github_token
            ];

        return Http::withHeaders($headers)->get($route);
    }
}
