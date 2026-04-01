<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => $event->title ?? 'Meetings & Events',
    'defaultDescription' => $pageHero?->description ?? 'Host your meetings, celebrations, and conferences with us.',
])

@php
    $galleryImages = $images ?? collect();
@endphp

<section class="page-feature page-feature--meetings rts__section section__padding">
    <div class="container">
        <div class="row g-4 g-xl-5 align-items-start">
            <div class="col-lg-8">
                <header class="page-feature__header mb-4 mb-lg-5">
                    <p class="page-feature__eyebrow">Meetings &amp; events</p>
                    <h2 class="page-feature__title section__title">{{ $event->title ?? 'Meetings & Events' }}</h2>
                    <p class="page-feature__subtitle font-sm">
                        Flexible spaces, attentive planning support, and hospitality tailored to your agenda.
                    </p>
                </header>

                @include('frontend.includes.page-gallery', [
                    'galleryImages' => $galleryImages,
                    'storageSubfolder' => 'events',
                    'galleryKey' => 'meetings',
                ])

                <div class="page-feature__prose content-richtext">
                    @if(filled($event->description))
                        {!! $event->description !!}
                    @else
                        <p class="text-muted mb-0">Event information will appear here once added in the admin.</p>
                    @endif
                </div>

                @if(filled($event->details ?? null))
                    <div class="page-feature__details mt-5 pt-4 border-top">
                        <h3 class="h5 mb-3">Details &amp; logistics</h3>
                        <div class="page-feature__prose content-richtext mb-0">
                            {!! $event->details !!}
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                @include('frontend.includes.event-inquiry-sidebar', [
                    'formPrefix' => 'meetings',
                    'cardTitle' => 'Request a proposal',
                    'cardLead' => 'Share your date, guest count, and event type — our team will follow up with options.',
                    'iconClass' => 'fa-solid fa-building-columns',
                ])
            </div>
        </div>
    </div>
</section>
</div>
