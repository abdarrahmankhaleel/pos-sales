<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    use HasFactory;
    public $table="names";// كدا انا بقله مين هو الجدول الي هيتربط فيه
public $fillable=['name','active','created_at','updated_at'];// ايه هي الحقول الي هيشوفها // الي مش مذكور هنا مش هيشوفه
}
