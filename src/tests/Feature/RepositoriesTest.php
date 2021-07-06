<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RepositoriesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositories = [
            [
                'id' => 324862844,
                'name' => 'RI-igra',
                'owner' => 'dpozderac1',
                'language' => 'C#',
                'description' => null
            ]
        ];

    }

    public function test_get_user_repositories()
    {
        $this->get('/repositories?nickname=zramic1')
            ->assertInertia(fn ($assert) => $assert
                ->component('Repository/Index')
                ->has('repositories', 12)
            );
    }

    public function test_store_repositories_file()
    {
        $path = '/github/zramic1/repositories.json';
        if(Storage::exists($path))
            Storage::delete($path);

        $this->post('/repositories/', [
            'repositories' => $this->repositories,
            'nickname' => 'zramic1'
        ]);

        Storage::assertExists($path);
    }

    public function test_download_repositories_file()
    {
        $this->get('/repositories/download/zramic1')
            ->assertDownload('repositories.json');
    }
}
