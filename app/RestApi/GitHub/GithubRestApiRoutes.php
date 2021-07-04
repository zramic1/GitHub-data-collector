<?php


namespace App\RestApi\GitHub;


class GithubRestApiRoutes
{

    /**
     * A constant that represents the base url for the used REST api.
     */
    const BASE_URL = 'https://api.github.com';


    /**
     * Method used to generate the route that returns all repositories of the authenticated user.
     *
     * @return string
     */
    public function getRepositoriesRouteForAuthUser()
    {
        return self::BASE_URL . '/user/repos';
    }

    /**
     * Method used to generate a route that returns all user repositories using a nickname.
     *
     * @param string $nickname
     * @return string
     */
    public function getRepositoriesRoute(string $nickname)
    {
        return self::BASE_URL . "/users/$nickname/repos";
    }

    /**
     * Method used to generate the route that returns all followers of the authenticated user.
     *
     * @return string
     */
    public function getFollowersRouteForAuthUser()
    {
        return self::BASE_URL . '/user/followers';
    }
}
