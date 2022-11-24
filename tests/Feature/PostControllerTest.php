<?php

namespace Tests\Feature;

use Database\Seeders\PostSeeder;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        User::factory()->create();
        $this->seed(PostSeeder::class);

        $response = $this->actingAs(User::first())
            ->get('/post');

        $response->assertJsonCount(10);
    }

    public function testShow()
    {
        User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs(User::first())
            ->get('/post/' . $post->id);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'title' => $post->title,
                'content' => $post->content
            ]);
    }

    public function testStore()
    {
        User::factory()->create();

        $title = 'test title ' . time();
        $content = 'test content ' . time();
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user)
            ->post('/post', [
                'title' => $title,
                'content' => $content,
                'user_id' => $user->id
            ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(Post::class, [
            'title' => $title,
            'user_id' => $user->id
        ]);
    }
}
