<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id_category';

    protected $fillable = ['id_category', 'id_site', 'name', 'id_parent', 'child', 'selectable'];

    protected $with = ['childrens'];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'id_parent', 'id_category');
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'id_parent', 'id_category');
    }
}
