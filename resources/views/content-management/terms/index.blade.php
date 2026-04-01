<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <h4 class="mb-4">Terms & Conditions</h4>
            <form action="{{ route('content-management.terms.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea class="form-control" name="content" rows="15" id="termsContent">{{ $terms->content ?? '' }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status">
                        <option value="active" {{ ($terms->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ ($terms->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Terms & Conditions</button>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#termsContent').summernote({
        height: 400
    });
});
</script>
</div>
