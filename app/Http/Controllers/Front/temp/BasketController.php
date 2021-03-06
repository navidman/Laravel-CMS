<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Services\FactorService;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function getQuickRegister($phone)
    {
        $test_user = User::where('phone', $phone)->first();
        if($test_user)
        {
            if(\Hash::check($phone, $test_user->password))
            {
                if (\Auth::attempt(['phone' => $phone, 'password' => $phone], 1000)) {
                    return redirect('checkout/address');
                }
                    dd('error UserPassIsNotMobile رخ داده - به 09106801685 زنگ بزنید و خطا را اعلام کنید');
                    return redirect()->back();

            }
                $phone .= '-' . rand(10, 99);
                $test_user_2 = User::where('phone', $phone)->first();
                if($test_user_2){
                    $phone .= '-' . rand(10000, 99999);
                }

        }
        $guest_user = [
            'first_name' => 'مهمان',
            'last_name' => $phone,
            'phone' => $phone,
            'password' => bcrypt($phone),
            'status' => User::STATUS_ACTIVE,
        ];
        User::firstOrCreate($guest_user);
        \Log::info('user quick register with phone: ' . $phone);
        if (\Auth::attempt(['phone' => $phone, 'password' => $phone], 1000)) {
            return redirect('checkout/address');
        }
            dd('error tooSoonLogin رخ داده - به 09106801685 زنگ بزنید');
            return redirect()->back();

    }

    public function getProductInit()
    {
        $categories = Category::select('id', 'title')->get();
        $vue_products = FactorService::_getProductsVue();
        return [
            'categories' => $categories,
            'products' => $vue_products,
            'basket' => FactorService::_getUserBasketVueProducts(),
            'total_price' => FactorService::_getTotalPrice(),
            'max_price' =>  collect($vue_products)->max('price'),
        ];
    }

    public function getProductFilter(Request $request)
    {
        $filters = $request->filters;
        if($filters)
        {
            $vue_products = FactorService::_getProductsVue($filters);
            return [
                'products' => $vue_products,
                'max_price' =>  collect($vue_products)->max('price'),
            ];
        }
    }

    public function postAdd(Request $request)
    {
        $product_id = $request->product_id;
        $add = $request->add;
        FactorService::_addToBasket($product_id, $add);
        $vue_basket = FactorService::_getUserBasketVueProducts();
        $total_price = FactorService::_getTotalPrice();
         return [
            'basket' => $vue_basket,
            'total_price' => $total_price,
        ];
    }

    public function getIndex()
    {
        $meta = [
            'title' => __('basket'),
            'description' => config('setting-general.default_meta_description'),
            'keywords' => '',
            'image' => asset(config('setting-general.default_meta_image')),
            'google_index' => config('setting-general.google_index'),
            'canonical_url' => url()->current(),
        ];

        return view('front.components.basket', ['meta' => $meta]);
    }

    public function getInit()
    {
        return [
            'basket' => FactorService::_getUserBasketVueProducts(),
            'total_price' => FactorService::_getTotalPrice(),
            'user' => \Auth::id(),
        ];
    }

    public function postBasketCount(Request $request)
    {
        $product_id = $request->product_id;
        $count = $request->count;
        FactorService::_changeCountBasket($product_id, $count);
        return $this->getInit();
    }

    public function postBasketCountView(Request $request)
    {
        $product_id = $request->product_id;
        $count = $request->count;
        FactorService::_changeCountBasket($product_id, $count);

        $request->session()->flash('alert-success', self::MESSAGE_UPDATE_SUCCESS);
        return redirect()->back();
    }
}
