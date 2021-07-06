<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Repository\StoreRepositoryRequest;
use App\RestApis\GitHub\GithubRestApiWrapper;
use App\StorageHelpers\StorageFileHandler;
use App\StorageHelpers\StorageFilePathGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
        $repositories = collect();

        if($nickname = $request->get('nickname'))
            $repositories = GithubRestApiWrapper::repositories($nickname);

        $repositories = $repositories->map(function ($repository) {
           return [
               'id' => $repository['id'],
               'name' => $repository['name'],
               'owner' => $repository['owner']['login'],
               'language' => $repository['language'],
               'description' => $repository['description']
           ];
        });

        return Inertia::render('Repository/Index', [
            'repositories' => $repositories,
            'fileExists' => $this->fileExistsForNickname($nickname),
            'userNickname' => $request->get('nickname')
        ]);
    }

    /**
     * Method used to store repositories into JSON file.
     *
     * @param StoreRepositoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRepositoryRequest $request)
    {
        $validatedData = $request->validated();

        $path = $this->generatePath($validatedData['nickname']);
        StorageFileHandler::storeFile($path, json_encode($validatedData['repositories'], JSON_PRETTY_PRINT));

        return Redirect::back()->with('success', 'Changes saved successfully!');
    }

    /**
     * Method used to download repositories that are stored in a JSON file.
     *
     * @param string $nickname
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(string $nickname)
    {
        if(!$this->fileExistsForNickname($nickname))
            abort(404);

        $path = $this->generatePath($nickname);

        return StorageFileHandler::downloadFile($path);
    }

    /**
     * Method used to generate a path to the JSON file.
     *
     * @return string|null
     */
    private function generatePath(string $nickname = null)
    {
        return StorageFilePathGenerator::path($nickname, 'repositories.json');
    }

    /**
     * Method used to check if repositories.json file exists for given nickname.
     *
     * @param string|null $nickname
     * @return bool
     */
    private function fileExistsForNickname(string $nickname = null)
    {
        if(!$nickname)
            return false;

        $path = $this->generatePath($nickname);

        return Storage::exists($path);
    }
}
