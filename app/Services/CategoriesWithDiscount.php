<?php

namespace App\Services;


use App\Models\Discounts\Discount;
use App\Shop\CustomerGroups\CustomerGroup;
use App\Shop\Customers\Customer;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CategoriesWithDiscount
{
    private $query;

    public function __construct()
    {

        $guestId = CustomerGroup::where('title', 'Guest')->first()->id;

        $customerGroups = Auth::user() instanceof Customer && Auth::user()->groups()->count() ? Auth::user()->groups()->pluck('id') : [$guestId];

//        TODO ZAMYSLIET SA CO S TOUTO QUERY


        $discountsWithGroupAndCategory = Discount::selectRaw('discounts.percentage, discounts.from_margin, discounts.id, category_id, customer_group_id')
            ->join('customer_group_discount', 'discounts.id', '=', 'discount_id')
            ->join('customer_groups', 'customer_group_id', '=', 'customer_groups.id')
            ->join('category_discount', 'category_discount.discount_id', '=', 'discounts.id')
            ->whereIn('customer_group_id', $customerGroups);

//        Ako sa bude ratat zlava z defaultAtributov? Zatial asi nijak.

        $this->query = Product::selectRaw("products.*, MIN(
            CASE
            WHEN dwg.from_margin = true THEN
            ROUND(products.wholesale_price + ((products.price - products.wholesale_price) / 100 * (100-dwg.percentage)), 2)
            ELSE
            ROUND(products.price / 100 * (100-dwg.percentage), 2)
            END) as discounted_price")
            ->join('categorizables', 'categorizable_id','=', 'products.id')
            ->leftJoin('product_attributes', 'categorizable_id','=', 'products.id')
            ->join('categories', 'categorizables.category_id', '=', 'categories.id')
            ->leftJoinSub($discountsWithGroupAndCategory, 'dwg','dwg.category_id', '=', 'categorizables.category_id')
            ->groupBy(['products.id']);

    }

    public function getForCategory($category) {


        $this->query->whereHas('categories', function (Builder $query) use ($category){
            $query->where('id', $category);
        });

        return $this;
    }

    public function getMinPrice(){

        $smallestPrice = $this->query->min('products.price');
        $smallestDiscountedPrice = $this->query->orderBy('discounted_price', 'asc')->first()->discounted_price;

        if ($smallestPrice < $smallestDiscountedPrice || is_null($smallestDiscountedPrice)){
            return $smallestPrice;
        } else {
            return $smallestDiscountedPrice;
        }
    }

    public function getMaxPrice(){
        return $this->query->orderBy('products.price', 'desc')->first()->price;
    }

    public function getProducts($limit = null) {

        if($limit){
            $this->query->limit($limit);
        }

        return $this->query->get();
    }

    public function getSingleProductById($id){
        return $this->query->where('products.id', $id)->first();
    }

    public function getSingleProductBySlug($slug){
        return $this->query->where('products.slug', $slug)->first();
    }

    public function getBuilder(){
        return $this->query;
    }

}