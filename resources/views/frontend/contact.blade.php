<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Contact Us',
    'defaultDescription' => "We'd love to help you get a comfortable stay",
    'showHeroContacts' => true,
])

@php
    $roomList = isset($rooms) && $rooms instanceof \Illuminate\Support\Collection ? $rooms : collect($rooms ?? []);
    $setting = $setting ?? \App\Models\Setting::first();
@endphp

<!-- Contact Section (phone, email, social — see site header) -->
<div class="rts__section section__padding">
    <div class="container">
        <div class="row g-4 g-xl-4 align-items-stretch">
            <div class="col-lg-7 col-xl-7">
                <div class="home-cta__panel home-cta__panel--form site-form-panel h-100" style="padding: 2rem; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.08);">
                    <div class="home-cta__form-badge mb-2">
                        <i class="fa-solid fa-envelope-open-text" aria-hidden="true"></i>
                        <span>Send us a message</span>
                    </div>
                    <h3 class="mb-10 section__title" style="font-size: 1.35rem;">Enquiry form</h3>

                    @if(session('success'))
                        <div class="home-cta__alert home-cta__alert--success mb-20" role="status">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="home-cta__alert home-cta__alert--error mb-20" role="alert">
                            <ul class="home-cta__alert-list mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('sendMessage') }}" method="POST" id="contact-enquiry-form" class="home-cta__form site-form" novalidate>
                        @csrf

                        <div class="contact-enquiry-type mb-25">
                            <span class="home-cta__label d-block mb-10">Enquiry type <span class="home-cta__req">*</span></span>
                            <div class="contact-enquiry-type__options" role="radiogroup" aria-label="Enquiry type">
                                <label class="contact-enquiry-type__opt">
                                    <input type="radio" name="enquiry_type" value="general" {{ old('enquiry_type', 'general') === 'general' ? 'checked' : '' }}>
                                    <span>General information</span>
                                </label>
                                <label class="contact-enquiry-type__opt">
                                    <input type="radio" name="enquiry_type" value="room" {{ old('enquiry_type') === 'room' ? 'checked' : '' }}>
                                    <span>Room enquiry</span>
                                </label>
                            </div>
                        </div>

                        <div class="home-cta__block">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact-names" class="home-cta__label">Full name <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="text" name="names" id="contact-names" class="form-control home-cta__input" required maxlength="255" value="{{ old('names') }}" autocomplete="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="contact-phone" class="home-cta__label">Phone <span class="home-cta__req">*</span></label>
                                    <div class="home-cta__field">
                                        <input type="tel" name="phone" id="contact-phone" class="form-control home-cta__input" required maxlength="60" value="{{ old('phone') }}" autocomplete="tel">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="contact-email" class="home-cta__label">Email <span class="home-cta__label-opt">(optional)</span></label>
                                    <div class="home-cta__field">
                                        <input type="email" name="email" id="contact-email" class="form-control home-cta__input" inputmode="email" autocomplete="email" value="{{ old('email') }}" placeholder="name@example.com">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="contact-general-fields">
                            <div class="home-cta__block">
                                <label for="contact-subject" class="home-cta__label">Subject <span class="home-cta__req">*</span></label>
                                <div class="home-cta__field">
                                    <input type="text" name="subject" id="contact-subject" data-require-general class="form-control home-cta__input" maxlength="255" value="{{ old('subject') }}" placeholder="What is this regarding?">
                                </div>
                            </div>
                            <div class="home-cta__block">
                                <label for="contact-message-general" class="home-cta__label">Your message <span class="home-cta__req">*</span></label>
                                <div class="home-cta__field">
                                    <textarea name="message" id="contact-message-general" data-require-general class="form-control home-cta__input home-cta__input--textarea" rows="5" placeholder="Tell us how we can help…">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div id="contact-room-fields" style="display: none;">
                            <div class="home-cta__block">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="contact-room-id" class="home-cta__label">Room <span class="home-cta__req">*</span></label>
                                        <div class="home-cta__field">
                                            <select name="room_id" id="contact-room-id" data-require-room class="form-control home-cta__input home-cta__input--select">
                                                <option value="">Choose a room…</option>
                                                @foreach($roomList as $roomOption)
                                                    <option
                                                        value="{{ $roomOption->id }}"
                                                        data-max-occupancy="{{ (int) ($roomOption->max_occupancy ?? 0) }}"
                                                        {{ (string) old('room_id') === (string) $roomOption->id ? 'selected' : '' }}
                                                    >
                                                        {{ $roomOption->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-checkin" class="home-cta__label">Check-in <span class="home-cta__req">*</span></label>
                                        <div class="home-cta__field">
                                            <input type="date" name="checkin_date" id="contact-checkin" data-require-room class="form-control home-cta__input" min="{{ date('Y-m-d') }}" value="{{ old('checkin_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-checkout" class="home-cta__label">Check-out <span class="home-cta__req">*</span></label>
                                        <div class="home-cta__field">
                                            <input type="date" name="checkout_date" id="contact-checkout" data-require-room class="form-control home-cta__input" value="{{ old('checkout_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-adults" class="home-cta__label">Adults <span class="home-cta__req">*</span></label>
                                        <div class="home-cta__field">
                                            <input type="number" name="adults" id="contact-adults" data-require-room class="form-control home-cta__input" min="1" value="{{ old('adults', 1) }}" inputmode="numeric">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-children" class="home-cta__label">Children</label>
                                        <div class="home-cta__field">
                                            <input type="number" name="children" id="contact-children" class="form-control home-cta__input" min="0" value="{{ old('children', 0) }}" inputmode="numeric">
                                        </div>
                                        <small class="text-muted d-block mt-1">Children 6-12. 13+ counts as adult.</small>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="guest-capacity-alert-contact" class="alert alert-warning py-2 px-3" style="display: none;">
                                            <div class="small">
                                                <strong>More rooms needed.</strong>
                                                <span id="guest-capacity-alert-text-contact"></span>
                                            </div>
                                            <button type="button" id="guest-capacity-apply-contact" class="btn btn-sm btn-primary mt-2">
                                                Set to suggested rooms
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="home-cta__block">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="contact-rooms" class="home-cta__label">Number of Rooms</label>
                                        <div class="home-cta__field">
                                            <input type="number" name="rooms" id="contact-rooms" class="form-control home-cta__input" min="1" value="1" inputmode="numeric">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="contact-extra-beds" class="home-cta__label">Extra beds (optional)</label>
                                        <div class="home-cta__field">
                                            <input
                                                type="number"
                                                name="extra_beds"
                                                id="contact-extra-beds"
                                                class="form-control home-cta__input"
                                                min="0"
                                                value="0"
                                                inputmode="numeric"
                                            >
                                        </div>
                                        <small class="text-muted d-block mt-1">Extra beds (if applicable).</small>
                                    </div>
                                </div>
                            </div>
                            <div class="home-cta__block">
                                <label for="contact-message-room" class="home-cta__label">Special Requests <span class="home-cta__label-opt">(optional)</span></label>
                                <div class="home-cta__field">
                                    <textarea id="contact-message-room" class="form-control home-cta__input home-cta__input--textarea" rows="4" placeholder="Any special requests or notes...">{{ old('message') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="theme-btn btn-style fill w-100 home-cta__submit">
                            <span>Send message <i class="fa-solid fa-arrow-right home-cta__submit-icon" aria-hidden="true"></i></span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5 col-xl-5 mt-4 mt-lg-0 d-flex align-items-stretch">
                <div class="home-cta__panel home-cta__panel--map w-100 h-100">
                    <div class="home-cta__map-head">
                        <span class="home-cta__map-icon" aria-hidden="true"><i class="fa-solid fa-location-dot"></i></span>
                        <div class="home-cta__map-head-text">
                            <span class="home-cta__map-label">Visit us</span>
                            <span id="contact-map-heading" class="home-cta__map-title">{{ $setting?->company ?? config('app.name') }}</span>
                            @if(filled($setting?->address))
                                <span class="home-cta__map-address">{{ $setting->address }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="home-cta__map-frame contact-page-map-frame">
                        @if(!empty($setting?->google_map_embed))
                            {!! $setting->google_map_embed !!}
                        @else
                            @php
                                $hc = \App\Models\HotelContact::first();
                                $latitude = $hc?->latitude ?? '-1.9441';
                                $longitude = $hc?->longitude ?? '30.0619';
                            @endphp
                            <iframe
                                title="Hotel location on Google Maps"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.497311415315!2d{{ $longitude }}!3d{{ $latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2z{{ $latitude }},{{ $longitude }}!5e0!3m2!1sen!2srw!4v1234567890"
                                width="100%"
                                height="100%"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen=""></iframe>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
(function () {
    var form = document.getElementById('contact-enquiry-form');
    if (!form) return;

    var emailInput = document.getElementById('contact-email');
    var generalBlock = document.getElementById('contact-general-fields');
    var roomBlock = document.getElementById('contact-room-fields');
    var checkin = document.getElementById('contact-checkin');
    var checkout = document.getElementById('contact-checkout');
    var roomMessage = document.getElementById('contact-message-room');
    var generalMessage = document.getElementById('contact-message-general');

    // Room capacity (multi-room suggestion)
    var roomSelect = document.getElementById('contact-room-id');
    var adultsInput = document.getElementById('contact-adults');
    var childrenInput = document.getElementById('contact-children');
    var roomsInput = document.getElementById('contact-rooms');
    var guestCapacityAlert = document.getElementById('guest-capacity-alert-contact');
    var guestCapacityAlertText = document.getElementById('guest-capacity-alert-text-contact');
    var guestCapacityApply = document.getElementById('guest-capacity-apply-contact');

    function getType() {
        var r = form.querySelector('input[name="enquiry_type"]:checked');
        return r ? r.value : 'general';
    }

    function syncRoomMessageName() {
        if (!roomMessage || !generalMessage) return;
        if (getType() === 'room') {
            roomMessage.setAttribute('name', 'message');
            generalMessage.removeAttribute('name');
        } else {
            generalMessage.setAttribute('name', 'message');
            roomMessage.removeAttribute('name');
        }
    }

    function syncEnquiryTypeStyles() {
        form.querySelectorAll('.contact-enquiry-type__opt').forEach(function (label) {
            var input = label.querySelector('input[type="radio"]');
            label.classList.toggle('contact-enquiry-type__opt--active', !!(input && input.checked));
        });
    }

    function syncFields() {
        var type = getType();
        if (generalBlock) generalBlock.style.display = type === 'general' ? '' : 'none';
        if (roomBlock) roomBlock.style.display = type === 'room' ? '' : 'none';

        form.querySelectorAll('[data-require-general]').forEach(function (el) {
            el.required = type === 'general';
        });
        form.querySelectorAll('[data-require-room]').forEach(function (el) {
            el.required = type === 'room';
        });

        syncRoomMessageName();
        syncEnquiryTypeStyles();

        if (type === 'room' && checkin && checkout) {
            var tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            if (!checkout.getAttribute('min') || checkin.value) {
                if (checkin.value) {
                    var d = new Date(checkin.value);
                    if (!isNaN(d.getTime())) {
                        d.setDate(d.getDate() + 1);
                        checkout.min = d.toISOString().slice(0, 10);
                    }
                } else {
                    checkout.min = tomorrow.toISOString().slice(0, 10);
                }
            }
        }
    }

    form.querySelectorAll('input[name="enquiry_type"]').forEach(function (r) {
        r.addEventListener('change', syncFields);
    });

    if (checkin && checkout) {
        checkin.addEventListener('change', function () {
            if (!checkin.value) return;
            var d = new Date(checkin.value);
            if (isNaN(d.getTime())) return;
            d.setDate(d.getDate() + 1);
            checkout.min = d.toISOString().slice(0, 10);
            if (checkout.value && checkout.value <= checkin.value) {
                checkout.value = '';
            }
        });
    }

    function getMaxGuestsPerRoom() {
        if (!roomSelect || roomSelect.selectedIndex < 0) return 0;
        var opt = roomSelect.options[roomSelect.selectedIndex];
        var max = parseInt(opt && opt.dataset ? (opt.dataset.maxOccupancy || '0') : '0', 10);
        return Number.isFinite(max) ? max : 0;
    }

    function updateGuestCapacityAlert() {
        if (!guestCapacityAlert || !guestCapacityAlertText || !roomsInput || !adultsInput) return;

        var maxGuestsPerRoom = getMaxGuestsPerRoom();
        var adults = Math.max(0, parseInt(adultsInput.value, 10) || 0);
        var children = childrenInput ? Math.max(0, parseInt(childrenInput.value, 10) || 0) : 0;
        var roomCount = Math.max(1, parseInt(roomsInput.value, 10) || 1);

        var totalGuests = adults + children;

        if (maxGuestsPerRoom > 0 && totalGuests > (maxGuestsPerRoom * roomCount)) {
            var suggestedRoomsForCapacity = Math.max(1, Math.ceil(totalGuests / maxGuestsPerRoom));

            if (roomCount < suggestedRoomsForCapacity) {
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

    if (roomSelect) roomSelect.addEventListener('change', updateGuestCapacityAlert);
    if (adultsInput) ['input', 'change'].forEach(function (evt) {
        adultsInput.addEventListener(evt, updateGuestCapacityAlert);
    });
    if (childrenInput) ['input', 'change'].forEach(function (evt) {
        childrenInput.addEventListener(evt, updateGuestCapacityAlert);
    });
    if (roomsInput) ['input', 'change'].forEach(function (evt) {
        roomsInput.addEventListener(evt, updateGuestCapacityAlert);
    });

    if (guestCapacityApply) {
        guestCapacityApply.addEventListener('click', function () {
            updateGuestCapacityAlert();
        });
    }

    updateGuestCapacityAlert();

    form.addEventListener('submit', function (e) {
        if (emailInput && emailInput.value.trim() !== '') {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!re.test(emailInput.value.trim())) {
                e.preventDefault();
                emailInput.setCustomValidity('Please enter a valid email address.');
                emailInput.reportValidity();
                return;
            }
        }
        if (emailInput) emailInput.setCustomValidity('');
    });

    syncFields();
})();
</script>
<!-- Contact End -->
</div>
