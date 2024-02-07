<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameStoreRequest;
use App\Http\Requests\GameUpdateRequest;
use App\Http\Resources\GameCollection;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\League;
use App\Models\Player;
use App\Services\GameService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Game Management
 *
 * APIs for managing games
 */
class GameController extends BaseController
{
    public function __construct(private GameService $gameService)
    {
    }

    /**
     * GET Games
     *
     * Display a listing of the Game resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(new GameCollection(Game::with(['playerOne', 'playerTwo', 'league'])->get()), "Games retrieved successfully");
    }

    /**
     * POST Game
     *
     * Store a newly created Game resource in storage.
     *
     * @param GameStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameStoreRequest $request)
    {
        $game = $this->gameService->store($request->validated());

        return $this->sendResponse(new GameResource($game->loadMissing(['playerOne', 'playerTwo', 'league'])), "Game successfully created", Response::HTTP_CREATED);
    }

    /**
     * GET Game
     *
     * Display the specified Game resource.
     *
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return $this->sendResponse(new GameResource($game->loadMissing(['playerOne', 'playerTwo', 'league'])), "Game retrieved successfully");
    }

    /**
     * PUT/PATCH Game
     *
     * Update the specified Game resource in storage.
     *
     * @param GameUpdateRequest $request
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function update(GameUpdateRequest $request, Game $game)
    {
        $game = $this->gameService->update($game, $request->validated());

        return $this->sendResponse(new GameResource($game->loadMissing(['playerOne', 'playerTwo', 'league'])), "Game updated successfully");
    }

    /**
     * DELETE Game
     *
     * Remove the specified Game resource from storage.
     *
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        if ($game->delete()) {
            return $this->sendResponse([], "Game deleted successfully", Response::HTTP_NO_CONTENT);
        } else {
            return $this->sendError($game->id, "Something went wrong");
        }
    }

    /**
     * GET player Games
     *
     * Display the listing of a Game resource for specified Player.
     *
     * @param Player $player
     * @return \Illuminate\Http\Response
     */
    public function playerGames(Player $player)
    {
        return $this->sendResponse(new GameCollection($player->allGames()->with(['playerOne', 'playerTwo'])->get()), "Games retrieved successfully");
    }

    /**
     * GET recent league Games
     *
     * Display the listing of a Game resource for specified League in descending order.
     *
     * @param League $league
     * @return \Illuminate\Http\Response
     */
    public function recentLeagueGames(League $league)
    {
        return $this->sendResponse(new GameCollection($league->games()->with(['playerOne', 'playerTwo'])->orderBy('created_at', 'desc')->take(5)->get()), "Games retrieved successfully");
    }

    /**
     * GET league
     * @param League $league
     * @return \Illuminate\Http\Response
     */
    public function leagueGames(League $league)
    {
        return $this->sendResponse(new GameCollection($league->games()->with(['playerOne', 'playerTwo'])->orderBy('created_at', 'desc')->get()), "Games retrieved successfully");
    }
}
