<div class="public-livewire-page">

<!-- Page Header -->
@php
    $roomHeroImage = '';
    if ($room && $room->cover_image) {
        $roomHeroImage = asset('storage/' . $room->cover_image);
    } elseif ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $roomHeroImage = asset('storage/' . $about?->image2);
        } else {
            $roomHeroImage = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $roomHeroImage = asset('storage/images/about/default.jpg');
    }
@endphp
<div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $roomHeroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="page__hero__content">
                    <h1 class="wow fadeInUp">{{ $room->title }}</h1>
                    <p class="wow fadeInUp font-sm">Experience luxury and comfort in our beautifully designed room</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Room Details Area -->
<div class="rts__section section__padding">
    <div class="container">
        <div class="row g-5 sticky-wrap">
            <!-- Room Images Carousel (Right Side) -->
            <div class="col-lg-7 order-2 order-lg-1 room-gallery-col">
                <div class="room__details">
                    @php
                        // Combine cover image with gallery images
                        $allImages = collect();
                        if ($room->cover_image) {
                            $allImages->push((object)['image' => $room->cover_image, 'is_cover' => true]);
                        }
                        if ($images && count($images) > 0) {
                            foreach ($images as $img) {
                                $allImages->push((object)['image' => $img->image, 'is_cover' => false]);
                            }
                        }
                    @endphp
                    @if($allImages->count() > 0)
                        <div class="image-gallery-wrapper mb-4">
                            <!-- Main Image Display -->
                            <div class="gallery-main-image">
                                <img id="roomMainImage" 
                                     src="{{ asset('storage/' . $allImages->first()->image) }}" 
                                     alt="{{ $room->title }} - Main Image"
                                     loading="eager"
                                     class="gallery-main-img">
                            </div>
                            
                            <!-- Thumbnail Gallery -->
                            @if($allImages->count() > 1)
                                <div class="gallery-thumbnails">
                                    @foreach($allImages as $key => $img)
                                        <div class="thumbnail-item {{ $key === 0 ? 'active' : '' }}" 
                                             data-image="{{ asset('storage/' . $img->image) }}"
                                             data-index="{{ $key }}">
                                            <img src="{{ asset('storage/' . $img->image) }}" 
                                                 alt="{{ $room->title }} - Thumbnail {{ $key + 1 }}"
                                                 loading="lazy"
                                                 class="thumbnail-img">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="room__feature__image mb-10" style="border-radius: 10px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.15);">
                            <img class="rounded-2" 
                                 src="{{ asset('storage/' . ($room->cover_image ?? 'rooms/default.jpg')) }}" 
                                 alt="Main Room Image"
                                 loading="eager"
                                 style="width: 100%; height: 550px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>

            <!-- Room Details (Left Side) -->
            <div class="col-lg-5 order-1 order-lg-2 room-details-col">
                <div class="room__details">
                    <div class="d-flex justify-content-between align-items-center mb-30">
                        <h2 class="room__title">{{ $room->title }}</h2>
                        <div class="text-end">
                            <span class="h4 price" style="color: #0356b7; font-weight: 600;">
                                ${{ number_format($room->price ?? 0, 0) }}<span class="h6 fw-normal">/night</span>
                            </span>
                            <p class="mb-0 small text-muted" style="max-width: 280px; margin-left: auto;">
                                Base rate covers up to <strong>{{ (int) ($room->guests_included_in_price ?? 2) }}</strong> guest(s).
                                @if($room->max_occupancy)
                                    Max {{ $room->max_occupancy }} guest(s).
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($room->extra_adult_price || $room->extra_child_price || $room->extra_bed_price)
                    <div class="mb-20 p-3" style="background: #eef6ff; border-radius: 8px; border: 1px solid #cfe2ff;">
                        <strong class="d-block mb-2" style="color: #0356b7;">Additional rates (per night)</strong>
                        <ul class="mb-0 ps-3 small">
                            @if($room->extra_adult_price)
                                <li>Extra adult (beyond included guests): <strong>${{ number_format($room->extra_adult_price, 0) }}</strong></li>
                            @endif
                            @if($room->extra_child_price)
                                <li>Extra child (beyond included guests): <strong>${{ number_format($room->extra_child_price, 0) }}</strong></li>
                            @endif
                            @if($room->extra_bed_price)
                                <li>Extra bed: <strong>${{ number_format($room->extra_bed_price, 0) }}</strong></li>
                            @endif
                        </ul>
                    </div>
                    @endif

                    <!-- Room Info -->
                    <div class="mb-30" style="display: flex; gap: 30px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                        @if($room->max_occupancy)
                        <div>
                            <i class="fas fa-users" style="color: #0356b7; font-size: 20px;"></i>
                            <p class="mb-0 mt-2"><strong>Max Guests:</strong> {{ $room->max_occupancy }}</p>
                        </div>
                        @endif
                        @if($room->bed_count)
                        <div>
                            <i class="fas fa-bed" style="color: #0356b7; font-size: 20px;"></i>
                            <p class="mb-0 mt-2"><strong>Beds:</strong> {{ $room->bed_count }} {{ $room->bed_type ?? '' }}</p>
                        </div>
                        @endif
                        @if($room->room_number)
                        <div>
                            <i class="fas fa-door-open" style="color: #0356b7; font-size: 20px;"></i>
                            <p class="mb-0 mt-2"><strong>Room #:</strong> {{ $room->room_number }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Amenities + description moved below (below gallery, full width). -->
                </div>
            </div>
        </div>

        <!-- Room Description (full width, below gallery) -->
        <div class="row mt-30">
            <div class="col-12">
                <div class="mb-30">
                    <h4 class="mb-20">Description</h4>
                    <div style="line-height: 1.8; color: #666;">
                        {!! $room->description !!}
                    </div>
                </div>
            </div>
        </div>

        @php
            $hasAmenities = isset($amenities) && $amenities && $amenities->count() > 0;
        @endphp

        <!-- Amenities + Booking Form (same row) -->
        <div class="row mt-50 g-4" id="booking">
            @if($hasAmenities)
                <div class="col-lg-5">
                    <div class="mb-30">
                        <h4 class="mb-20">Room Amenities</h4>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                            @foreach($amenities as $amenity)
                                <div style="display: flex; align-items: center; padding: 8px; background: #f9f9f9; border-radius: 5px;">
                                    <span style="margin-right: 8px; color: #0356b7;">✓</span>
                                    {{ $amenity->title }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
            @else
                <div class="col-12">
            @endif
                <div class="rts__booking__form has__background" style="padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); height: 100%;">
                    <div class="d-flex align-items-baseline justify-content-center gap-2 mb-30 flex-wrap">
                        <h3 class="mb-0">Booking for '<span style="color: #0356b7;">{{ $room->title }}</span>'</h3>
                        <span class="h5 mb-0" style="color: #0356b7; font-weight: 700;">
                            - ${{ number_format($room->price ?? 0, 0) }}/Night
                        </span>
                    </div>
                    <form action="{{ route('bookNow') }}" method="POST" id="bookingForm">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">
                        
                        <div class="row g-20 align-items-start">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Check In <span class="text-danger">*</span></label>
                                <input type="date" 
                                       id="checkin_date" 
                                       name="checkin" 
                                       class="form-control" 
                                       required 
                                       min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Check Out <span class="text-danger">*</span></label>
                                <input type="date" 
                                       id="checkout_date" 
                                       name="checkout" 
                                       class="form-control" 
                                       required 
                                       min="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Adults <span class="text-danger">*</span></label>
                                <input type="number" 
                                       id="adults" 
                                       name="adults" 
                                       class="form-control" 
                                       min="1" 
                                       value="1" 
                                       required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Children</label>
                                <input type="number" 
                                       id="children" 
                                       name="children" 
                                       class="form-control" 
                                       min="0" 
                                       value="0">
                                <small class="text-muted d-block mt-1">Children 6-12. 13+ counts as adult.</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div id="guest-capacity-alert" class="alert alert-warning py-2 px-3" style="display: none;">
                                    <div class="small">
                                        <strong>More rooms needed.</strong>
                                        <span id="guest-capacity-alert-text"></span>
                                    </div>
                                    <button type="button" id="guest-capacity-apply" class="btn btn-sm btn-primary mt-2">
                                        Set to suggested rooms
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Number of Rooms</label>
                                <input type="number" id="book_rooms" name="rooms" class="form-control" min="1" value="1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Extra beds (optional)</label>
                                <input type="number"
                                       id="extra_beds"
                                       name="extra_beds"
                                       class="form-control"
                                       min="0"
                                       value="0">
                                {{-- <small class="text-muted d-block mt-1">Extra beds (if applicable).</small> --}}
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="names" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Special Requests</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="Any special requests or notes..."></textarea>
                            </div>
                            
                            <!-- Price Calculation Display -->
                            <div class="col-12 mb-3" style="background: #f9f9f9; padding: 20px; border-radius: 8px;">
                                <p class="small text-muted mb-2">Includes up to {{ (int) ($room->guests_included_in_price ?? 2) }} guests per room.</p>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span>Base room (per night)</span>
                                    <span id="line_base">${{ number_format($room->price ?? 0, 2) }}</span>
                                </div>
                                <div id="row_extra_adults" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span id="label_extra_adults">Extra adults</span>
                                    <span id="line_extra_adults">$0.00</span>
                                </div>
                                <div id="row_extra_children" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span id="label_extra_children">Extra children</span>
                                    <span id="line_extra_children">$0.00</span>
                                </div>
                                <div id="row_extra_beds" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span id="label_extra_beds">Extra beds</span>
                                    <span id="line_extra_beds">$0.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-top: 8px; border-top: 1px solid #ddd;">
                                    <span><strong>Estimated rate (per night)</strong></span>
                                    <span id="room_price_nightly"><strong>$0.00</strong></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <div style="flex: 1;">
                                        <span><strong>Nights</strong></span>
                                        <div class="d-flex align-items-center gap-2" style="margin-top: 6px;">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="nights_minus">-</button>
                                            <span id="nights_count" style="min-width: 34px; text-align: center; font-weight: 600;">1</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="nights_plus">+</button>
                                        </div>
                                    </div>
                                    <div style="flex: 1; text-align: right;">
                                        <span><strong>Rooms</strong></span>
                                        <div class="d-flex align-items-center justify-content-end gap-2" style="margin-top: 6px;">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="rooms_minus">-</button>
                                            <span id="rooms_count" style="min-width: 34px; text-align: center; font-weight: 600;">1</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="rooms_plus">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-top: 10px; border-top: 2px solid #ddd;">
                                    <span><strong>Subtotal:</strong></span>
                                    <span id="subtotal">$0.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span>VAT portion (included):</span>
                                    <span id="tax">$0.00</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 2px solid #0356b7; font-size: 18px; font-weight: 600;">
                                    <span><strong>Total Amount:</strong></span>
                                    <span id="total_amount" style="color: #0356b7;">$0.00</span>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="theme-btn btn-style fill" style="width: 100%; padding: 15px; font-size: 18px;">
                                    <span>Submit your Booking</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room Details End -->

<!-- Similar Rooms -->
@if($allRooms && $allRooms->count() > 0)
<div class="rts__section" style="padding: 80px 0; background-color: #f9f9f9;">
    <div class="container">
        <div class="row justify-content-center text-center mb-40">
            <div class="col-lg-6">
                <div class="section__topbar">
                    <h2>Other Rooms</h2>
                </div>
            </div>
        </div>
        <div class="row g-30">
            @foreach ($allRooms as $similarRoom)
            <div class="col-lg-4 col-md-6">
                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); transition: transform 0.3s;">
                    <div>
                        <a href="{{ route('room',['slug'=>$similarRoom->slug]) }}">
                            <img src="{{ $similarRoom->publicThumbnailUrl() }}"
                                 alt="{{ $similarRoom->title }}"
                                 style="width: 100%; height: 250px; object-fit: cover;"
                                 loading="lazy">
                        </a>
                    </div>
                    <div style="padding: 20px;">
                        <a href="{{ route('room',['slug'=>$similarRoom->slug]) }}" 
                           style="font-size: 20px; font-weight: 600; color: #222; text-decoration: none; display: block; margin-bottom: 10px;">
                            {{ $similarRoom->title }}
                        </a>
                        <div style="font-size: 18px; font-weight: bold; color: #0356b7; margin-bottom: 15px;">
                            ${{ number_format($similarRoom->price, 0) }}/Night
                        </div>
                        <a href="{{ route('room',['slug'=>$similarRoom->slug]) }}" 
                           class="theme-btn btn-style sm-btn fill" 
                           style="width: 100%; text-align: center;">
                            <span>View Details</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
<!-- Similar Rooms End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkinInput = document.getElementById('checkin_date');
    const checkoutInput = document.getElementById('checkout_date');
    const adultsInput = document.getElementById('adults');
    const childrenInput = document.getElementById('children');
    const extraBedsInput = document.getElementById('extra_beds');
    const roomsInput = document.getElementById('book_rooms');

    const basePrice = {{ (float) ($room->price ?? 0) }};
    const guestsIncluded = {{ (int) ($room->guests_included_in_price ?? 2) }};
    const extraAdultRate = {{ (float) ($room->extra_adult_price ?? 0) }};
    const extraChildRate = {{ (float) ($room->extra_child_price ?? 0) }};
    const extraBedRate = {{ (float) ($room->extra_bed_price ?? 0) }};

    const lineBase = document.getElementById('line_base');
    const lineExtraAdults = document.getElementById('line_extra_adults');
    const lineExtraChildren = document.getElementById('line_extra_children');
    const lineExtraBeds = document.getElementById('line_extra_beds');
    const rowExtraAdults = document.getElementById('row_extra_adults');
    const rowExtraChildren = document.getElementById('row_extra_children');
    const rowExtraBeds = document.getElementById('row_extra_beds');
    const labelExtraAdults = document.getElementById('label_extra_adults');
    const labelExtraChildren = document.getElementById('label_extra_children');
    const labelExtraBeds = document.getElementById('label_extra_beds');
    const roomPriceNightly = document.getElementById('room_price_nightly');
    const subtotalEl = document.getElementById('subtotal');
    const taxEl = document.getElementById('tax');
    const totalEl = document.getElementById('total_amount');
    const nightsEl = document.getElementById('nights_count');
    const roomsCountEl = document.getElementById('rooms_count');

    const nightsMinusBtn = document.getElementById('nights_minus');
    const nightsPlusBtn = document.getElementById('nights_plus');
    const roomsMinusBtn = document.getElementById('rooms_minus');
    const roomsPlusBtn = document.getElementById('rooms_plus');

    const guestCapacityAlert = document.getElementById('guest-capacity-alert');
    const guestCapacityAlertText = document.getElementById('guest-capacity-alert-text');
    const guestCapacityApply = document.getElementById('guest-capacity-apply');

    const maxGuestsPerRoom = {{ (int) ($room->max_occupancy ?? 0) }};
    let suggestedRoomsForCapacity = 1;

    let nightsValue = 1;

    function pad2(n) {
        return String(n).padStart(2, '0');
    }

    function formatDateInputValue(date) {
        return date.getFullYear() + '-' + pad2(date.getMonth() + 1) + '-' + pad2(date.getDate());
    }

    function getNightsFromDates() {
        if (!checkinInput?.value || !checkoutInput?.value) return null;
        const checkinDate = new Date(checkinInput.value + 'T00:00:00');
        const checkoutDate = new Date(checkoutInput.value + 'T00:00:00');
        if (!(checkoutDate > checkinDate)) return null;
        const diffTime = checkoutDate - checkinDate;
        return Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
    }

    function setCheckoutFromNights(nights) {
        const nightsInt = Math.max(1, parseInt(nights, 10) || 1);
        if (!checkinInput?.value) return;
        const checkinDate = new Date(checkinInput.value + 'T00:00:00');
        checkinDate.setDate(checkinDate.getDate() + nightsInt);
        checkoutInput.value = formatDateInputValue(checkinDate);
    }

    function syncNightsAndRoomsUI(roomCount) {
        if (nightsEl) nightsEl.textContent = nightsValue;
        if (roomsCountEl) roomsCountEl.textContent = roomCount;
    }

    if (guestCapacityApply) {
        guestCapacityApply.addEventListener('click', function () {
            roomsInput.value = suggestedRoomsForCapacity;
            calculateTotal();
        });
    }

    if (nightsMinusBtn) {
        nightsMinusBtn.addEventListener('click', function () {
            nightsValue = Math.max(1, nightsValue - 1);
            setCheckoutFromNights(nightsValue);
            calculateTotal();
        });
    }

    if (nightsPlusBtn) {
        nightsPlusBtn.addEventListener('click', function () {
            nightsValue = nightsValue + 1;
            setCheckoutFromNights(nightsValue);
            calculateTotal();
        });
    }

    if (roomsMinusBtn) {
        roomsMinusBtn.addEventListener('click', function () {
            const current = Math.max(1, parseInt(roomsInput.value, 10) || 1);
            roomsInput.value = current - 1 >= 1 ? current - 1 : 1;
            calculateTotal();
        });
    }

    if (roomsPlusBtn) {
        roomsPlusBtn.addEventListener('click', function () {
            const current = Math.max(1, parseInt(roomsInput.value, 10) || 1);
            roomsInput.value = current + 1;
            calculateTotal();
        });
    }

    function computeExtras(adults, children) {
        let remaining = Math.max(1, guestsIncluded);
        const adultsCovered = Math.min(adults, remaining);
        remaining -= adultsCovered;
        const childrenCovered = Math.min(children, remaining);
        return {
            extraAdults: adults - adultsCovered,
            extraChildren: children - childrenCovered
        };
    }

    function fmt(n) {
        return '$' + n.toFixed(2);
    }

    function calculateTotal() {
        const checkin = new Date(checkinInput.value);
        const checkout = new Date(checkoutInput.value);
        const adults = Math.max(0, parseInt(adultsInput.value, 10) || 0);
        const children = Math.max(0, parseInt(childrenInput.value, 10) || 0);
        const extraBeds = Math.max(0, parseInt(extraBedsInput.value, 10) || 0);
        let roomCount = Math.max(1, parseInt(roomsInput.value, 10) || 1);

        const nightsFromDates = getNightsFromDates();
        if (nightsFromDates) nightsValue = nightsFromDates;

        syncNightsAndRoomsUI(roomCount);

        const totalGuests = adults + children;
        if (guestCapacityAlert && maxGuestsPerRoom > 0 && totalGuests > (maxGuestsPerRoom * roomCount)) {
            suggestedRoomsForCapacity = Math.max(1, Math.ceil(totalGuests / maxGuestsPerRoom));

            // Auto-increase "Number of Rooms" to the minimum required.
            if (roomsInput && roomCount < suggestedRoomsForCapacity) {
                roomsInput.value = suggestedRoomsForCapacity;
                roomCount = suggestedRoomsForCapacity;
            }

            guestCapacityAlert.style.display = 'block';
            guestCapacityApply && (guestCapacityApply.textContent = 'Set to ' + suggestedRoomsForCapacity + ' rooms');
            guestCapacityAlertText.textContent = 'For ' + totalGuests + ' guests, this room holds up to ' + maxGuestsPerRoom + ' per room. Suggested: ' + suggestedRoomsForCapacity + ' rooms.';
        } else if (guestCapacityAlert) {
            guestCapacityAlert.style.display = 'none';
        }

        const { extraAdults, extraChildren } = computeExtras(adults, children);
        const costExtraAdults = extraAdults * extraAdultRate;
        const costExtraChildren = extraChildren * extraChildRate;
        const costExtraBeds = extraBeds * extraBedRate;
        const nightly = basePrice + costExtraAdults + costExtraChildren + costExtraBeds;

        lineBase.textContent = fmt(basePrice);
        lineExtraAdults.textContent = fmt(costExtraAdults);
        lineExtraChildren.textContent = fmt(costExtraChildren);
        lineExtraBeds.textContent = fmt(costExtraBeds);

        // Hide extra-charge rows when their computed cost is 0
        if (rowExtraAdults) rowExtraAdults.style.display = costExtraAdults > 0 ? 'flex' : 'none';
        if (rowExtraChildren) rowExtraChildren.style.display = costExtraChildren > 0 ? 'flex' : 'none';
        if (rowExtraBeds) rowExtraBeds.style.display = costExtraBeds > 0 ? 'flex' : 'none';
        labelExtraAdults.textContent = extraAdults > 0
            ? 'Extra adults (×' + extraAdults + ')'
            : 'Extra adults';
        labelExtraChildren.textContent = extraChildren > 0
            ? 'Extra children (×' + extraChildren + ')'
            : 'Extra children';
        labelExtraBeds.textContent = extraBeds > 0
            ? 'Extra beds (×' + extraBeds + ')'
            : 'Extra beds';
        roomPriceNightly.innerHTML = '<strong>' + fmt(nightly) + '</strong>';

        if (nightsFromDates && checkin && checkout && checkout > checkin) {
            const nights = nightsFromDates;

            const subtotal = nightly * nights * roomCount;
            // VAT is already included in the price; show the VAT portion only.
            const vatPortion = subtotal * (0.10 / 1.10);
            const total = subtotal;

            subtotalEl.textContent = fmt(subtotal);
            taxEl.textContent = fmt(vatPortion);
            totalEl.textContent = fmt(total);
        } else {
            subtotalEl.textContent = fmt(0);
            taxEl.textContent = fmt(0);
            totalEl.textContent = fmt(0);
        }
    }

    checkinInput.addEventListener('change', function() {
        if (checkoutInput.value) {
            checkoutInput.min = this.value;
        }
        if (checkinInput.value) {
            // Keep checkout date in sync with the selected number of nights.
            const nightsReady = nightsValue && nightsValue >= 1;
            if (nightsReady) {
                // If checkout is missing/invalid, reset it.
                const nightsFromDates = getNightsFromDates();
                if (!nightsFromDates || (checkoutInput.value && new Date(checkoutInput.value) <= new Date(checkinInput.value))) {
                    setCheckoutFromNights(nightsValue);
                }
            }
        }
        calculateTotal();
    });

    checkoutInput.addEventListener('change', function() {
        if (checkinInput.value) {
            if (this.value <= checkinInput.value) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Dates',
                        text: 'Check-out date must be after check-in date',
                        confirmButtonColor: '#0356b7'
                    });
                } else {
                    alert('Check-out date must be after check-in date');
                }
                this.value = '';
                return;
            }
        }
        const nightsFromDates = getNightsFromDates();
        if (nightsFromDates) nightsValue = nightsFromDates;
        calculateTotal();
    });

    [adultsInput, childrenInput, extraBedsInput, roomsInput].forEach(function (el) {
        if (el) {
            el.addEventListener('input', calculateTotal);
            el.addEventListener('change', calculateTotal);
        }
    });

    calculateTotal();
});

// Image Gallery Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('roomMainImage');
    const thumbnails = document.querySelectorAll('.gallery-thumbnails .thumbnail-item');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const newImageSrc = this.getAttribute('data-image');
                
                // Remove active class from all thumbnails
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                this.classList.add('active');
                
                // Fade out main image
                mainImage.style.opacity = '0';
                
                // After fade out, change image and fade in
                setTimeout(() => {
                    mainImage.src = newImageSrc;
                    mainImage.style.opacity = '1';
                }, 200);
            });
        });
    }
});
</script>

<style>
/* Image Gallery Styles */
.image-gallery-wrapper {
    width: 100%;
}

.gallery-main-image {
    width: 100%;
    margin-bottom: 15px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    background: #f8f9fa;
    position: relative;
    aspect-ratio: 16/10;
}

.gallery-main-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: opacity 0.4s ease-in-out;
    opacity: 1;
}

.gallery-thumbnails {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    padding: 5px 0;
    scrollbar-width: thin;
    scrollbar-color: rgba(0, 0, 0, 0.3) transparent;
}

.gallery-thumbnails::-webkit-scrollbar {
    height: 6px;
}

.gallery-thumbnails::-webkit-scrollbar-track {
    background: transparent;
}

.gallery-thumbnails::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.3);
    border-radius: 3px;
}

.thumbnail-item {
    flex: 0 0 auto;
    width: 100px;
    height: 100px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s ease;
    position: relative;
    background: #f8f9fa;
}

.thumbnail-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.thumbnail-item.active {
    border-color: #0356b7;
    box-shadow: 0 0 0 2px rgba(3, 86, 183, 0.2), 0 4px 12px rgba(3, 86, 183, 0.3);
}

.thumbnail-item.active::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(3, 86, 183, 0.1);
    pointer-events: none;
}

.thumbnail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.thumbnail-item:hover .thumbnail-img {
    transform: scale(1.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .gallery-main-image {
        aspect-ratio: 4/3;
    }
    
    .thumbnail-item {
        width: 80px;
        height: 80px;
    }
    
    .gallery-thumbnails {
        gap: 8px;
    }
}

@media (max-width: 576px) {
    .thumbnail-item {
        width: 70px;
        height: 70px;
    }
}

@media (min-width: 992px) {
    /* Exact 60/40 split for the room gallery vs details section */
    .room-gallery-col {
        flex: 0 0 60%;
        max-width: 60%;
    }
    .room-details-col {
        flex: 0 0 40%;
        max-width: 40%;
    }
}
</style>
</div>
