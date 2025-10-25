# Room Availability Integration - Complete Guide

## Overview

This document describes the integration of 3 room availability APIs with the frontend pages (Welcome, Rooms2, and Room Details).

## APIs Integrated

### 1. `/api/rooms/available` - Get All Available Rooms

**Used in:** `welcome.blade.php` (Homepage)

- **Method:** GET
- **Parameters:**
  - `check_in` (required): Check-in date (YYYY-MM-DD)
  - `check_out` (required): Check-out date (YYYY-MM-DD)
- **Response:** List of all available rooms across all room types

### 2. `/api/rooms/available/by_type` - Get Available Rooms by Type

**Used in:** `rooms2.php` (Room Type Listing Page)

- **Method:** GET
- **Parameters:**
  - `check_in` (required): Check-in date (YYYY-MM-DD)
  - `check_out` (required): Check-out date (YYYY-MM-DD)
  - `room_type_id` (required): Room type ID (e.g., LP001)
- **Response:** List of available rooms for a specific room type

### 3. `/api/rooms/available/by_room` - Check Specific Room Availability

**Used in:** `roomdetails.php` (Room Details Page)

- **Method:** GET
- **Parameters:**
  - `check_in` (required): Check-in date (YYYY-MM-DD)
  - `check_out` (required): Check-out date (YYYY-MM-DD)
  - `id` (required): Specific room ID (e.g., P001)
- **Response:** Single room data if available, or error if not available

## Frontend Implementation

### 1. Welcome Page (`welcome.blade.php`)

#### Features Added:

- **Booking Form with Validation:**

  - Check-in and check-out date pickers (HTML5 date inputs)
  - Room type dropdown (optional) populated from database
  - Adults and children selection
  - Minimum date validation (today onwards)
  - Check-out must be after check-in

- **Dynamic Results Display:**

  - Shows available rooms based on search criteria
  - Animated results section with smooth scrolling
  - Loading spinner during API call
  - No results message when no rooms found
  - Results counter showing number of available rooms

- **Room Cards:**
  - Displays room image, name, room number
  - Shows maximum guests capacity
  - Description preview (truncated)
  - Book Now button with dates passed in URL
  - Links to room details page with selected dates

#### User Flow:

1. User selects check-in and check-out dates
2. Optionally selects a specific room type
3. Selects number of adults and children
4. Clicks "Check Now" button
5. Form validates dates
6. API call made to `/api/rooms/available` or `/api/rooms/available/by_type`
7. Results displayed below form
8. User can click "Book Now" to proceed to room details

### 2. Rooms2 Page (`rooms2.php`)

#### Features Added:

- **Type-Specific Availability Form:**

  - Pre-filled room type ID (from URL parameter)
  - Check-in and check-out date pickers
  - Adults and children selection
  - Date validation

- **Dynamic Results Display:**

  - Shows only available rooms of the selected type
  - Loading spinner during search
  - No results message
  - Results displayed in same layout as existing rooms

- **Room Display:**
  - Alternating left/right layout (matching existing design)
  - Room image, number, and type name
  - Description and amenities
  - Max guests information
  - Details and Book Now buttons with dates

#### User Flow:

1. User arrives at page for specific room type (e.g., ?type=LP001)
2. Enters check-in and check-out dates
3. Clicks "Check Availability"
4. API call made to `/api/rooms/available/by_type` with room type ID
5. Available rooms of that type displayed
6. User can click "Book Now" to go to specific room details

### 3. Room Details Page (`roomdetails.php`)

#### Features Added:

- **Room-Specific Availability Check:**

  - Pre-filled room ID from URL
  - Auto-fill dates from URL if coming from search results
  - Check-in and check-out date pickers
  - Adults and children selection
  - Date validation

- **Real-time Availability Feedback:**

  - Success message (green) if room is available
  - Error message (red) if room is not available
  - Loading spinner during check
  - "Proceed to Booking" button appears when available

- **Enhanced Booking Section:**
  - Room number displayed in form header
  - Smooth scroll to booking section via "Check Availability" button
  - Color-coded availability status

#### User Flow:

1. User arrives at room details page (optionally with check-in/check-out dates from previous page)
2. Dates are pre-filled if provided in URL
3. User can modify dates or enter new dates
4. Clicks "Check Availability"
5. API call made to `/api/rooms/available/by_room` with specific room ID
6. Immediate feedback: available (green) or not available (red)
7. If available, "Proceed to Booking" button appears
8. User can continue to booking process

## Technical Implementation Details

### JavaScript Features:

- **Date Validation:**

  - Minimum date set to today
  - Check-out minimum automatically updates based on check-in
  - Prevents invalid date selections

- **API Integration:**

  - Async/await fetch API calls
  - Error handling with try-catch
  - Loading states for better UX
  - JSON response parsing

- **Dynamic Content Generation:**

  - Template literals for HTML generation
  - Proper URL encoding for parameters
  - Responsive design maintained

- **User Experience:**
  - Smooth scrolling to results
  - Loading spinners during API calls
  - Clear success/error messages
  - Animate-on-scroll effects for results

### Form Elements:

- **HTML5 Date Inputs:** Native date pickers for better mobile support
- **Select2 Dropdowns:** Enhanced select boxes (already in template)
- **Hidden Fields:** Room type ID and room ID stored for API calls
- **Validation:** Required fields and date logic validation

## CSS Styling

- Uses existing template styles
- Custom availability messages with color coding:
  - Green (#d4edda): Room available
  - Red (#f8d7da): Room not available
  - Yellow (#fff3cd): Error/warning
- Responsive design maintained
- Smooth transitions and animations

## URL Parameter Passing

Dates are passed between pages via URL parameters:

```
/roomdetails.php?id=P001&check_in=2025-10-20&check_out=2025-10-22
```

This allows users to:

- Maintain their date selection across pages
- Share direct links with specific dates
- Browser back button works correctly

## Error Handling

- Invalid date selections prevented by validation
- API errors caught and displayed to user
- Network errors handled gracefully
- Empty results handled with appropriate messaging

## Future Enhancements (Optional)

1. **Price Calculation:** Show total price based on number of nights
2. **Room Filtering:** Add filters for price range, amenities, capacity
3. **Booking Calendar:** Visual calendar showing available/unavailable dates
4. **Multiple Rooms:** Allow booking multiple rooms at once
5. **Session Storage:** Save search criteria across page navigation
6. **Email Notifications:** Send availability alerts
7. **Payment Integration:** Complete booking flow with payment

## Testing Checklist

- [ ] Date validation works correctly
- [ ] API calls return correct data
- [ ] Loading states display properly
- [ ] Success messages show for available rooms
- [ ] Error messages show for unavailable rooms
- [ ] Room type filter works on welcome page
- [ ] Dates persist across pages via URL
- [ ] Responsive design works on mobile
- [ ] Browser back button works correctly
- [ ] All links work properly

## Files Modified

1. `service/resources/views/welcome.blade.php`

   - Added availability form
   - Added results display section
   - Added JavaScript for API integration

2. `service/resources/views/rooms2.php`

   - Added type-specific availability form
   - Added results display section
   - Added JavaScript for API integration

3. `service/resources/views/roomdetails.php`
   - Updated booking form
   - Added availability check feature
   - Added JavaScript for room-specific check
   - Updated "Check Now" button link

## API Routes (Already Configured)

```php
Route::prefix('rooms')->group(function () {
    Route::get('/available', [RoomController::class, 'getAvailableRooms']);
    Route::get('/available/by_type', [RoomController::class, 'getAvailableRoomsByType']);
    Route::get('/available/by_room', [RoomController::class, 'getAvailableRoomById']);
});
```

## Notes

- All date formats use YYYY-MM-DD (ISO 8601)
- Timezone considerations may need to be added for production
- Rate limiting should be considered for API endpoints
- Consider caching frequently accessed availability data
- Database indexes on date fields will improve performance

## Support & Maintenance

- Monitor API response times
- Check error logs regularly
- Update validation rules as business requirements change
- Keep JavaScript libraries up to date
- Test across different browsers and devices
