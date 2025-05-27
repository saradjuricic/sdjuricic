<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalRevenue = Order::sum('total');
        
        // Chart data - orders per day for last 30 days
        $chartData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return view('admin.dashboard', compact('totalOrders', 'totalProducts', 'totalUsers', 'totalRevenue', 'chartData'));
    }
}
