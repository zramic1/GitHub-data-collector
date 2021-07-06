<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FollowersTest extends TestCase
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

        $this->followers = [
            [
              'id' => 1,
              'name' => 'follower1'
            ],
            [
                'id' => 2,
                'name' => 'follower2'
            ]
        ];

    }

    public function test_store_followers_file()
    {
        $path = '/github/' . $this->user->nickname .'/followers.json';
        if(Storage::exists($path))
            Storage::delete($path);

        $this->actingAs($this->user)
            ->post('/followers/', [
                'followers' => $this->followers
            ]);

        Storage::assertExists($path);
    }

    public function test_download_followers_file()
    {
        $this->actingAs($this->user)
            ->get('/followers/download')
            ->assertDownload('followers.json');
    }
}
