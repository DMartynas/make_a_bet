<?php

namespace App\Http\Requests;

use App\Rules\MaxWinAmount;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class APIRequest extends FormRequest
{
    private $min_amount = 0.3;
    private $max_amount = 10000;
    private $min_selections = 1;
    private $max_selections = 20;
    private $min_odds = 1;
    private $max_odds = 10000;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player_id' => 'required',
            'stake_amount' => "required|numeric|min:$this->min_amount|max:$this->max_amount",
            'selections' => [
                'required',
                'array',
                "min:$this->min_selections",
                "max:$this->max_selections",
                new MaxWinAmount($this->stake_amount)
            ],
            'selections.*.odds' => "required|numeric|min:$this->min_odds|max:$this->max_odds",
            'selections.*.id' => 'required|distinct',
        ];
    }

    /**
     * Messages for failed validation
     *
     * @return array
     */
    public function messages()
    {
        $selection_messages = [];
        $global_messages = [
            'required' => json_encode(['error_code' => 1]),
            'stake_amount.min' => json_encode(['error_code' => 2, 'attribute' => $this->min_amount]),
            'stake_amount.max' => json_encode(['error_code' => 3, 'attribute' => $this->max_amount]),
            'selections.min' => json_encode(['error_code' => 4, 'attribute' => $this->min_selections]),
            'selections.max' => json_encode(['error_code' => 5, 'attribute' => $this->max_selections]),
        ];

        foreach ($this->get('selections') as $key => $value) {
            $selection_messages += [
                "selections.$key.odds.min" => json_encode([
                    'error_code' => 6,
                    'attribute' => $this->min_odds,
                    'id' => $value["id"]
                ]),
                "selections.$key.odds.max" => json_encode([
                    'error_code' => 7,
                    'attribute' => $this->max_odds,
                    'id' => $value["id"]
                ]),
                "selections.$key.id.distinct" => json_encode([
                    'error_code' => 8,
                    'id' => $value["id"]
                ])
            ];
        }

        $all_error_messages = $global_messages + $selection_messages;

        return $all_error_messages;
    }

        /**
         * Handle a failed validation attempt.
         *
         * @param  \Illuminate\Contracts\Validation\Validator  $validator
         * @return void
         *
         * @throws \Illuminate\Validation\ValidationException
         */
    protected function failedValidation(Validator $validator)
    {
        $error_array = [
            "errors" => [],
            "selections" => [],
        ];

        foreach ($validator->errors()->messages() as $key => $error) {
            $decoded_error = json_decode($error[0], true);

            $error_object = [
                'code' => $decoded_error['error_code'],
                'message' => __(
                    'validation.' . config('validation_error_codes.' . $decoded_error['error_code']),
                    [
                            'attribute' => $decoded_error['attribute'] ?? 0
                        ]
                ),
            ];

            if (isset($decoded_error['id'])) {
                $error_added_to_array = false;

                foreach ($error_array['selections'] as $item) {
                    if ($item['id'] === $decoded_error['id']) {
                        $item['errors'][] = $error_object;
                        $error_added_to_array = true;
                        break;
                    }
                }

                if (!$error_added_to_array) {
                    $error_array["selections"][] = [
                        'id' => $decoded_error['id'],
                        'errors' => [
                            $error_object
                        ]
                    ];
                }
            } else {
                $error_array["errors"][] = $error_object;
            }
        }

        throw new ValidationException($validator, response()->json($error_array));
    }
}
