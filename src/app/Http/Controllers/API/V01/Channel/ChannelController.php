<?php

namespace App\Http\Controllers\API\V01\Channel;

use App\Channel;
use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelController extends Controller
{
    public function getAllChannelsList()
    {
        return response()->json(Channel::all(),200);
    }

    /**
     * Create new Channel
     * @param Request $request
     * @return JsonResponse
     */
    public function createNewChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        // Insert Channel To Database
        resolve(ChannelRepository::class)->create($request);

        return response()->json([
            'message' => 'channel created successfully'
        ],201);
    }
}
