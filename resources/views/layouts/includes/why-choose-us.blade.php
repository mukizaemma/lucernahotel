{{-- Full-width parallax background + transparent layer; icon/title + hover reveal --}}
@if(isset($whyChooseUsItems) && $whyChooseUsItems->isNotEmpty())
@php
    $wcuIcons = [
        'fa-location-dot',
        'fa-hands-praying',
        'fa-bed',
        'fa-chalkboard-user',
        'fa-user-group',
        'fa-bowl-food',
        'fa-van-shuttle',
        'fa-shield-heart',
    ];
    $wcuBgUrl = asset('storage/images/about/default.jpg');
    if ($about && $about->image2) {
        if (strpos($about->image2, '/') !== false || strpos($about->image2, 'abouts') === 0) {
            $wcuBgUrl = asset('storage/' . $about->image2);
        } else {
            $wcuBgUrl = asset('storage/images/about/' . $about->image2);
        }
    }
@endphp
<div
    class="site-why-choose-parallax-wrap jarallax"
    data-speed="0.5"
    style="--wcu-bg-fallback: url('{{ $wcuBgUrl }}')"
>
    <img class="jarallax-img" src="{{ $wcuBgUrl }}" alt="" loading="lazy" decoding="async" width="1920" height="1080">
    <div class="site-why-choose__veil" aria-hidden="true"></div>

    <section class="site-why-choose rts__section section__padding" aria-labelledby="site-why-choose-heading">
        <div class="container position-relative">
            <div class="row justify-content-center text-center mb-50 mb-lg-60">
                <div class="col-lg-8">
                    <h2 id="site-why-choose-heading" class="site-why-choose__heading section__title">Why Choose Us</h2>
                    <p class="site-why-choose__lead font-sm mb-0">
                        Hover for details; on phones we show a short excerpt under each title.
                    </p>
                </div>
            </div>
            <div class="row g-3 g-lg-4 justify-content-center">
                @foreach($whyChooseUsItems as $item)
                <div class="col-12 col-sm-6 col-xl-3">
                    <article
                        class="site-why-choose__card"
                        tabindex="0"
                        @if(filled($item->description))
                            aria-label="{{ $item->title }}. {{ Str::limit(strip_tags($item->description), 200) }}"
                        @else
                            aria-label="{{ $item->title }}"
                        @endif
                    >
                        <div class="site-why-choose__peek">
                            <div class="site-why-choose__icon-wrap" aria-hidden="true">
                                <span class="site-why-choose__icon-ring"></span>
                                <i class="fa-solid {{ $wcuIcons[$loop->index % count($wcuIcons)] }} site-why-choose__icon"></i>
                            </div>
                            <h3 class="site-why-choose__title">{{ $item->title }}</h3>
                        </div>
                        @if(filled($item->description))
                        <div class="site-why-choose__reveal" role="region" aria-label="Details: {{ $item->title }}">
                            <div class="site-why-choose__reveal-inner">
                                {!! nl2br(e($item->description)) !!}
                            </div>
                        </div>
                        @endif
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endif
