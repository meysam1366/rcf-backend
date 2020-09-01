<?php

namespace Tests\Unit\API\v1\Channel;

use App\Channel;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function registerRolesAndPermissions()
    {
        $roleInDatabase = \Spatie\Permission\Models\Role::where('name',config('permission.default_roles')[0]);
        if ($roleInDatabase->count()<1) {
            foreach (config('permission.default_roles') as $role) {
                \Spatie\Permission\Models\Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabase = \Spatie\Permission\Models\Permission::where('name',config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count()<1) {
            foreach (config('permission.default_permissions') as $permission) {
                \Spatie\Permission\Models\Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

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
        $user = factory(User::class)->create();

        $this->setRoleAndPermission($user);
        
        $response = $this->actingAs($user)->postJson(route('channel.create'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_create_new_channel()
    {
        $user = factory(User::class)->create();

        $this->setRoleAndPermission($user);

        $response = $this->actingAs($user)->postJson(route('channel.create'), [
            'name' => 'Laravel'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test Update Channel
     */
    public function test_channel_update_should_be_validated()
    {
        $user = factory(User::class)->create();

        $this->setRoleAndPermission($user);

        $response = $this->actingAs($user)->json('PUT', route('channel.update'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test Update Channel
     */
    public function test_channel_update()
    {
        $user = factory(User::class)->create();

        $this->setRoleAndPermission($user);

        $channel = factory(Channel::class)->create([
            'name' => 'Laravel'
        ]);
        $response = $this->actingAs($user)->json('PUT', route('channel.update'), [
            'id' => $channel->id,
            'name' => 'Vuejs'
        ]);

        $updatedChannel = Channel::find($channel->id);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals('Vuejs', $updatedChannel->name);
    }

    /**
     * Test Delete Channel
     */
    public function test_channel_delete_should_be_validated()
    {
        $user = factory(User::class)->create();

        $this->setRoleAndPermission($user);

        $response = $this->actingAs($user)->json('DELETE', route('channel.delete'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $user = factory(User::class)->create();

        $this->setRoleAndPermission($user);

        $channel = factory(Channel::class)->create();
        $response = $this->actingAs($user)->json('DELETE', route('channel.delete'), [
            'id' => $channel->id
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function setRoleAndPermission($user)
    {
        $this->registerRolesAndPermissions();

        $user->givePermissionTo('channel management');
    }
}
