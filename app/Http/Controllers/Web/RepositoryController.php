<?php

namespace App\Http\Controllers\Web;

use App\RestApi\GitHub\GithubWrapper;
use App\Storage\StorageFileHandler;
use App\Storage\StorageFilePathGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class RepositoryController extends Controller
{

    /**
     * Method used to return repositories.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $githubWrapper = new GithubWrapper();

        $repositories = Auth::user() ? $githubWrapper->repositoriesForAuthUser() : collect();
        if($request->exists('nickname')) {
            if(Session::exists('nickname'))
                Session::forget('nickname');
            Session::put('nickname', $request->get('nickname'));

            $repositories = $githubWrapper->repositories($request->get('nickname'));
        }

        if(isset($repositories['message']))
            $repositories = collect();

        $repositories = $repositories->map(function ($repository) {
           return [
               'id' => $repository['id'],
               'name' => $repository['name'],
               'owner' => $repository['owner']['login'],
               'language' => $repository['language'],
               'description' => $repository['description']
           ];
        });

        $path = $this->generatePath();

        return Inertia::render('Repository/Index', [
            'repositories' => $repositories,
            'fileExists' => Storage::exists($path),
            'userNickname' => $request->get('nickname')
        ]);
    }

    /**
     * Method used to store repositories into JSON file.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $storageFileHandler = new StorageFileHandler();
        $path = $this->generatePath();

        return $storageFileHandler->storeFile($path, json_encode($request->get('repositories'), JSON_PRETTY_PRINT));

    }

    /**
     * Method used to download repositories that are stored in a JSON file.
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
     * @return string|null
     */
    private function generatePath()
    {
        $storageFilePathGenerator = new StorageFilePathGenerator();
        $nickname = Auth::user() ? Auth::user()->nickname : Session::get('nickname');

        return $nickname ? $storageFilePathGenerator->path($nickname, 'repositories.json') : null;
    }
}
