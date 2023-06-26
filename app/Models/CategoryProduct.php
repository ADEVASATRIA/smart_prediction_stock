<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'category_products';
    protected $primaryKey = 'id_category_product';
    protected $fillable = ['name_category_product'];
}
