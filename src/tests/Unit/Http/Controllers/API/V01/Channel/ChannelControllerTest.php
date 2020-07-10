<?php

namespace Tests\Unit\Http\Controllers\API\V01\Channel;

use App\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test All Channels List
     */
    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));

        $response->assertStatus(200);
    }

    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'),[]);

        $response->assertStatus(422);
    }

    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channel.create'),[
            'name' => 'Laravel'
        ]);

        $response->assertStatus(201);
    }
}
