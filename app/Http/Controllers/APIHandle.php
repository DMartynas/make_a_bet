<?php

namespace App\Http\Controllers;

use App\Http\Requests\APIRequest;
use App\Models\BalanceTransaction;
use App\Models\Bet;
use App\Models\BetSelection;
use App\Models\Player;
use Config;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class APIHandle extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  App\Http\Requests\APIRequest;
     * @return \Illuminate\Http\Response
     */
    public function __invoke(APIRequest $request)
    {
        $player = Player::findOrNew($request->input('player_id'));
        $player->save();
        $player->refresh();

        if ($player->balance < doubleval($request->input('stake_amount'))) {
            return response()->json([
                "error" => [
                    "code" => 11,
                    "messsage" =>  __('validation.' . config('validation_error_codes.11'))
                ]
            ]);
        }

        BalanceTransaction::create([
            'amount' => $player->balance - doubleval($request->input('stake_amount')),
            'previous_amount' => $player->balance,
            'player_id' => $player->id,
        ]);

        $bet = Bet::create(['stake_amount' => $request->input('stake_amount')]);

        foreach ($request->input('selections') as $selection) {
            BetSelection::create([
                'selection_id' => $selection['id'],
                'odds' => $selection['odds'],
                'bet_id' => $bet->id
            ]);
        }

        $player->balance = $player->balance - doubleval($request->input('stake_amount'));
        $player->save();
    }
}
