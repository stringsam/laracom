<?php
/**
 * Created by PhpStorm.
 * User: samueltrstensky
 * Date: 2019-07-27
 * Time: 19:42
 */

namespace App\Shop\OrderProduct;


use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id', // @deprecated
        'product_id',
        'quantity',
        'product_name',
        'product_sku',
        'product_description',
        'product_price',
        'product_discount'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function productAttributes(){
        return $this->belongsToMany(ProductAttribute::class)
            ->withPivot('price', 'discount');
    }

}