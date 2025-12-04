<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Main Dashboard
    public function dashboard()
    {
        // User Statistics
        $totalUsers = User::count();
        $attendeeCount = User::where('user_type', 'attendee')->count();
        $organizerCount = User::where('user_type', 'organizer')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)->count();

        // Event Statistics
        $totalEvents = Event::count();
        $publishedEvents = Event::where('status', 'published')->count();
        $draftEvents = Event::where('status', 'draft')->count();

        // Booking & Revenue Statistics
        $totalBookings = Booking::count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');
        $pendingRevenue = Booking::where('status', 'pending')->sum('total_amount');

        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentEvents = Event::with('organizer', 'category')->latest()->take(5)->get();
        $recentBookings = Booking::with('user', 'event')->latest()->take(5)->get();

        // Category Statistics
        $totalCategories = Category::count();

        // === CHART DATA ===

        // 1. Revenue Trend (Last 6 Months)
        $revenueData = [];
        $revenueLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenueLabels[] = $date->format('M Y');
            $revenueData[] = Booking::where('status', 'confirmed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
        }

        // 2. Events by Category
        $categoryData = Category::withCount('events')->get();
        $categoryLabels = $categoryData->pluck('name')->toArray();
        $categoryValues = $categoryData->pluck('events_count')->toArray();

        // 3. Booking Status Distribution
        $bookingStatusData = [
            Booking::where('status', 'confirmed')->count(),
            Booking::where('status', 'pending')->count(),
            Booking::where('status', 'cancelled')->count(),
        ];
        $bookingStatusLabels = ['Confirmed', 'Pending', 'Cancelled'];

        // 4. User Registration Trend (Last 6 Months)
        $registrationData = [];
        $registrationLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $registrationLabels[] = $date->format('M Y');
            $registrationData[] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'attendeeCount', 'organizerCount', 'newUsersThisMonth',
            'totalEvents', 'publishedEvents', 'draftEvents',
            'totalBookings', 'confirmedBookings', 'pendingBookings',
            'totalRevenue', 'pendingRevenue',
            'recentUsers', 'recentEvents', 'recentBookings',
            'totalCategories',
            // Chart Data
            'revenueData', 'revenueLabels',
            'categoryLabels', 'categoryValues',
            'bookingStatusData', 'bookingStatusLabels',
            'registrationData', 'registrationLabels'
        ));
    }

    // User Management
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'user_type' => 'required|in:attendee,organizer,admin',
        ]);

        $user = User::findOrFail($id);
        $user->user_type = $request->user_type;
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Role pengguna berhasil diubah!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus!');
    }

    // Event Management
    public function events()
    {
        $events = Event::with('organizer', 'category')
                       ->orderBy('created_at', 'desc')
                       ->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function updateEventStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $event = Event::findOrFail($id);
        $event->status = $request->status;
        $event->save();

        return redirect()->route('admin.events')->with('success', 'Status event berhasil diubah!');
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.events')->with('success', 'Event berhasil dihapus!');
    }

    // Booking & Payment Overview
    public function bookings()
    {
        $bookings = Booking::with('user', 'event', 'ticketCategory', 'payment')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);

        $totalRevenue = Booking::where('status', 'confirmed')->sum('total_amount');
        $pendingRevenue = Booking::where('status', 'pending')->sum('total_amount');

        return view('admin.bookings.index', compact('bookings', 'totalRevenue', 'pendingRevenue'));
    }

    // Category Management
    public function categories()
    {
        $categories = Category::withCount('events')->orderBy('created_at', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dibuat!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has events
        if ($category->events()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh event!');
        }

        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus!');
    }
}
