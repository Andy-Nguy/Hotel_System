# Quick Start Guide - Room Availability Features

## How to Use the New Features

### 1. Homepage (Welcome Page) - Search All Rooms

**Location:** http://your-domain.com/

**Steps:**

1. Scroll down to the "Search Available Rooms" section
2. Select your **Check-in Date**
3. Select your **Check-out Date**
4. (Optional) Choose a specific **Room Type** from dropdown
5. Select number of **Adults** and **Children**
6. Click **"Check Now"** button

**Result:**

- Available rooms will display below the form
- You'll see room images, names, descriptions, and capacity
- Click "Book Now" on any room to proceed

---

### 2. Room Type Page (Rooms2) - Search by Type

**Location:** http://your-domain.com/rooms2?type=LP001

**Steps:**

1. Page loads with rooms of a specific type
2. Scroll to "Check Available Rooms" section
3. Select your **Check-in Date**
4. Select your **Check-out Date**
5. Select number of **Adults** and **Children**
6. Click **"Check Availability"** button

**Result:**

- Only available rooms of THIS specific type will display
- Results show below the form
- Each room has "Book Now" and "Details" buttons

---

### 3. Room Details Page - Check Specific Room

**Location:** http://your-domain.com/roomdetails.php?id=P001

**Steps:**

1. View room details at the top of the page
2. Scroll down to "Check Room Availability" section
3. Select your **Check-in Date** (may be pre-filled if coming from search)
4. Select your **Check-out Date** (may be pre-filled if coming from search)
5. Select number of **Adults** and **Children**
6. Click **"Check Availability"** button

**Result:**

- ✅ **GREEN MESSAGE**: Room is available - "Proceed to Booking" button appears
- ❌ **RED MESSAGE**: Room is not available - try different dates
- ⚠️ **YELLOW MESSAGE**: Error occurred - try again

---

## Date Selection Rules

### Automatic Validations:

- ✅ Check-in date cannot be in the past
- ✅ Check-out date must be after check-in date
- ✅ Minimum stay: 1 night
- ✅ When you change check-in, check-out minimum updates automatically

### Date Format:

- All dates use calendar date picker (HTML5)
- Format: YYYY-MM-DD (2025-10-20)
- No need to type manually - just click and select

---

## Guest Selection

### Adults:

- Minimum: 1 Adult
- Maximum: 4 Adults
- Default: 2 Adults

### Children:

- Minimum: 0 Children
- Maximum: 4 Children
- Default: 0 Children

**Note:** Make sure total guests don't exceed room capacity!

---

## Navigation Flow

### Option 1: Browse First, Then Check Dates

```
Homepage → Browse Room Types → Select Room → Check Availability
```

### Option 2: Search by Dates First

```
Homepage → Enter Dates → Search → See Available Rooms → Select Room
```

### Option 3: Direct to Room Type

```
Room Type Page → Enter Dates → See Available → Book Specific Room
```

---

## Search Results Display

### What You'll See:

**Each Available Room Shows:**

- 📷 Room Photo
- 🏷️ Room Number
- 🛏️ Room Type Name
- 📝 Brief Description
- 👥 Maximum Guests Capacity
- 🔗 "Book Now" Button
- 🔗 "Details" Button

### Result Counts:

- "Available Rooms (5 found)" - Shows how many rooms match your search
- "No Available Rooms" - No rooms available for selected dates

---

## Booking Flow Example

### Complete User Journey:

1. **Start:** Go to homepage
2. **Search:** Select dates Oct 20-22, 2025
3. **Filter:** Choose "Deluxe Room" type
4. **Click:** "Check Now" button
5. **View:** See 3 available Deluxe rooms
6. **Select:** Click "Book Now" on Room 201
7. **Details:** See room details with dates pre-filled
8. **Verify:** Click "Check Availability" to confirm
9. **Success:** ✅ Room available message
10. **Book:** Click "Proceed to Booking" (future feature)

---

## Troubleshooting

### "No available rooms found"

- ✅ Try different dates
- ✅ Try different room types
- ✅ Expand your date range
- ✅ Check if hotel is fully booked for major holidays

### "An error occurred"

- ✅ Check your internet connection
- ✅ Refresh the page
- ✅ Try again in a few moments
- ✅ Contact support if persists

### "Check-out must be after check-in"

- ✅ Make sure check-out date is AFTER check-in date
- ✅ Minimum stay is 1 night
- ✅ Try selecting check-in first, then check-out

### Dates not showing/selecting

- ✅ Make sure you're using a modern browser
- ✅ Clear browser cache
- ✅ Try Chrome, Firefox, or Edge (latest versions)

---

## Mobile Device Usage

### On Smartphones/Tablets:

- 📱 Use native date picker (iOS/Android calendar)
- 📱 Results display in single column for readability
- 📱 Touch-friendly buttons and forms
- 📱 Smooth scrolling between sections

---

## Tips for Best Experience

### 1. **Plan Ahead**

- Book early for better availability
- Popular dates fill up quickly

### 2. **Be Flexible**

- Try weekdays for better availability
- Consider alternative room types

### 3. **Use Filters**

- Select room type to narrow search
- Check capacity matches your party size

### 4. **Save Your Dates**

- Dates persist when navigating between pages
- Bookmark URLs with dates to share

### 5. **Check Details**

- Read full room description
- Review amenities and features
- Verify maximum capacity

---

## Contact Information

**For Reservations:**
📞 Phone: 855 100 4444 (Toll-free)
📧 Email: info@luxuryhotel.com

**Office Hours:**
🕐 Monday - Friday: 9:00 AM - 6:00 PM
🕐 Saturday - Sunday: 10:00 AM - 4:00 PM

---

## Quick Reference: API Endpoints

For developers or advanced users:

```
GET /api/rooms/available
  ?check_in=2025-10-20&check_out=2025-10-22

GET /api/rooms/available/by_type
  ?check_in=2025-10-20&check_out=2025-10-22&room_type_id=LP001

GET /api/rooms/available/by_room
  ?check_in=2025-10-20&check_out=2025-10-22&id=P001
```

---

## Browser Compatibility

### Recommended Browsers:

- ✅ Google Chrome 90+
- ✅ Mozilla Firefox 88+
- ✅ Microsoft Edge 90+
- ✅ Safari 14+

### Not Recommended:

- ❌ Internet Explorer (any version)
- ❌ Very old browser versions

---

## Accessibility Features

- ♿ Keyboard navigation supported
- ♿ Screen reader friendly
- ♿ High contrast mode compatible
- ♿ Focus indicators visible
- ♿ Form labels properly associated

---

## Privacy & Data

### What We Store:

- Search criteria (temporary, session-based)
- Selected dates for navigation
- Guest count preferences

### What We DON'T Store:

- Personal information (until booking)
- Payment details (not yet implemented)
- Search history long-term

---

## Next Steps After Checking Availability

1. ✅ Room shows as available
2. 📝 Review room details and amenities
3. 💰 Check pricing information
4. 📅 Confirm your dates
5. 👤 Proceed to booking (coming soon)
6. 💳 Complete payment (coming soon)
7. 📧 Receive confirmation email (coming soon)

---

**Last Updated:** October 2025
**Version:** 1.0
