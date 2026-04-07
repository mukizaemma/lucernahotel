@extends('layouts.adminBase')

@section('content')
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h5 class="mb-3">Settings</h5>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#contacts">Contacts & Logo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#about">About Hotel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#seo">SEO Keywords</a>
            </li>
            @if(!empty($canEditDelivery))
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#footer-delivered-by">Delivered by (footer)</a>
            </li>
            @endif
        </ul>

        <div class="tab-content">
            {{-- Tab 1: Contacts & Logo — one card, one form --}}
            <div id="contacts" class="tab-pane fade show active">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">Contacts & Logo</h5>
                        <p class="text-muted small mb-0">Contact details and logos used across the site.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('saveSetting', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Contact details</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="company" class="form-label">Website title</label>
                                        <input type="text" class="form-control" id="company" name="company" value="{{ $data->company }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ $data->address }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $data->phone }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $data->email }}">
                                    </div>
                                </div>
                                <div class="row g-3 mt-1">
                                    <div class="col-md-4">
                                        <label for="reception_phone" class="form-label">Reception phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="reception_phone"
                                            name="reception_phone"
                                            value="{{ old('reception_phone', $data->reception_phone ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="manager_phone" class="form-label">Manager phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="manager_phone"
                                            name="manager_phone"
                                            value="{{ old('manager_phone', $data->manager_phone ?? '') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="restaurant_phone" class="form-label">Restaurant phone</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="restaurant_phone"
                                            name="restaurant_phone"
                                            value="{{ old('restaurant_phone', $data->restaurant_phone ?? '') }}">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Google Map</legend>
                                <p class="text-muted small mb-2">Paste the embed code from Google Maps (Share → Embed a map). Used on Home, Contact, and About pages.</p>
                                <div class="mb-0">
                                    <label for="google_map_embed" class="form-label">Embed code (iframe)</label>
                                    <textarea class="form-control font-monospace" id="google_map_embed" name="google_map_embed" rows="6" placeholder="<iframe src=&quot;https://www.google.com/maps/embed?pb=...&quot; ...></iframe>">{{ $data->google_map_embed ?? '' }}</textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Social media</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $data->facebook }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $data->instagram }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="youtube" class="form-label">YouTube</label>
                                        <input type="text" class="form-control" id="youtube" name="youtube" value="{{ $data->youtube }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="linkedin" class="form-label">LinkedIn</label>
                                        <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $data->linkedin }}">
                                    </div>
                                    <div class="col-12">
                                        <label for="linktree" class="form-label">Booking link</label>
                                        <input type="text" class="form-control" id="linktree" name="linktree" value="{{ $data->linktree ?? '' }}">
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Logos</legend>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Header logo</label>
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/images') . $data->logo }}" alt="Header logo" class="img-thumbnail" style="max-height: 80px;">
                                        </div>
                                        <input type="file" class="form-control" name="logo" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Footer logo</label>
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/images') . $data->donate }}" alt="Footer logo" class="img-thumbnail" style="max-height: 80px;">
                                        </div>
                                        <input type="file" class="form-control" name="donate" accept="image/*">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="star_rating" class="form-label">Star rating (footer)</label>
                                        <select class="form-select" id="star_rating" name="star_rating">
                                            <option value="">— Not shown —</option>
                                            @for ($s = 1; $s <= 5; $s++)
                                                <option value="{{ $s }}" @selected((int) ($data->star_rating ?? 0) === $s)>{{ $s }} star{{ $s > 1 ? 's' : '' }}</option>
                                            @endfor
                                        </select>
                                        <p class="text-muted small mb-0 mt-1">Shown below the footer logo on the public site (out of 5).</p>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Save Contacts & Logo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Tab 2: About Hotel — one card, one form --}}
            <div id="about" class="tab-pane fade">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">About Hotel</h5>
                        <p class="text-muted small mb-0">About-us content and images for the public site.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('content-management.about.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Main content</legend>
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title" value="{{ optional($about)->title ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Sub title</label>
                                    <input type="text" class="form-control" name="subTitle" value="{{ optional($about)->subTitle ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">About description</label>
                                    <textarea class="form-control" name="founderDescription" rows="6" id="founderDescription">{{ optional($about)->founderDescription ?? '' }}</textarea>
                                </div>
                            </fieldset>
                            <fieldset class="mb-4">
                                <legend class="h6 text-secondary border-bottom pb-2 mb-3">Images</legend>
                                <div class="row g-3">
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">About image</label>
                                        @if($about && $about->image1)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image1) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image1" accept="image/*">
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">Home middle image</label>
                                        @if($about && $about->image2)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image2) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image2" accept="image/*">
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">Image 3</label>
                                        @if($about && $about->image3)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image3) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image3" accept="image/*">
                                    </div>
                                    <div class="col-md-6 col-lg-3">
                                        <label class="form-label">Image 4</label>
                                        @if($about && $about->image4)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->image4) }}" alt="" class="img-thumbnail" style="max-height: 60px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="image4" accept="image/*">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Story image</label>
                                        @if($about && $about->storyImage)
                                            <div class="mb-2"><img src="{{ asset('storage/' . $about->storyImage) }}" alt="" class="img-thumbnail" style="max-height: 80px;"></div>
                                        @endif
                                        <input type="file" class="form-control" name="storyImage" accept="image/*">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="pt-2">
                                <button type="submit" class="btn btn-primary">Update About Hotel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(!empty($canEditDelivery))
            {{-- Tab: Footer “Delivered by” — only for admin@iremetech.com --}}
            <div id="footer-delivered-by" class="tab-pane fade">
                <div class="card shadow-sm border-0 border-start border-primary border-3">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">Delivered by (footer)</h5>
                        <p class="text-muted small mb-0">Controls the credit line in the site footer. Only visible to the designated administrator account.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.footer-delivered-by.update') }}" method="POST">
                            @csrf
                            <div class="form-check form-switch mb-4">
                                <input type="hidden" name="footer_delivered_by_enabled" value="0">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="footer_delivered_by_enabled"
                                    id="footer_delivered_by_enabled"
                                    value="1"
                                    @checked(old('footer_delivered_by_enabled', $data->footer_delivered_by_enabled ?? false))
                                >
                                <label class="form-check-label" for="footer_delivered_by_enabled">Show “Delivered by” in the footer</label>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="footer_delivered_by_company">Company / credit name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="footer_delivered_by_company"
                                        name="footer_delivered_by_company"
                                        value="{{ old('footer_delivered_by_company', $data->footer_delivered_by_company ?? '') }}"
                                        placeholder="e.g. Ireme Technologies"
                                        maxlength="255"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="footer_delivered_by_url">URL</label>
                                    <input
                                        type="url"
                                        class="form-control"
                                        id="footer_delivered_by_url"
                                        name="footer_delivered_by_url"
                                        value="{{ old('footer_delivered_by_url', $data->footer_delivered_by_url ?? '') }}"
                                        placeholder="https://example.com"
                                        maxlength="500"
                                    >
                                    <p class="text-muted small mb-0 mt-1">If empty, the name is shown without a link.</p>
                                </div>
                            </div>
                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary">Save footer credit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            {{-- Tab 3: SEO Keywords — one card, one form (only keywords textarea) --}}
            <div id="seo" class="tab-pane fade">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-1">SEO Keywords</h5>
                        <p class="text-muted small mb-0">Keywords used in the site header meta tag. Separate with commas.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.keywords.update') }}" method="POST">
                            @csrf
                            <label class="form-label">Header keywords</label>
                            <textarea class="form-control" name="keywords" rows="6" id="seoKeywords" placeholder="keyword1, keyword2, keyword3">{{ $data->keywords ?? '' }}</textarea>
                            <div class="pt-3">
                                <button type="submit" class="btn btn-primary">Save keywords</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#founderDescription').summernote({ height: 300 });
});
</script>
@endsection
