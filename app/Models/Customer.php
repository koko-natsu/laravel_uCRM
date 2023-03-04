<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;
use Illuminate\Support\Facades\Log;

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

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function scopeSearchCustomer($query, $input=null)
    {   
        if(!empty($input)) 
        {
            if(Customer::where('kana', 'like', $input.'%')
                ->orWhere('tel', 'like', $input.'%')->exists())
            {
                $query = $query->select('id', 'name', 'kana', 'tel')
                    ->where('kana', 'like', $input.'%')
                    ->orWhere('tel', 'like', $input.'%');
                    
                return [$query, $result=true];
            } 
        } 
        return [$query, $result=false];
    }



    public function scopeApiSearchCustomer($query, $input=null)
    {
        if(!empty($input))
        {
            if(Customer::where('kana', 'like', $input.'%')
                ->orWhere('tel', 'like', $input.'%')->exists());
                {
                    $query->select('id', 'name', 'kana', 'tel')
                        ->where('kana', 'like', $input.'%')
                        ->orWhere('tel', 'like', $input.'%');
                }
        }
        return $query;
    }

}