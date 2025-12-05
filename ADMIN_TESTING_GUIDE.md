# Admin Dashboard - Testing Guide

## Prerequisites
```bash
# 1. Install dependencies (if not done)
composer install
npm install

# 2. Run migrations
php artisan migrate

# 3. Start servers
php artisan serve
npm run dev
```

## Login Credentials
- **Admin**: `admin@test.com` / `password`
- **Mitra**: `mitra@test.com` / `password`
- **User**: `user@test.com` / `password`

---

## Test Checklist

### 1. Admin Dashboard (`/admin/dashboard`)
- [ ] Statistics cards show correct numbers
- [ ] 4 charts render properly:
  - Revenue Trend (line chart)
  - User Registration (line chart)
  - Events by Category (bar chart)
  - Booking Status (doughnut chart)
- [ ] Recent activity feeds display (Users, Events, Bookings)
- [ ] Quick action buttons navigate correctly

### 2. User Management (`/admin/users`)
- [ ] All users listed with pagination
- [ ] Change user role via dropdown (Attendee/Organizer/Admin)
- [ ] Delete user works (cannot delete self)
- [ ] Statistics cards show totals

### 3. Event Management (`/admin/events`)
- [ ] All events from all organizers visible
- [ ] Change event status (Draft/Published/Cancelled)
- [ ] View event button opens event detail
- [ ] Delete event works
- [ ] Shows organizer info

### 4. Booking Overview (`/admin/bookings`)
- [ ] All bookings listed
- [ ] Revenue statistics displayed
- [ ] Status badges colored correctly (Green/Yellow/Red)
- [ ] Pagination works

### 5. Category Management (`/admin/categories`)
- [ ] Categories displayed in card grid
- [ ] Create new category
- [ ] Edit existing category
- [ ] Delete category (blocks if used by events)
- [ ] Active/Inactive toggle works

---

## Quick Test Data Setup (Optional)

```php
// Run in tinker: php artisan tinker

// Create sample categories
\App\Models\Category::create(['name' => 'Music', 'is_active' => true]);
\App\Models\Category::create(['name' => 'Sports', 'is_active' => true]);

// Create sample event
\App\Models\Event::factory()->create([
    'organizer_id' => 2, // mitra user ID
    'category_id' => 1,
    'status' => 'published'
]);

// Create sample booking
\App\Models\Booking::factory()->create([
    'user_id' => 3, // user ID
    'event_id' => 1,
    'status' => 'confirmed',
    'total_amount' => 500000
]);
```

---

## Expected Behavior

### Charts
- **Revenue**: Shows last 6 months revenue (confirmed bookings only)
- **Registration**: Shows new users per month for 6 months
- **Category**: Bar chart of events count per category
- **Booking Status**: Pie chart showing Confirmed/Pending/Cancelled distribution

### Permissions
- Only users with `user_type = 'admin'` can access `/admin/*` routes
- Non-admin users redirected to their respective dashboards

### Design
- Modern Tailwind UI matching Mitra dashboard
- Responsive (mobile/tablet/desktop)
- Hover effects on cards and buttons
- Color-coded status badges

---

## Common Issues

**Charts not showing?**
- Check browser console for errors
- Ensure Chart.js CDN loads (`https://cdn.jsdelivr.net/npm/chart.js`)
- Verify data exists (at least 1 user/event/booking)

**"Forbidden" error?**
- Make sure logged in as admin user
- Check `users` table: `user_type` should be `'admin'`

**Empty data?**
- Run migrations: `php artisan migrate`
- Seed test data (see Quick Test Data Setup above)

---

## Files Modified
- `app/Http/Controllers/AdminController.php` - Controller logic
- `resources/views/admin/dashboard.blade.php` - Main dashboard
- `resources/views/admin/users/index.blade.php` - User management
- `resources/views/admin/events/index.blade.php` - Event management
- `resources/views/admin/bookings/index.blade.php` - Booking overview
- `resources/views/admin/categories/*.blade.php` - Category CRUD
- `routes/web.php` - Admin routes

---

## Done Testing?
Mark as complete when:
✅ All 5 pages load without errors
✅ Charts display with data
✅ CRUD operations work (Create/Read/Update/Delete)
✅ Role-based access works
✅ Design matches existing style
