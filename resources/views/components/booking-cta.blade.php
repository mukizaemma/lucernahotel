@props([
    'rooms',
    'setting' => null,
    'eyebrow' => 'Book your stay',
    'title' => 'Reserve your perfect room',
    'lead' => 'Tell us your dates and preferences — we\'ll follow up to confirm availability and make your arrival seamless.',
    'headingId' => 'booking-cta-heading',
    'idSuffix' => '',
    'showChildrenField' => false,
])

@php
    $roomList = $rooms instanceof \Illuminate\Support\Collection ? $rooms : collect($rooms ?? []);
    $setting = $setting ?? \App\Models\Setting::first();
@endphp

<section class="home-cta rts__section section__padding" aria-labelledby="{{ $headingId }}">
    <div class="container">
        <div class="home-cta__intro text-center wow fadeInUp">
            <p class="home-cta__eyebrow">{{ $eyebrow }}</p>
            <h2 id="{{ $headingId }}" class="home-cta__title section__title">{{ $title }}</h2>
            <p class="home-cta__lead font-sm">{{ $lead }}</p>
        </div>

        <div class="row g-4 g-xl-4 align-items-stretch">
            <div class="col-lg-6 wow fadeInLeft d-flex">
                @include('frontend.includes.cta-map-panel', ['setting' => $setting])
            </div>

            <div class="col-lg-6 wow fadeInRight d-flex">
                <div class="home-cta__panel home-cta__panel--form w-100">
                    <div class="home-cta__form-badge">
                        <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                        <span>Request availability</span>
                    </div>
                    <p class="home-cta__form-note">Fields marked <span class="home-cta__req" aria-hidden="true">*</span> are required.</p>

                    @if(session('success'))
                        <div class="home-cta__alert home-cta__alert--success" role="status">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="home-cta__alert home-cta__alert--error" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="home-cta__alert home-cta__alert--error" role="alert">
                            <ul class="home-cta__alert-list mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('bookNow') }}" method="POST" class="home-cta__form booking__form">
                        @csrf

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="{{ $showChildrenField ? 'col-md-6' : 'col-md-8' }}">
                                    <label for="room_id{{ $idSuffix }}" class="home-cta__label">Select room <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <select name="room_id" id="room_id{{ $idSuffix }}" class="form-control home-cta__input home-cta__input--select" required>
                                            <option value="">Choose a room…</option>
                                            @foreach($roomList as $roomOption)
                                                <option
                                                    value="{{ $roomOption->id }}"
                                                    data-max-occupancy="{{ (int) ($roomOption->max_occupancy ?? 0) }}"
                                                >
                                                    {{ $roomOption->title }} — ${{ number_format($roomOption->price, 0) }}/night
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="{{ $showChildrenField ? 'col-md-3' : 'col-md-4' }}">
                                    <label for="adults{{ $idSuffix }}" class="home-cta__label">Adults <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="number" name="adults" id="adults{{ $idSuffix }}" class="form-control home-cta__input" required min="1" value="1" inputmode="numeric">
                                    </div>
                                </div>
                                @if($showChildrenField)
                                    <div class="col-md-3">
                                        <label for="children{{ $idSuffix }}" class="home-cta__label">Children</label>
                                        <div class="home-cta__field">
                                            <input type="number" name="children" id="children{{ $idSuffix }}" class="form-control home-cta__input" min="0" value="0" inputmode="numeric">
                                        </div>
                                        <small class="text-muted d-block mt-1">Children 6-12. 13+ counts as adult.</small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label for="rooms{{ $idSuffix }}" class="home-cta__label">Number of Rooms</label>
                                    <div class="home-cta__field">
                                        <input
                                            type="number"
                                            name="rooms"
                                            id="rooms{{ $idSuffix }}"
                                            class="form-control home-cta__input"
                                            min="1"
                                            value="1"
                                            inputmode="numeric"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="extra_beds{{ $idSuffix }}" class="home-cta__label">Extra beds (optional)</label>
                                    <div class="home-cta__field">
                                        <input
                                            type="number"
                                            name="extra_beds"
                                            id="extra_beds{{ $idSuffix }}"
                                            class="form-control home-cta__input"
                                            min="0"
                                            value="0"
                                            inputmode="numeric"
                                        >
                                    </div>
                                    <small class="text-muted d-block mt-1">Extra beds (if applicable).</small>
                                </div>
                            </div>

                            <div
                                id="guest-capacity-alert{{ $idSuffix }}"
                                class="alert alert-warning py-2 px-3"
                                style="display: none; margin-top: 12px;"
                            >
                                <div class="small">
                                    <strong>More rooms needed.</strong>
                                    <span id="guest-capacity-alert-text{{ $idSuffix }}"></span>
                                </div>
                                <button type="button" id="guest-capacity-apply{{ $idSuffix }}" class="btn btn-sm btn-primary mt-2">
                                    Set to suggested rooms
                                </button>
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="checkin{{ $idSuffix }}" class="home-cta__label">Check-in <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="date" name="checkin" id="checkin{{ $idSuffix }}" class="form-control home-cta__input" required min="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="checkout{{ $idSuffix }}" class="home-cta__label">Check-out <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="date" name="checkout" id="checkout{{ $idSuffix }}" class="form-control home-cta__input" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <label for="names{{ $idSuffix }}" class="home-cta__label">Full name <span class="home-cta__req">*</span></label>
                            <div class="home-cta__field">
                                <input type="text" name="names" id="names{{ $idSuffix }}" class="form-control home-cta__input" required autocomplete="name">
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="phone{{ $idSuffix }}" class="home-cta__label">Phone <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="tel" name="phone" id="phone{{ $idSuffix }}" class="form-control home-cta__input" required autocomplete="tel">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email{{ $idSuffix }}" class="home-cta__label">Email <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="email" name="email" id="email{{ $idSuffix }}" class="form-control home-cta__input" required autocomplete="email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <label for="message{{ $idSuffix }}" class="home-cta__label">Special requests <span class="home-cta__label-opt">(optional)</span></label>
                            <div class="home-cta__field">
                                <textarea name="message" id="message{{ $idSuffix }}" class="form-control home-cta__input home-cta__input--textarea" rows="3" placeholder="Dietary needs, late arrival, celebration, etc."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="theme-btn btn-style fill w-100 home-cta__submit">
                            <span>Submit booking request <i class="fa-solid fa-arrow-right home-cta__submit-icon" aria-hidden="true"></i></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const idSuffix = @json($idSuffix);
    const roomSelect = document.getElementById('room_id' + idSuffix);
    const adultsInput = document.getElementById('adults' + idSuffix);
    const childrenInput = document.getElementById('children' + idSuffix);
    const roomsInput = document.getElementById('rooms' + idSuffix);

    const guestCapacityAlert = document.getElementById('guest-capacity-alert' + idSuffix);
    const guestCapacityAlertText = document.getElementById('guest-capacity-alert-text' + idSuffix);
    const guestCapacityApply = document.getElementById('guest-capacity-apply' + idSuffix);

    if (!roomSelect || !adultsInput || !roomsInput || !guestCapacityAlert || !guestCapacityAlertText) return;

    let suggestedRoomsForCapacity = 1;

    function getMaxGuestsPerRoom() {
        if (!roomSelect || roomSelect.selectedIndex < 0) return 0;
        const opt = roomSelect.options[roomSelect.selectedIndex];
        const max = parseInt(opt?.dataset?.maxOccupancy || '0', 10);
        return Number.isFinite(max) ? max : 0;
    }

    function updateCapacity() {
        const maxGuestsPerRoom = getMaxGuestsPerRoom();
        const adults = Math.max(0, parseInt(adultsInput.value, 10) || 0);
        const children = childrenInput ? Math.max(0, parseInt(childrenInput.value, 10) || 0) : 0;
        const roomsCount = Math.max(1, parseInt(roomsInput.value, 10) || 1);

        const totalGuests = adults + children;

        if (maxGuestsPerRoom > 0 && totalGuests > (maxGuestsPerRoom * roomsCount)) {
            suggestedRoomsForCapacity = Math.max(1, Math.ceil(totalGuests / maxGuestsPerRoom));

            // Auto-increase rooms to fit the selected guest count.
            if (roomsCount < suggestedRoomsForCapacity) {
                roomsInput.value = suggestedRoomsForCapacity;
            }

            guestCapacityAlert.style.display = 'block';
            guestCapacityAlertText.textContent =
                ' For ' + totalGuests +
                ' guests, this room holds up to ' + maxGuestsPerRoom +
                ' per room. Suggested: ' + suggestedRoomsForCapacity + ' rooms.';
        } else {
            guestCapacityAlert.style.display = 'none';
            guestCapacityAlertText.textContent = '';
        }
    }

    if (guestCapacityApply) {
        guestCapacityApply.addEventListener('click', function() {
            roomsInput.value = suggestedRoomsForCapacity;
            updateCapacity();
        });
    }

    roomSelect.addEventListener('change', updateCapacity);
    [adultsInput, childrenInput, roomsInput].forEach(function(el) {
        if (!el) return;
        el.addEventListener('input', updateCapacity);
        el.addEventListener('change', updateCapacity);
    });

    updateCapacity();
});
</script>
