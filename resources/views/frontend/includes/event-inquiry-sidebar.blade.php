{{--
  Shared sidebar inquiry form (Dining / Meetings).
  Expects: $formPrefix (string), $cardTitle, $cardLead, $iconClass (optional, Font Awesome classes)
--}}
@php
    $pf = $formPrefix ?? 'inquiry';
    $icon = $iconClass ?? 'fa-solid fa-calendar-check';
@endphp
<aside class="page-inquiry-card wow fadeInUp" data-wow-delay=".08s" aria-labelledby="page-inquiry-title-{{ $pf }}">
    <div class="page-inquiry-card__inner">
        <div class="page-inquiry-card__head">
            <span class="page-inquiry-card__icon" aria-hidden="true"><i class="{{ $icon }}"></i></span>
            <h3 id="page-inquiry-title-{{ $pf }}" class="page-inquiry-card__title">{{ $cardTitle }}</h3>
            <p class="page-inquiry-card__lead font-sm">{{ $cardLead }}</p>
        </div>
        <form action="econtacto-eventos.php" method="post" class="page-inquiry-form booking__form" id="inquiry-form-{{ $pf }}" novalidate>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-name" class="page-inquiry-label">Full name <span class="text-danger">*</span></label>
                <input type="text" class="form-control page-inquiry-input" id="{{ $pf }}-name" name="nombre" placeholder="Your name" required autocomplete="name">
            </div>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-phone" class="page-inquiry-label">Phone <span class="text-danger">*</span></label>
                <input type="tel" class="form-control page-inquiry-input" id="{{ $pf }}-phone" name="telefono" placeholder="Phone number" required autocomplete="tel">
            </div>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-email" class="page-inquiry-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control page-inquiry-input" id="{{ $pf }}-email" name="email" placeholder="you@example.com" required autocomplete="email">
            </div>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-date" class="page-inquiry-label">Preferred date <span class="text-danger">*</span></label>
                <input type="date" class="form-control page-inquiry-input" id="{{ $pf }}-date" name="date_in" required min="{{ date('Y-m-d') }}">
            </div>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-tipo" class="page-inquiry-label">Event type</label>
                <select class="form-select page-inquiry-input" id="{{ $pf }}-tipo" name="tipo" aria-label="Event type">
                    <option value="">Select type…</option>
                    <option value="Marriage">Wedding</option>
                    <option value="Anniversary">Anniversary</option>
                    <option value="15 years">Quinceañera / milestone</option>
                    <option value="Birthday">Birthday</option>
                    <option value="Meetings">Meeting / conference</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="page-inquiry-field">
                <label for="{{ $pf }}-personas" class="page-inquiry-label">Party size</label>
                <select class="form-select page-inquiry-input" id="{{ $pf }}-personas" name="personas" aria-label="Number of guests">
                    <option value="">Guests…</option>
                    <option value="1 Person">1 guest</option>
                    <option value="2 Persons">2 guests</option>
                    <option value="3 Persons">3 guests</option>
                    <option value="4 Persons">4 guests</option>
                    <option value="5 Persons">5 guests</option>
                    <option value="6 Persons">6 guests</option>
                    <option value="7 Persons">7 guests</option>
                    <option value="8 Persons">8 guests</option>
                    <option value="9 Persons">9 guests</option>
                    <option value="More 10 Persons">10+ guests</option>
                </select>
            </div>
            <div class="page-inquiry-field page-inquiry-field--captcha">
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                <div class="g-recaptcha" data-sitekey="6LdtLgkqAAAAAIb0bEQt16PF0YMGQXHaQlO5Ty3x"></div>
            </div>
            <button type="submit" class="theme-btn btn-style fill w-100 page-inquiry-submit">
                <span>Submit request</span>
            </button>
        </form>
    </div>
</aside>
