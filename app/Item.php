<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Item extends Model
{
    protected $fillable = [
        'id_item', 'id_country', 'id_category', 'title', 'subtitle', 'personal_reference',
        'description', 'price_starting', 'fixed_price', 'price_present', 'price_increment',
        'currency', 'date_end', 'duration', 'renew', 'bids', 'option_boldtitle', 'option_coloredborder',
        'option_highlight', 'option_keepoptionsonrenewal', 'option_lastminutebidding', 'option_privatebidding',
        'option_subtitle', 'option_topcategory', 'option_toplisting',  'option_topmain', 'prefered_end_hour', 'is_close'
    ];

    protected $dates = [
        'date_end'
    ];

    public function scopeFindByItemId($query, $id)
    {
        return $query->where('id_item', '=', $id);
    }

    public function scopeIsClosed($query)
    {
        return $query->where('is_closed', '=', true);
    }

    public function setPriceStartingAttribute($value)
    {
        $this->attributes['price_starting'] = floatval($value) * 100;
    }

    public function setFixedPriceAttribute($value)
    {
        $this->attributes['fixed_price'] = floatval($value) * 100;
    }

    public function setPricePresentAttribute($value)
    {
        $this->attributes['price_present'] = floatval($value) * 100;
    }

    public function setPriceIncrementAttribute($value)
    {
        $this->attributes['price_increment'] = floatval($value) * 100;
    }

    public function getPriceStartingAttribute($value)
    {
        return $value / 100;
    }

    public function getFixedPriceAttribute($value)
    {
        return $value / 100;;
    }

    public function getPricePresentAttribute($value)
    {
        return $value / 100;
    }

    public function getPriceIncrementAttribute($value)
    {
        return $value / 100;
    }
}
