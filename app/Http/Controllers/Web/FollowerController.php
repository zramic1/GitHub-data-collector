<?php

namespace App\Http\Controllers\Web;

use App\RestApi\GitHub\GithubWrapper;
use App\Storage\StorageFileHandler;
use App\Storage\StorageFilePathGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class FollowerController extends Controller
{

    /**
     * Method used to return followers.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $githubWrapper = new GithubWrapper();

        $followers = $githubWrapper->followersForAuthUser()->map(function ($follower) {
            return [
                'id' => $follower['id'],
                'name' => $follower['login']
            ];
        });

        $path = $this->generatePath();

        return Inertia::render('Follower/Index', [
            'followers' => $followers,
            'fileExists' => Storage::exists($path)
        ]);
    }

    /**
     * Method used to store followers into JSON file.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $storageFileHandler = new StorageFileHandler();
        $path = $this->generatePath();

        return $storageFileHandler->storeFile($path, json_encode($request->get('followers'), JSON_PRETTY_PRINT));
    }

    /**
     * Method used to download followers that are stored in a JSON file.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download()
    {
        $storageFileHandler = new StorageFileHandler();
        $path = $this->generatePath();

        return $storageFileHandler->downloadFile($path);
    }

    /**
     * Method used to generate a path to the JSON file.
     *
     * @return string
     */
    private function generatePath()
    {
        $storageFilePathGenerator = new StorageFilePathGenerator();

        return $storageFilePathGenerator->path(Auth::user()->nickname, 'followers.json');
    }
}
