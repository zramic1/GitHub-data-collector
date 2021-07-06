<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Follower\StoreFollowerRequest;
use App\RestApis\GitHub\GithubRestApiWrapper;
use App\StorageHelpers\StorageFileHandler;
use App\StorageHelpers\StorageFilePathGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $followers = GithubRestApiWrapper::followersForAuthenticatedUser()->map(function ($follower) {
            return [
                'id' => $follower['id'],
                'name' => $follower['login']
            ];
        });

        return Inertia::render('Follower/Index', [
            'followers' => $followers,
            'fileExists' => $this->fileExistsForAuthenticatedUser()
        ]);
    }

    /**
     * Method used to store followers into JSON file.
     *
     * @param StoreFollowerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreFollowerRequest $request)
    {
        $validatedData = $request->validated();

        $path = $this->generatePath();
        StorageFileHandler::storeFile($path, json_encode($validatedData['followers'], JSON_PRETTY_PRINT));

        return Redirect::back()->with('success', 'Changes saved successfully!');
    }

    /**
     * Method used to download followers that are stored in a JSON file.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download()
    {
        if(!$this->fileExistsForAuthenticatedUser())
            abort(404);

        $path = $this->generatePath();

        return StorageFileHandler::downloadFile($path);
    }

    /**
     * Method used to generate a path to the JSON file.
     *
     * @return string
     */
    private function generatePath()
    {
        return StorageFilePathGenerator::path(Auth::user()->nickname, 'followers.json');
    }

    /**
     * Method used to check if followers.json file exists for authenticated user.
     *
     * @return bool
     */
    private function fileExistsForAuthenticatedUser()
    {
        $path = $this->generatePath();

        return Storage::exists($path);
    }
}
