<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = Category::count();
        $users = User::whereRoleIs('admin')->count();
        $products = Product::count();
        $clients = Client::count();

        $chart_data = Order::select([
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(price) as sum'),
        ])->groupBy('month')->get();

        dd($chart_data->first());

        return view('dashboard.index',compact('users','categories','products','clients','chart_data'));
    }
}
