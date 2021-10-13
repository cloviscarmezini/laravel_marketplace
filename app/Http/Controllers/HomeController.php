<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class HomeController extends Controller
{
    protected $products;

    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = $this->products->limit(6)->orderBy('id', 'DESC')->get();
        $stores = \App\Store::limit(3)->orderBy('id', 'DESC')->get();
        
        return view('welcome', compact('products','stores'));
    }

    public function single($slug)
    {
        $product = $this->products->whereSlug($slug)->first();

        return view('single', compact('product'));
    }
}
