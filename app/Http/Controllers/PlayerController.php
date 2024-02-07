<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Http\Resources\PlayerCollection;
use App\Http\Resources\PlayerResource;
use App\Models\League;
use App\Models\Player;
use App\Services\PlayerService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Player Management
 *
 * APIs for managing players
 */
class PlayerController extends BaseController
{
    public function __construct(private PlayerService $playerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(new PlayerCollection(Player::with(['league', 'highOuts', 'fastOuts'])->get()), "Players retrieved successfully");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlayerStoreRequest $request)
    {
        $player = $this->playerService->create($request->validated());

        return $this->sendResponse(new PlayerResource($player->loadMissing(['league'])), "Player successfully created", Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        return $this->sendResponse(new PlayerResource($player->loadMissing(['league', 'highOuts', 'fastOuts'])), "Player retrieved successfully");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlayerUpdateRequest $request, Player $player)
    {
        $game = $this->playerService->update($player, $request->validated());

        return $this->sendResponse(new PlayerResource($game->loadMissing(['league'])), "Player updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        if ($player->delete()) {
            return $this->sendResponse([], "Player deleted successfully", Response::HTTP_NO_CONTENT);
        } else {
            return $this->sendError($player->id, "Something went wrong");
        }
    }

    /**
     * Display list of specified resource in storage
     */
    public function playersLeague(League $league)
    {
        return $this->sendResponse(new PlayerCollection($league->players()->with('highOuts', 'fastOuts')->orderByDesc('points')->get()), "Players retrieved successfully");
    }
}
