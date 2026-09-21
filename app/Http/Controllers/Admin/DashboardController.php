<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');

        return view('pages.admin.dashboard', [
            'todayCount' => Booking::where('appointment_date', $today)->whereNotIn('status', ['cancelled'])->count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'revenueToday' => (int) Order::whereDate('created_at', $today)->whereNotIn('status', ['cancelled'])->sum('total'),
            'lowStock' => Product::where('is_active', true)->where('stock', '<=', 3)->orderBy('stock')->take(5)->get(),
            'todayBookings' => Booking::with(['service', 'barber', 'user'])
                ->where('appointment_date', $today)->orderBy('start_time')->take(5)->get(),
            'recentOrders' => Order::orderBy('id', 'desc')->take(5)->get(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'recentMessages' => ContactMessage::orderBy('id', 'desc')->take(3)->get(),
        ]);
    }
}
