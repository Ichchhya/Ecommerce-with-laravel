<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_desc',
        'price',
        'image',
        'category_id',
    ];

    protected $attributes = [
        'image' => ' ',
    ];

    protected $with = ['category'];

    public function category(){
        return $this->belongsTo(Category::class );
    }

    public function scopeSearch($query , array $terms){
        $search = $terms['search'];
        $category = $terms['category'];
    //     $query->when($search, function($query , $search){
    //         return $query->where('product_name', 'like', '%'. request('search').'%')
    //         ->orWhere('product_desc', 'like', '%'. request('search').'%');
    //     },function($query){
    //         return $query->where('id','>',0);
    //     }
    // );

    if($search){
        $query->where(function($query) use ($search){
            return $query->where('product_name', 'like', '%'. $search.'%')
             ->orWhere('product_desc', 'like', '%'. $search.'%');
        });
    }
    $query->when($category, function($query , $category){
        return $query->whereCategoryId($category);
    });
        // if($terms['search'] !== ' '){
        //     $query->where('product_name', 'like', '%'. request('search').'%')
        //     ->orWhere('product_desc', 'like', '%'. request('search').'%');
        // }
        return $query;
    }
}
