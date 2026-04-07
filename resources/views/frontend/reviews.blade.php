<div class="public-livewire-page">

@include('frontend.includes.page-hero-banner', [
    'defaultCaption' => 'Guest Reviews',
    'defaultDescription' => 'Read what our guests have to say about their stay',
])

<!-- Reviews Section -->
<div class="rts__section section__padding">
    <div class="container">
        <div class="row mb-40">
            <div class="col-12 text-center">
                <h2>All Reviews ({{ $reviewCount }})</h2>
                <a href="{{ route('reviews') }}#add-review" class="theme-btn btn-style fill mt-3">
                    <span>Add Your Review</span>
                </a>
            </div>
        </div>
        
        <div class="row g-30">
            @forelse($reviews as $review)
            <div class="col-lg-6 wow fadeInUp">
                <div class="review__card" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); height: 100%;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                        <div>
                            <h5 style="margin-bottom: 5px;">{{ $review->names }}</h5>
                            <div style="display: flex; gap: 5px; margin-bottom: 10px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <span class="font-sm" style="color: #999;">{{ $review->created_at->format('M d, Y') }}</span>
                    </div>
                    <p style="color: #666; line-height: 1.8; margin-bottom: 15px;">
                        {{ $review->testimony }}
                    </p>
                    <a href="{{ route('review', ['id' => $review->id]) }}" class="theme-btn btn-style sm-btn border">
                        <span>Read Full Review</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="font-lg">No reviews yet. Be the first to review!</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
        <div class="row mt-40">
            <div class="col-12">
                {{ $reviews->links('vendor.pagination.bootstrap-5-custom') }}
            </div>
        </div>
        @endif

        <!-- Add Review Form -->
        <div class="row mt-60" id="add-review">
            <div class="col-lg-8 mx-auto">
                <div class="home-cta__panel site-form-panel" style="background: #f9f9f9; padding: 40px; border-radius: 12px;">
                    <p class="home-cta__form-note mb-20 text-center">Fields marked <span class="home-cta__req" aria-hidden="true">*</span> are required.</p>
                    <h3 class="text-center mb-30 section__title section__title--compact">Share Your Experience</h3>
                    <form action="{{ route('reviews.store') }}" method="POST" class="home-cta__form site-form">
                        @csrf
                        <div class="row g-20">
                            <div class="col-md-6 mb-3">
                                <label for="review-names" class="home-cta__label">Your Name <span class="home-cta__req">*</span></label>
                                <div class="home-cta__field">
                                    <input type="text" name="names" id="review-names" class="form-control home-cta__input" required autocomplete="name">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="review-email" class="home-cta__label">Your Email <span class="home-cta__req">*</span></label>
                                <div class="home-cta__field">
                                    <input type="email" name="email" id="review-email" class="form-control home-cta__input" required autocomplete="email">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="review-rating" class="home-cta__label">Rating <span class="home-cta__req">*</span></label>
                                <div class="home-cta__field">
                                    <select name="rating" id="review-rating" class="form-control home-cta__input home-cta__input--select" required>
                                        <option value="">Select Rating</option>
                                        <option value="5">5 - Excellent</option>
                                        <option value="4">4 - Very Good</option>
                                        <option value="3">3 - Good</option>
                                        <option value="2">2 - Fair</option>
                                        <option value="1">1 - Poor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="review-website" class="home-cta__label">Website <span class="home-cta__label-opt">(optional)</span></label>
                                <div class="home-cta__field">
                                    <input type="url" name="website" id="review-website" class="form-control home-cta__input" placeholder="https://">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="review-testimony" class="home-cta__label">Your Review <span class="home-cta__req">*</span></label>
                                <div class="home-cta__field">
                                    <textarea name="testimony" id="review-testimony" class="form-control home-cta__input home-cta__input--textarea" rows="5" required placeholder="Share your experience..."></textarea>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="theme-btn btn-style fill home-cta__submit">
                                    <span>Submit Review <i class="fa-solid fa-arrow-right home-cta__submit-icon ms-2" aria-hidden="true"></i></span>
                                </button>
                                <p class="font-sm mt-3 home-cta__form-note" style="color: #64748b;">
                                    Your review will be published after admin approval.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reviews End -->
</div>
