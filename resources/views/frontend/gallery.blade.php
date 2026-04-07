<div class="public-livewire-page">
<style>
    .gallery__link:hover img { opacity: 0.9; }
    .gallery__link:focus { outline: 2px solid rgba(3, 86, 183, 0.5); outline-offset: 2px; }
</style>
@php
    $heroImage = '';
    $heroCaption = 'Gallery';
    $heroDescription = 'where every image tells a story of luxury, comfort, and unparalleled hospitality';

    if ($pageHero && !empty($pageHero->background_image)) {
        $heroImage = asset('storage/' . $pageHero->background_image);
        $heroCaption = $pageHero->caption ?? $heroCaption;
        $heroDescription = $pageHero->description ?? $heroDescription;
    } elseif ($about && $about?->image2) {
        if (strpos($about?->image2, '/') !== false || strpos($about?->image2, 'abouts') === 0) {
            $heroImage = asset('storage/' . $about?->image2);
        } else {
            $heroImage = asset('storage/images/about/' . $about?->image2);
        }
    } else {
        $heroImage = asset('storage/images/about/default.jpg');
    }
    $galleryImageList = $galleryImages;
@endphp
    <div class="rts__section page__hero__height page__hero__bg" style="background-image: url({{ $heroImage }}); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="page__hero__content">
                        <h1 class="wow fadeInUp">{{ $heroCaption }}</h1>
                        <p class="wow fadeInUp font-sm">{{ $heroDescription }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- gallery with tabs -->
    <div class="rts__section section__padding">
        <div class="container">
            <ul class="nav nav-tabs mb-4" id="galleryTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab" aria-controls="images" aria-selected="true">Images</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="false">Videos</button>
                </li>
            </ul>

            <div class="tab-content" id="galleryTabsContent">
                <!-- Images tab (default) -->
                <div class="tab-pane fade show active" id="images" role="tabpanel" aria-labelledby="images-tab">
                    <div class="row g-4" id="galleryImagesRow">
                        @forelse ($galleryImages as $index => $image)
                            <div class="col-lg-4 col-md-6" wire:key="gallery-img-{{ $image['id'] }}">
                                <div class="gallery__item h-100">
                                    <a href="{{ $image['url'] }}" class="gallery__link d-block rounded-2 overflow-hidden gallery-image-trigger" data-index="{{ $index }}" role="button" style="cursor: pointer;" title="View full size">
                                        <img class="img-fluid w-100" src="{{ $image['url'] }}" alt="{{ $image['caption'] ?: 'Gallery image' }}" loading="lazy" decoding="async" style="height: 260px; object-fit: cover; transition: opacity 0.2s;">
                                    </a>
                                    @if(!empty($image['caption']))
                                        <p class="mt-2 small text-muted mb-0">{{ $image['caption'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted mb-0">No images in the gallery yet.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($galleryHasMore)
                        <div class="text-center mt-4 pt-2">
                            <button type="button" class="btn btn-outline-primary" wire:click="loadMoreGalleryImages" wire:loading.attr="disabled" wire:target="loadMoreGalleryImages">
                                <span wire:loading.remove wire:target="loadMoreGalleryImages">Load more images</span>
                                <span wire:loading wire:target="loadMoreGalleryImages">Loading…</span>
                            </button>
                        </div>
                        <div id="gallery-infinite-sentinel" class="py-1" wire:ignore.self aria-hidden="true"></div>
                    @endif
                </div>

                <!-- Videos tab -->
                <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                    <div class="row g-4">
                        @forelse ($galleryVideos as $video)
                            @php $videoId = $video['video_id']; @endphp
                            <div class="col-lg-4 col-md-6" wire:key="gallery-vid-{{ $video['id'] }}">
                                <div class="gallery__item h-100">
                                    <div class="ratio ratio-16x9 rounded-2 overflow-hidden bg-dark gallery-video-trigger" data-video-id="{{ $videoId }}" data-caption="{{ $video['caption'] }}" role="button" style="cursor: pointer; position: relative;">
                                        <img src="https://img.youtube.com/vi/{{ $videoId }}/mqdefault.jpg" alt="{{ $video['caption'] ?: 'Video' }}" loading="lazy" decoding="async" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div class="position-absolute top-50 start-50 translate-middle" style="pointer-events: none;">
                                            <span class="rounded-circle d-flex align-items-center justify-content-center bg-danger text-white" style="width: 70px; height: 70px; font-size: 28px;"><i class="fas fa-play"></i></span>
                                        </div>
                                    </div>
                                    @if(!empty($video['caption']))
                                        <p class="mt-2 small text-muted mb-0">{{ $video['caption'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted mb-0">No videos in the gallery yet. Add YouTube links from the admin.</p>
                            </div>
                        @endforelse
                    </div>
                    @if($galleryVideosHasMore)
                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-outline-primary" wire:click="loadMoreVideos" wire:loading.attr="disabled" wire:target="loadMoreVideos">
                                <span wire:loading.remove wire:target="loadMoreVideos">Load more videos</span>
                                <span wire:loading wire:target="loadMoreVideos">Loading…</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox payload: updated on each Livewire morph (loaded images only) -->
    <div id="gallery-images-payload" class="d-none" aria-hidden="true">@json($galleryImageList)</div>

    <!-- Image Lightbox Modal -->
    <div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-labelledby="imageLightboxLabel" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
                <div class="modal-header border-0 py-2 px-3 bg-dark text-white d-flex justify-content-between align-items-center flex-nowrap">
                    <button type="button" class="btn btn-link text-white text-decoration-none p-2 gallery-lightbox-prev" aria-label="Previous image"><i class="fas fa-chevron-left fa-2x"></i></button>
                    <h5 class="modal-title mb-0 mx-2 text-nowrap" id="imageLightboxLabel">Image</h5>
                    <div class="d-flex align-items-center flex-nowrap">
                        <span class="gallery-lightbox-counter me-3 small"></span>
                        <button type="button" class="btn btn-link text-white text-decoration-none p-2 gallery-lightbox-close" aria-label="Close"><i class="fas fa-times fa-2x"></i></button>
                    </div>
                    <button type="button" class="btn btn-link text-white text-decoration-none p-2 gallery-lightbox-next" aria-label="Next image"><i class="fas fa-chevron-right fa-2x"></i></button>
                </div>
                <div class="modal-body p-0 bg-dark text-center position-relative">
                    <img class="gallery-lightbox-image img-fluid" src="" alt="" style="max-height: 80vh; width: auto; display: block; margin: 0 auto;">
                    <p class="gallery-lightbox-caption text-white small p-2 mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Lightbox Modal -->
    <div class="modal fade" id="videoLightboxModal" tabindex="-1" aria-labelledby="videoLightboxLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 shadow-lg rounded-3 overflow-hidden">
                <div class="modal-header border-0 py-2 px-3 bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="modal-title mb-0" id="videoLightboxLabel">Video</h5>
                    <button type="button" class="btn btn-link text-white text-decoration-none p-0 gallery-video-close" aria-label="Close"><i class="fas fa-times fa-2x"></i></button>
                </div>
                <div class="modal-body p-0 bg-dark">
                    <div class="ratio ratio-16x9">
                        <iframe class="gallery-video-iframe" src="" title="Video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <p class="gallery-video-caption text-white small p-3 mb-0"></p>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function() {
        function getGalleryImages() {
            var el = document.getElementById('gallery-images-payload');
            if (!el) return [];
            try { return JSON.parse(el.textContent || '[]'); } catch (e) { return []; }
        }

        var currentImageIndex = 0;
        var imageModalEl = document.getElementById('imageLightboxModal');
        var imageModal = imageModalEl ? new bootstrap.Modal(imageModalEl) : null;

        function updateMainImage() {
            var galleryImages = getGalleryImages();
            var item = galleryImages[currentImageIndex];
            if (!item) return;
            var imgEl = document.querySelector('.gallery-lightbox-image');
            var capEl = document.querySelector('.gallery-lightbox-caption');
            var counterEl = document.querySelector('.gallery-lightbox-counter');
            if (imgEl) imgEl.src = item.url;
            if (imgEl) imgEl.alt = item.caption || 'Gallery image';
            if (capEl) capEl.textContent = item.caption || '';
            if (counterEl) counterEl.textContent = (currentImageIndex + 1) + ' / ' + galleryImages.length;
        }

        function openImageLightbox(index) {
            var galleryImages = getGalleryImages();
            if (!galleryImages.length || !imageModal) return;
            currentImageIndex = (index + galleryImages.length) % galleryImages.length;
            updateMainImage();
            imageModal.show();
        }

        function showPrevImage() {
            var galleryImages = getGalleryImages();
            if (!galleryImages.length) return;
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            updateMainImage();
        }

        function showNextImage() {
            var galleryImages = getGalleryImages();
            if (!galleryImages.length) return;
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            updateMainImage();
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('.gallery-image-trigger');
            if (!trigger) return;
            e.preventDefault();
            var index = parseInt(trigger.getAttribute('data-index'), 10);
            if (!isNaN(index)) openImageLightbox(index);
        }, true);

        var prevBtn = document.querySelector('.gallery-lightbox-prev');
        var nextBtn = document.querySelector('.gallery-lightbox-next');
        var closeBtn = document.querySelector('.gallery-lightbox-close');
        if (prevBtn) prevBtn.addEventListener('click', function(e) { e.preventDefault(); showPrevImage(); });
        if (nextBtn) nextBtn.addEventListener('click', function(e) { e.preventDefault(); showNextImage(); });
        if (closeBtn) closeBtn.addEventListener('click', function() { if (imageModal) imageModal.hide(); });

        if (imageModalEl) {
            imageModalEl.addEventListener('shown.bs.modal', function() {
                document.addEventListener('keydown', galleryKeydown);
            });
            imageModalEl.addEventListener('hidden.bs.modal', function() {
                document.removeEventListener('keydown', galleryKeydown);
            });
        }

        function galleryKeydown(e) {
            if (e.key === 'ArrowLeft') { e.preventDefault(); showPrevImage(); }
            if (e.key === 'ArrowRight') { e.preventDefault(); showNextImage(); }
        }

        document.addEventListener('click', function(e) {
            var trigger = e.target.closest('.gallery-video-trigger');
            if (!trigger) return;
            var videoId = trigger.getAttribute('data-video-id');
            var caption = trigger.getAttribute('data-caption') || '';
            var iframe = document.querySelector('.gallery-video-iframe');
            var capEl = document.querySelector('.gallery-video-caption');
            if (iframe) iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1';
            if (capEl) capEl.textContent = caption;
            var videoModalEl = document.getElementById('videoLightboxModal');
            if (videoModalEl) {
                var videoModal = bootstrap.Modal.getOrCreateInstance(videoModalEl);
                videoModal.show();
            }
        }, true);

        var videoCloseBtn = document.querySelector('.gallery-video-close');
        if (videoCloseBtn) {
            videoCloseBtn.addEventListener('click', function() {
                var videoModalEl = document.getElementById('videoLightboxModal');
                if (videoModalEl) {
                    var videoModal = bootstrap.Modal.getInstance(videoModalEl);
                    if (videoModal) videoModal.hide();
                }
                var iframe = document.querySelector('.gallery-video-iframe');
                if (iframe) iframe.src = '';
            });
        }

        var videoModalEl = document.getElementById('videoLightboxModal');
        if (videoModalEl) {
            videoModalEl.addEventListener('hidden.bs.modal', function() {
                var iframe = document.querySelector('.gallery-video-iframe');
                if (iframe) iframe.src = '';
            });
        }

        /* Infinite scroll: load more when sentinel is visible (server dedupes via loadingGallery) */
        var galleryScrollObserver = null;
        var morphDebounce = null;
        function setupGalleryInfiniteScroll() {
            var sentinel = document.getElementById('gallery-infinite-sentinel');
            if (!sentinel || !window.Livewire) return;
            var root = sentinel.closest('[wire\\:id]');
            if (!root) return;
            var wireId = root.getAttribute('wire:id');
            if (!wireId) return;
            if (galleryScrollObserver) {
                galleryScrollObserver.disconnect();
                galleryScrollObserver = null;
            }
            galleryScrollObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (!entry.isIntersecting) return;
                    var wire = window.Livewire.find(wireId);
                    if (wire && typeof wire.call === 'function') {
                        wire.call('loadMoreGalleryImages');
                    }
                });
            }, { rootMargin: '400px', threshold: 0 });
            galleryScrollObserver.observe(sentinel);
        }
        function registerMorphHook() {
            if (typeof Livewire === 'undefined' || typeof Livewire.hook !== 'function') return;
            Livewire.hook('morph.updated', function() {
                clearTimeout(morphDebounce);
                morphDebounce = setTimeout(setupGalleryInfiniteScroll, 120);
            });
        }
        if (typeof Livewire !== 'undefined' && Livewire.hook) {
            registerMorphHook();
        } else {
            document.addEventListener('livewire:init', registerMorphHook);
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupGalleryInfiniteScroll);
        } else {
            setupGalleryInfiniteScroll();
        }
    })();
    </script>
</div>
