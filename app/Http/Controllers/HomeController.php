<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use App\Models\Category;
use App\Models\Order;
use App\Models\Question;
use App\Models\Water;

class HomeController extends Controller
{
    public function index()
    {
        // whereHas(): diňe kategoriýasy bar suwlar we suwy bar kategoriýalar
        $featuredWaters = Water::whereHas('category')->with('category')->latest()->take(6)->get();
        $categories = Category::whereHas('waters')->withCount('waters')->get();

        return view('home', compact('featuredWaters', 'categories'));
    }

    public function dashboard()
    {
        // auth()->user(): şu wagt ulgama giren ulanyjy
        $user = auth()->user();

        $stats = [
            'waters' => Water::count(),
            'categories' => Category::count(),
            'my_orders' => $user->orders()->count(),
            'my_questions' => $user->questions()->count(),
        ];

        $myOrders = $user->orders()->whereHas('water')->with('water')->latest()->take(5)->get();
        $myQuestions = $user->questions()->latest()->take(5)->get();

        $adminStats = $user->isAdmin() ? [
            'orders' => Order::count(),
            'pending_questions' => Question::where('status', 'pending')->count(),
        ] : null;

        return view('dashboard', compact('user', 'stats', 'myOrders', 'myQuestions', 'adminStats'));
    }

    public function setLocale(string $locale)
    {
        if (in_array($locale, SetLocale::LOCALES, true)) {
            session(['locale' => $locale]);
            app()->setLocale($locale);
        }

        return redirect()->back();
    }
}
