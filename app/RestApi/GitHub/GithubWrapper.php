<?php


namespace App\RestApi\GitHub;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class GithubWrapper
{


    /**
     * Method used to return all repositories of the authenticated user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function repositoriesForAuthUser()
    {
        $githubRestApiRoutes = new GithubRestApiRoutes();

        $repositories = $this->makeRequest($githubRestApiRoutes->getRepositoriesRouteForAuthUser(), true);

        return $repositories->collect();
    }

    /**
     * Method used to return all followers of the authenticated user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function followersForAuthUser()
    {
        $githubRestApiRoutes = new GithubRestApiRoutes();

        $followers = $this->makeRequest($githubRestApiRoutes->getFollowersRouteForAuthUser(), true);

        return $followers->collect();
    }

    /**
     * Method used to return all user repositories using a nickname.
     *
     * @param string $nickname
     * @return \Illuminate\Support\Collection
     */
    public function repositories(string $nickname)
    {
        $githubRestApiRoutes = new GithubRestApiRoutes();

        $repositories = $this->makeRequest($githubRestApiRoutes->getRepositoriesRoute($nickname));

        return $repositories->collect();
    }

    /**
     * Method used to create a GET request.
     *
     * @param string $route
     * @param bool $auth
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     */
    private function makeRequest(string $route, bool $auth = false)
    {
        if($auth)
            return Http::withHeaders([
                'Authorization' => 'token ' . Auth::user()->github_token
            ])->get($route);

        return Http::get($route);
    }
}
