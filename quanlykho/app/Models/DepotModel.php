<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepotModel extends Model
{
    protected $table = "depots";

    protected $fillable = ['name', 'price', 'quantity',  'category'];
}
