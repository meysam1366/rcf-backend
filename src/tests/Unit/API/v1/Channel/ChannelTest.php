<?php

namespace Tests\Unit\API\v1\Channel;

use App\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test All Channels List
     */
    public function test_all_channels_list_should_be_accessible()
    {
        $response = $this->get(route('channel.all'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_channel_should_be_validated()
    {
        $response = $this->postJson(route('channel.create'),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_channel()
    {
        $response = $this->postJson(route('channel.create'),[
            'name' => 'Laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }
    
    /**
     * Test Update Channel
     */
    public function test_channel_update_should_be_validated()
    {
        $response = $this->json('PUT',route('channel.update'),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test Update Channel
     */
    public function test_channel_update()
    {
        $channel = factory(Channel::class)->create([
            'name' => 'Laravel'
        ]);
        $response = $this->json('PUT',route('channel.update'),[
            'id' => $channel->id,
            'name' => 'Vuejs'
        ]);

        $updatedChannel = Channel::find($channel->id);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('Vuejs',$updatedChannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $response = $this->json('DELETE',route('channel.delete'),[]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $channel = factory(Channel::class)->create();
        $response = $this->json('DELETE',route('channel.delete'),[
            'id' => $channel->id
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }
}
