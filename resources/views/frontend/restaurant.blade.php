<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => $restaurant->title ?? 'Dining',
    'defaultDescription' => 'Discover our restaurant, bar, and garden dining experiences.',
])

@php
    $galleryImages = $images ?? collect();
@endphp

<section class="page-feature rts__section section__padding">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-lg-8">
                <header class="page-feature__header mb-4 mb-lg-5">
                    <p class="page-feature__eyebrow">Dining &amp; bar</p>
                    <h2 class="page-feature__title section__title">{{ $restaurant->title ?? 'Our restaurant' }}</h2>
                    <p class="page-feature__subtitle font-sm">
                        Fresh flavors, warm service, and a setting designed for relaxed meals and celebrations.
                    </p>
                </header>

                @include('frontend.includes.page-gallery', [
                    'galleryImages' => $galleryImages,
                    'storageSubfolder' => 'restaurant',
                    'galleryKey' => 'dining',
                ])

                <div class="page-feature__prose content-richtext">
                    @if(filled($restaurant->description))
                        {!! $restaurant->description !!}
                    @else
                        <p class="text-muted mb-0">Restaurant details will appear here once added in the admin.</p>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                @include('frontend.includes.event-inquiry-sidebar', [
                    'formPrefix' => 'dining',
                    'cardTitle' => 'Reserve or plan an event',
                    'cardLead' => 'Tell us your date, party size, and occasion — we’ll get back to you with availability.',
                    'iconClass' => 'fa-solid fa-utensils',
                ])
            </div>
        </div>
    </div>
</section>
</div>
