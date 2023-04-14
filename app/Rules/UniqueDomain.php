<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueDomain implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $domain = explode('@', $value)[1];
        $count = \DB::table('companies')->where('email', 'like', '%@'.$domain)->count();
        return $count === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This email domain is already in use.';
    }
}
