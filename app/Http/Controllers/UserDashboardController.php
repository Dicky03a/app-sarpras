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
            ->paginate(20);

        return view('user.requests', compact('borrowingRequests'));
    }

    /**
     * Display detailed information for a specific borrowing request made by the user.
     */
    public function showBorrowing(Borrowing $borrowing)
    {
        $user = Auth::user();

        // Ensure the user can only view their own borrowing requests
        if ($borrowing->user_id !== $user->id) {
            abort(403, 'Unauthorized to view this borrowing request.');
        }

        // Load all related data for the borrowing
        $borrowing->load([
            'asset',
            'rejection',
            'admin',
            'moves',
            'moves.oldAsset',
            'moves.newAsset',
            'moves.admin'
        ]);

        return view('user.borrowing-detail', compact('borrowing'));
    }
}