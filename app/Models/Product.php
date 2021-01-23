<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model implements TranslatableContract
{
    use Translatable;
    protected $guarded = [];
    protected $appends = ['profit_percent'];
    public $translatedAttributes = ['name','description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getProfitPercentAttribute()
    {
        $profit = $this->sale_price - $this->purchase_price;

        $profit_percent = $profit * 100 /$this->purchase_price;

        return number_format($profit_percent,2);
    }
}
