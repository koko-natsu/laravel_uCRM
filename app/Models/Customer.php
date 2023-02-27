<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo',
    ];

    public function scopeSearchCustomer($query, $input = null)
    {
        if(!empty($input)) {
            $result = Customer::where('kana', 'like', $input.'%')->orWhere('tel', 'like', $input.'%')->exists();
            if($result)
            {
            return [$query->select('id', 'name', 'kana', 'tel')
                ->where('kana', 'like', $input.'%')
                ->orWhere('tel', 'like', $input.'%'), $result];
            } 
        }
        return [$query, $result = false];
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}