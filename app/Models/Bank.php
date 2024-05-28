<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getTypeNameAttribute()
    {
        return $this->type == 1 ? __('main.credit') : __("main.debit");
    }

    public static function calculateNetAmount()
    {
        $creditSum = self::where('type', 1)->sum('amount');
        $debitSum = self::where('type', 0)->sum('amount');

        return $creditSum - $debitSum;
    }
}
