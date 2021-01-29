<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $users = User::whereRoleIs('admin')->count();
        $products = Product::count();
        $clients = Client::count();
        return view('dashboard.index',compact('users','categories','products','clients'));
    }
}
