{{--
  Shared sidebar inquiry form (Dining / Meetings).
  Expects: $formPrefix (string), $cardTitle, $cardLead, $iconClass (optional, Font Awesome classes)
  Optional: $proposalSource — 'meetings'|'dining' (required for Laravel submission)
  Optional: $meetingRoomLabel — when set, sent as meeting_room (proposal emails) e.g. room name on single-room page
--}}
@php
    $pf = $formPrefix ?? 'inquiry';
    $icon = $iconClass ?? 'fa-solid fa-calendar-check';
    $source = $proposalSource ?? 'meetings';
@endphp
<aside class="page-inquiry-card w-100 wow fadeInUp" data-wow-delay=".08s" aria-labelledby="page-inquiry-title-{{ $pf }}">
    <div class="page-inquiry-card__inner">
        <div class="page-inquiry-card__head">
            <span class="page-inquiry-card__icon" aria-hidden="true"><i class="{{ $icon }}"></i></span>
            <h3 id="page-inquiry-title-{{ $pf }}" class="page-inquiry-card__title">{{ $cardTitle }}</h3>
            <p class="page-inquiry-card__lead font-sm">{{ $cardLead }}</p>
        </div>
        <form action="{{ route('submitProposal') }}" method="post" class="page-inquiry-form booking__form" id="inquiry-form-{{ $pf }}" novalidate>
            @csrf
            <input type="hidden" name="proposal_source" value="{{ $source }}">
            @if(!empty($meetingRoomLabel))
                <input type="hidden" name="meeting_room" value="{{ $meetingRoomLabel }}">
            @endif

            @if(session('error'))
                <div class="alert alert-danger small mb-3" role="alert">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger small mb-3" role="alert">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="page-inquiry-field">
                <label for="{{ $pf }}-name" class="page-inquiry-label">Full name <span class="text-danger">*</span></label>
                <input type="text" class="form-control page-inquiry-input" id="{{ $pf }}-name" name="names" value="{{ old('names') }}" placeholder="Your name" required autocomplete="name">
            </div>
            <div class="row g-2 page-inquiry-row">
                <div class="col-md-6 page-inquiry-field">
                    <label for="{{ $pf }}-phone" class="page-inquiry-label">Phone <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control page-inquiry-input" id="{{ $pf }}-phone" name="phone" value="{{ old('phone') }}" placeholder="Phone number" required autocomplete="tel">
                </div>
                <div class="col-md-6 page-inquiry-field">
                    <label for="{{ $pf }}-email" class="page-inquiry-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control page-inquiry-input" id="{{ $pf }}-email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="email">
                </div>
            </div>
            <div class="row g-2 page-inquiry-row">
                <div class="col-md-6 page-inquiry-field">
                    <label for="{{ $pf }}-date" class="page-inquiry-label">Preferred date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control page-inquiry-input" id="{{ $pf }}-date" name="preferred_date" value="{{ old('preferred_date') }}" required min="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6 page-inquiry-field">
                    <label for="{{ $pf }}-personas" class="page-inquiry-label">Party size</label>
                    <input
                        type="number"
                        class="form-control page-inquiry-input"
                        id="{{ $pf }}-personas"
                        name="party_size"
                        min="1"
                        value="{{ old('party_size') }}"
                        inputmode="numeric"
                        aria-label="Number of guests"
                        placeholder="Guests"
                    >
                </div>
            </div>
            <div class="row g-2 page-inquiry-row">
                <div class="col-md-6 page-inquiry-field">
                    <label for="{{ $pf }}-days" class="page-inquiry-label">Number of days <span class="text-danger">*</span></label>
                    <input
                        type="number"
                        class="form-control page-inquiry-input"
                        id="{{ $pf }}-days"
                        name="number_of_days"
                        min="1"
                        max="365"
                        step="1"
                        value="{{ old('number_of_days', '1') }}"
                        inputmode="numeric"
                        required
                        placeholder="e.g. 1"
                    >
                </div>
                <div class="col-md-6 page-inquiry-field">
                    <label for="{{ $pf }}-tipo" class="page-inquiry-label">Event type</label>
                    <select class="form-select page-inquiry-input" id="{{ $pf }}-tipo" name="event_type" aria-label="Event type">
                        <option value="">Select type…</option>
                        <option value="Meetings" @selected(old('event_type') === 'Meetings')>Workshop / Conference</option>
                        <option value="Marriage" @selected(old('event_type') === 'Marriage')>Wedding</option>
                        <option value="Anniversary" @selected(old('event_type') === 'Anniversary')>Anniversary</option>
                        <option value="Birthday" @selected(old('event_type') === 'Birthday')>Birthday</option>
                        <option value="Graduation" @selected(old('event_type') === 'Graduation')>Graduation</option>
                        <option value="Other" @selected(old('event_type') === 'Other')>Other</option>
                    </select>
                </div>
            </div>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-additional" class="page-inquiry-label">Other requests</label>
                <textarea class="form-control page-inquiry-input" id="{{ $pf }}-additional" name="additional_requests" rows="3" placeholder="Meal plan, guests staying at the hotel, AV needs, dietary requirements…">{{ old('additional_requests') }}</textarea>
            </div>
            <button type="submit" class="theme-btn btn-style fill w-100 page-inquiry-submit">
                <span>Submit request</span>
            </button>
        </form>
    </div>
</aside>
