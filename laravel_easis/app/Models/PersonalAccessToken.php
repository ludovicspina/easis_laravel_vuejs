<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as BaseToken;

class PersonalAccessToken extends BaseToken
{
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($token) {
            $token->forceFill([
                'plain_text_token' => $token->plainTextToken,
            ]);
        });
    }
}
