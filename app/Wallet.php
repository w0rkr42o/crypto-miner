<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    public function scopeUser($query, $userId, $currencyId)
    {
        return $query
            ->where('user_id', '=', $userId)
            ->where('currency_id', '=', $currencyId)
            ->sum('amount');
    }
}