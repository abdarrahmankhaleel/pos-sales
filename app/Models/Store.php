<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table="stores";
    protected $fillable=[
        'name','active','address',
        'phone','created_at','updated_at','added_by','updated_by',
        'com_code','date'
        ];
}
