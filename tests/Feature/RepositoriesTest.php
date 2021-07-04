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

        $this->user = User::where('nickname', 'zramic1')->first();
        if(!$this->user)
            $this->user = User::create([
                'nickname' => 'zramic1',
                'email' => 'zerina.ramic@live.com',
                'github_token' => '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'
            ]);

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
        $this->actingAs($this->user)
            ->get('/repositories/')
            ->assertInertia(fn ($assert) => $assert
                ->component('Repository/Index')
                ->has('repositories', 14)
                ->has('repositories.0', fn ($assert) => $assert
                    ->where('id', 247773271)
                    ->where('name', 'Mockup-Tool-Drive')
                    ->where('owner', 'dpozderac1')
                    ->where('language', 'JavaScript')
                    ->where('description', null)
                )
                ->has('repositories.1', fn ($assert) => $assert
                    ->where('id', 324862844)
                    ->where('name', 'RI-igra')
                    ->where('owner', 'dpozderac1')
                    ->where('language', 'C#')
                    ->where('description', null)
                )
                ->has('repositories.2', fn ($assert) => $assert
                    ->where('id', 284677165)
                    ->where('name', 'Face-clustering')
                    ->where('owner', 'zramic1')
                    ->where('language', 'Python')
                    ->where('description', null)
                )
            );
    }

    public function test_store_repositories_file()
    {
        $path = '/github/' . $this->user->nickname .'/repositories.json';
        if(Storage::exists($path))
            Storage::delete($path);

        $this->actingAs($this->user)
            ->post('/repositories/', [
                'repositories' => $this->repositories
            ]);

        Storage::assertExists($path);
    }

    public function test_download_repositories_file()
    {
        $this->actingAs($this->user)
            ->get('/repositories/download')
            ->assertDownload('repositories.json');
    }
}
