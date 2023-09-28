<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GameUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'player_one' => ['required', 'integer', 'exists:players,id', 'different:player_two'],
            'player_two' => ['required', 'integer', 'exists:players,id', 'different:player_one'],
            'player_one_score' => ['required', 'integer', 'between:0,6'],
            'player_two_score' => ['required', 'integer', 'between:0,6'],
            'player_one_avg' => ['required', 'decimal:2', 'between:0,167'],
            'player_two_avg' => ['required', 'decimal:2', 'between:0,167'],
            'player_one_max_amount' => ['required', 'integer'],
            'player_two_max_amount' => ['required', 'integer'],
            'league_id' => ['required', 'integer', 'exists:leagues,id', 'between:1,3'],
            'winner' => ['required', 'integer'],
            'player_one_high_outs' => ['sometimes','array'],
            'player_one_high_outs.*' => ['numeric'],
            'player_one_fast_outs' => ['sometimes','array'],
            'player_one_fast_outs.*' => ['numeric'],
            'player_two_high_outs' => ['sometimes','array'],
            'player_two_high_outs.*' => ['numeric'],
            'player_two_fast_outs' => ['sometimes','array'],
            'player_two_fast_outs.*' => ['numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'player_one.required' => 'Player one is required',
            'player_two.required' => 'Player two is required',
            'player_one_score.required' => 'Player one score is required',
            'player_two_score.required' => 'Player two score is required',
            'player_one_score.between' => 'Player one score need to be between 0 and 6',
            'player_two_score.between' => 'Player two score need to be between 0 and 6',
            'player_one_avg.required' => 'Player one average is required',
            'player_two_avg.required' => 'Player two average is required',
            'player_one_max_amount' => 'Player one max amount i required',
            'player_two_max_amount' => 'Player two max amount i required',
            'league_id' => 'Select league',
            'winner.required' => 'Select winner of the game',
            'league_id.exists' => 'Passed league is invalid',
            'player_one_high_outs.*.numeric' => 'High outs should contain only numeric values',
            'player_one_fast_outs.*.numeric' => 'Fast outs should contain only numeric values',
            'player_two_high_outs.*.numeric' => 'High outs should contain only numeric values',
            'player_two_fast_outs.*.numeric' => 'Fast outs should contain only numeric values',
        ];
    }
}
