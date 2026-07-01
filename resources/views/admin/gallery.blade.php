@extends('admin.layout')

@section('title', 'Gallery')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Photo Gallery</h2>
            <p class="sub">Curate the wildlife, landscape, and culture photos shown across the site.</p>
        </div>
        <div class="view-actions">
            <button class="btn btn-primary" onclick="openGalleryModal()">+ Add photo</button>
        </div>
    </div>
    <div class="gallery-grid" id="galleryGrid">
        @if($gallery->isEmpty())
        <div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--ink-soft);">
            No images yet.
        </div>
        @else
        @foreach($gallery as $img)
        <div class="gallery-card" data-id="{{ $img->id }}">
            <img src="{{ $img->url }}" alt="{{ $img->caption }}" loading="lazy">
            <div class="gallery-overlay">
                <div class="gallery-cap">{{ $img->caption }}</div>
                <div class="gallery-actions">
                    <button onclick="deleteGallery({{ $img->id }})">Delete</button>
                </div>
            </div>
            <div class="gallery-badge">{{ $img->category }}</div>
        </div>
        @endforeach
        @endif
        <button class="add-tile" onclick="openGalleryModal()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Add Photo
        </button>
    </div>
</div>

<div class="modal-backdrop" id="galleryModalBackdrop">
    <div class="modal">
        <div class="modal-head">
            <h3>Add photo</h3>
            <button class="modal-close" onclick="closeModal('galleryModalBackdrop')">✕</button>
        </div>
        <form id="galleryForm" action="{{ route('admin.gallery.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="field">
                    <label>Image URL</label>
                    <input type="text" id="galleryUrl" name="url" placeholder="https://…" required>
                </div>
                <div class="field">
                    <label>Caption</label>
                    <input type="text" id="galleryCaption" name="caption" placeholder="e.g. Lion Portrait, Serengeti">
                </div>
                <div class="field">
                    <label>Category</label>
                    <select id="galleryCategory" name="category">
                        <option>Wildlife</option>
                        <option>Landscape</option>
                        <option>Culture</option>
                        <option>People</option>
                        <option>Tours</option>
                    </select>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('galleryModalBackdrop')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add to gallery</button>
            </div>
        </form>
    </div>
</div>

<script>
function openGalleryModal() {
    document.getElementById('galleryUrl').value = '';
    document.getElementById('galleryCaption').value = '';
    document.getElementById('galleryCategory').value = 'Wildlife';
    openModal('galleryModalBackdrop');
}

function deleteGallery(id) {
    if (!confirm('Delete this image?')) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = "/live/gallery/" + id;
    form.innerHTML = '@csrf @method("DELETE")';
    document.body.appendChild(form);
    form.submit();
}
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection
