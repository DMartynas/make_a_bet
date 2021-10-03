<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWinAmount implements Rule
{

    private $max_win_amount = 20000;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stake_amount)
    {
        $this->stake_amount = $stake_amount;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  array  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $multiplied_odds = 1;
        foreach ($value as $element) {
            $multiplied_odds *= $element["odds"];
        }

        return ($multiplied_odds * $this->stake_amount)  <=  20000;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return json_encode(["error_code" => 9, "attribute" => $this->max_win_amount]);
    }
}
