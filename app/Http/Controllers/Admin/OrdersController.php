<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\UserOrder;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $order;

    public function __construct(UserOrder $order)
    {
        $this->order = $order;
    }

    public function index()
    {
        $orders = Auth()->user()->store->orders()->paginate(5);
        return view('admin.orders.index', compact('orders'));
    }
}
