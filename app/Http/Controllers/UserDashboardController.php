<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // You can customize the user dashboard as needed
        return view('user.dashboard', compact('user'));
    }

    public function requests()
    {
        $user = Auth::user();

        // Fetch only the borrowing requests made by the current user using the relationship
        $borrowingRequests = $user->borrowings()
            ->with(['asset', 'rejection'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.requests', compact('borrowingRequests'));
    }
}