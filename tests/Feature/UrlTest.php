<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_the_application_create_url_data_successful(): void {
        $url = Url::create([
            'realUrl' => 'example.com/testUrl',
            'hashUrl' => 'example.com/cvbgyy',
        ]);

        $this->assertModelExists($url);
    }

    public function test_the_application_post_new_url_data_successful(): void {
        $response = $this->post('/sendUrl', ['url' => 'example.com/testUrl']);

        $response->assertStatus(302);
    }
}
