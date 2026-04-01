@php
$setting = App\Models\Setting::first();
$currentRoute = request()->route()->getName();
@endphp

<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('storage/images') . ($setting->logo ?? '') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                {{-- <h6 class="mb-0">{{ $setting->company ?? 'Lucerna Hotel }}</h6> --}}
                <span>
                    @if(auth()->user()->isSuperAdmin())
                        <span class="badge bg-danger me-1">Super Admin</span>
                    @elseif(auth()->user()->isContentManager())
                        <span class="badge bg-primary me-1">Content Manager</span>
                    @endif
                    CMS
                </span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            {{-- CONTENT MANAGEMENT MENU - Only for Content Manager (role_id=2) and Super Admin when on this dashboard --}}
            {{-- Content Manager (role_id=2) sees ONLY these menus --}}
            {{-- Super Admin (role_id=1) sees ONLY these menus when on Content Management dashboard --}}
            
            <a href="{{ route('content-management.dashboard') }}" class="nav-item nav-link {{ $currentRoute == 'content-management.dashboard' ? 'active' : '' }}">
                <i class="fas fa-grip-horizontal me-2"></i>Dashboard
            </a>
            


            <a href="{{ route('content-management.reservations') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.reservations') ? 'active' : '' }}">
                <i class="fas fa-calendar-check me-2"></i>Reservations
            </a>
            <a href="{{ route('content-management.rooms') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.rooms') ? 'active' : '' }}">
                <i class="fas fa-bed me-2"></i>Rooms
            </a>

            <a href="{{ route('content-management.facilities') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.facilities') ? 'active' : '' }}">
                <i class="fas fa-building me-2"></i>Facilities
            </a>
            <a href="{{ route('resto') }}" class="nav-item nav-link">
                <i class="fas fa-utensils me-2"></i>Dining page
            </a>
            <a href="{{ route('eventsPage') }}" class="nav-item nav-link">
                <i class="fas fa-map-marked-alt me-2"></i>Meetings 
            </a>
            <a href="{{ route('content-management.amenities') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.amenities') ? 'active' : '' }}">
                <i class="fas fa-list me-2"></i>Amenities
            </a>
            <a href="{{ route('content-management.tour-activities') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.tour-activities') ? 'active' : '' }}">
                <i class="fas fa-map-marked-alt me-2"></i>Activities
            </a>
            <a href="{{ route('content-management.why-choose-us.index') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.why-choose-us') ? 'active' : '' }}">
                <i class="fas fa-thumbs-up me-2"></i>Why Choose Us
            </a>
            <a href="{{ route('content-management.attractions.index') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.attractions') ? 'active' : '' }}">
                <i class="fas fa-map-pin me-2"></i>Attractions
            </a>
            <a href="{{ route('content-management.gallery') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.gallery') ? 'active' : '' }}">
                <i class="fas fa-images me-2"></i>Gallery
            </a>
            <a href="{{ route('content-management.slideshow') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.slideshow') ? 'active' : '' }}">
                <i class="fas fa-sliders-h me-2"></i>Slideshow
            </a>
            <a href="{{ route('content-management.page-heroes') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.page-heroes') ? 'active' : '' }}">
                <i class="fas fa-image me-2"></i>Page Heroes
            </a>
            
            <hr>

            {{-- System Users - Only for Super Admin (role_id=1) when on Content Management dashboard --}}
            @if(auth()->user()->hasRoleId(1))
            <a href="{{ route('content-management.users') }}" class="nav-item nav-link {{ str_contains($currentRoute, 'content-management.users') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i>System Users
            </a>
            @endif

            <a href="{{ route('setting') }}" class="nav-item nav-link">
                <i class="fas fa-cog me-2"></i>Settings
            </a>
            <a href="{{ route('logouts') }}" class="nav-item nav-link">
                <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
        </div>
    </nav>
</div>
