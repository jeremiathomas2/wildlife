@extends('admin.layout')

@section('title', $dest->name . ' — Edit Destination')

@section('content')
@php
$catLabels = [
    'day-trip' => 'Day Trip',
    'safari' => 'Safari / Multi-Day',
    'kilimanjaro' => 'Kilimanjaro',
    'cultural' => 'Cultural',
    'beach' => 'Beach',
    'custom' => 'Custom',
];
$iconOptions = ['fa-leaf','fa-water','fa-mountain','fa-mug-hot','fa-users','fa-utensils','fa-camera','fa-tree','fa-sun','fa-swimmer','fa-landmark','fa-hiking','fa-binoculars','fa-elephant','fa-lion','fa-paw','fa-rhino','fa-umbrella-beach','fa-seedling','fa-ship','fa-fish','fa-pencil-ruler','fa-user-tie','fa-calendar-alt','fa-wallet','fa-map','fa-heart','fa-flag','fa-mountain-sun','fa-snowflake','fa-truck-monster'];
@endphp

<div class="view active">
    <div class="view-head">
        <div>
            <h2>{{ $dest->name }}</h2>
            <p class="sub">Edit everything shown on the live tour page. Blank rich-content sections fall back to the default tour content.</p>
        </div>
        <div class="view-actions" style="gap:8px;">
            <a href="{{ route('admin.destinations') }}" class="btn btn-ghost">← Destinations</a>
            <a href="{{ route('destination.detail', $dest->slug) }}" class="btn btn-soft" target="_blank" rel="noopener">View live</a>
            <button type="submit" form="destEditorForm" class="btn btn-primary">Save destination</button>
        </div>
    </div>

    @if($errors->any())
    <div class="table-card" style="border:1px solid var(--danger,#c0392b);margin-bottom:18px;">
        <div style="padding:14px 18px;color:var(--danger,#c0392b);font-size:14px;">
            <strong>Please fix the following:</strong>
            <ul style="margin:8px 0 0 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.destinations.update', $dest->id) }}" id="destEditorForm">
        @csrf
        @method('PUT')

        {{-- Basics --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>Basics</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Used in listing cards and the booking form</span>
            </div>
            <div style="padding:18px;">
                <div class="form-row">
                    <div class="field">
                        <label>Destination name</label>
                        <input type="text" name="name" value="{{ old('name', $dest->name) }}" required>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option value="Published" @selected($dest->status === 'Published')>Published</option>
                            <option value="Draft" @selected($dest->status === 'Draft')>Draft</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Listing category</label>
                        <select name="category">
                            @foreach($listingCategories as $cat)
                                <option value="{{ $cat }}" @selected(strtolower($dest->category) === $cat)>{{ $catLabels[$cat] ?? $cat }}</option>
                            @endforeach
                            @if(! in_array(strtolower($dest->category), $listingCategories) && $dest->category)
                                <option value="{{ $dest->category }}" selected>Legacy: {{ $dest->category }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="field">
                        <label>Duration</label>
                        <input type="text" name="duration" value="{{ old('duration', $dest->duration) }}" required placeholder="e.g. Full day or 3-5 Days">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Location</label>
                        <input type="text" name="location" value="{{ old('location', $dest->location) }}" placeholder="e.g. Moshi, Kilimanjaro">
                    </div>
                    <div class="field">
                        <label>Rating (0–5)</label>
                        <input type="number" name="rating" step="0.1" min="0" max="5" value="{{ old('rating', $dest->rating) }}" placeholder="4.9">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Adult Price (USD)</label>
                        <input type="number" name="price_adult" step="0.01" value="{{ old('price_adult', $dest->price_adult) }}">
                    </div>
                    <div class="field">
                        <label>Child Price (USD)</label>
                        <input type="number" name="price_child" step="0.01" value="{{ old('price_child', $dest->price_child) }}">
                    </div>
                </div>
                <div class="field">
                    <label>Cover image URL</label>
                    <input type="text" name="image" value="{{ old('image', $dest->image) }}" oninput="updatePreview(this)" placeholder="https://…/tour-materuni.jpg">
                    <div style="margin-top:10px;">
                        <img id="imagePreview" src="{{ $dest->image }}" alt="" style="width:120px;height:80px;object-fit:cover;border-radius:10px;{{ $dest->image ? '' : 'display:none;' }}">
                    </div>
                </div>
                <div class="field">
                    <label>Short description (listing cards)</label>
                    <textarea name="desc" rows="3" placeholder="Hike through lush forests to a stunning waterfall…">{{ old('desc', $dest->desc) }}</textarea>
                </div>
            </div>
        </div>

        {{-- About This Tour --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>About This Tour</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Empty = default content</span>
            </div>
            <div style="padding:18px;">
                <div class="field">
                    <label>Overview / long description (HTML allowed)</label>
                    <textarea name="long_description" rows="8" placeholder="A full-day cultural immersion in Marangu…">{{ old('long_description', $dest->long_description) }}</textarea>
                </div>
                <div class="field" style="margin-top:16px;">
                    <label>Quick facts</label>
                </div>
                <div id="qfactRows">
                    @forelse($dest->quick_facts ?: [] as $fact)
                        <div class="qfact-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
                            <div class="field" style="flex:1;margin-bottom:0;">
                                <label>Label</label>
                                <input type="text" name="quick_facts[][label]" value="{{ $fact['label'] ?? '' }}" placeholder="Duration">
                            </div>
                            <div class="field" style="flex:2;margin-bottom:0;">
                                <label>Value</label>
                                <input type="text" name="quick_facts[][value]" value="{{ $fact['value'] ?? '' }}" placeholder="1 Day (approx. 7 hours)">
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                        </div>
                    @empty
                        <div class="qfact-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
                            <div class="field" style="flex:1;margin-bottom:0;">
                                <label>Label</label>
                                <input type="text" name="quick_facts[][label]" placeholder="Duration">
                            </div>
                            <div class="field" style="flex:2;margin-bottom:0;">
                                <label>Value</label>
                                <input type="text" name="quick_facts[][value]" placeholder="1 Day (approx. 7 hours)">
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-soft" onclick="addRow('qfactRow', 'qfactRows')">+ Add fact</button>
            </div>
        </div>

        {{-- Highlights --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>Highlights</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Empty = default content</span>
            </div>
            <div style="padding:18px;">
                <div id="highlightRows">
                    @forelse($dest->highlights ?: [] as $h)
                        <div class="highlight-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
                            <div class="field" style="flex:1;margin-bottom:0;">
                                <label>Icon</label>
                                <select name="highlights[][icon]">
                                    @foreach($iconOptions as $icon)
                                        <option value="{{ $icon }}" @selected(($h['icon'] ?? '') === $icon)>{{ $icon }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field" style="flex:3;margin-bottom:0;">
                                <label>Text</label>
                                <input type="text" name="highlights[][text]" value="{{ $h['text'] ?? '' }}" placeholder="Materuni Waterfall">
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                        </div>
                    @empty
                        <div class="highlight-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
                            <div class="field" style="flex:1;margin-bottom:0;">
                                <label>Icon</label>
                                <select name="highlights[][icon]">
                                    @foreach($iconOptions as $icon)
                                        <option value="{{ $icon }}" @selected($icon === 'fa-leaf')>{{ $icon }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field" style="flex:3;margin-bottom:0;">
                                <label>Text</label>
                                <input type="text" name="highlights[][text]" placeholder="Materuni Waterfall">
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-soft" onclick="addRow('highlightRow', 'highlightRows')">+ Add highlight</button>
            </div>
        </div>

        {{-- Detailed Itinerary --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>Detailed Itinerary</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Empty = default content</span>
            </div>
            <div style="padding:18px;">
                <div id="itinRows">
                    @forelse($dest->itinerary ?: [] as $it)
                        <div class="itin-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
                            <div class="form-row">
                                <div class="field">
                                    <label>Label / time</label>
                                    <input type="text" name="itinerary[][label]" value="{{ $it['label'] ?? '' }}" placeholder="09:00 AM">
                                </div>
                                <div class="field" style="flex:2;">
                                    <label>Title</label>
                                    <input type="text" name="itinerary[][title]" value="{{ $it['title'] ?? '' }}" placeholder="Pickup">
                                </div>
                            </div>
                            <div class="field">
                                <label>Description</label>
                                <textarea name="itinerary[][desc]" rows="2" placeholder="Hotel pickup and drive to…">{{ $it['desc'] ?? '' }}</textarea>
                            </div>
                            <div class="form-row">
                                <div class="field">
                                    <label>Activities</label>
                                    <input type="text" name="itinerary[][activities]" value="{{ $it['activities'] ?? '' }}" placeholder="Transfer">
                                </div>
                                <div class="field">
                                    <label>Meals</label>
                                    <input type="text" name="itinerary[][meals]" value="{{ $it['meals'] ?? '' }}" placeholder="Lunch">
                                </div>
                                <div class="field">
                                    <label>Accommodation</label>
                                    <input type="text" name="itinerary[][accommodation]" value="{{ $it['accommodation'] ?? '' }}" placeholder="Lodge or Tented Camp">
                                </div>
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" style="margin-top:6px;">✕ Remove this day</button>
                        </div>
                    @empty
                        <div class="itin-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
                            <div class="form-row">
                                <div class="field">
                                    <label>Label / time</label>
                                    <input type="text" name="itinerary[][label]" placeholder="DAY 01">
                                </div>
                                <div class="field" style="flex:2;">
                                    <label>Title</label>
                                    <input type="text" name="itinerary[][title]" placeholder="Pickup &amp; drive">
                                </div>
                            </div>
                            <div class="field">
                                <label>Description</label>
                                <textarea name="itinerary[][desc]" rows="2" placeholder="Hotel pickup and drive to…"></textarea>
                            </div>
                            <div class="form-row">
                                <div class="field">
                                    <label>Activities</label>
                                    <input type="text" name="itinerary[][activities]" placeholder="Transfer">
                                </div>
                                <div class="field">
                                    <label>Meals</label>
                                    <input type="text" name="itinerary[][meals]" placeholder="Lunch">
                                </div>
                                <div class="field">
                                    <label>Accommodation</label>
                                    <input type="text" name="itinerary[][accommodation]" placeholder="Lodge or Tented Camp">
                                </div>
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" style="margin-top:6px;">✕ Remove this day</button>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-soft" onclick="addRow('itinRow', 'itinRows')">+ Add day / step</button>
            </div>
        </div>

        {{-- Included & Excluded --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>What's Included & Not Included</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Empty = default content</span>
            </div>
            <div style="padding:18px;display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                <div>
                    <label class="rep-label"><strong>Included</strong></label>
                    <div id="includedRows">
                        @forelse($dest->includes ?: [] as $inc)
                            <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
                                <input type="text" name="includes[]" value="{{ $inc }}" style="flex:1;" placeholder="Professional guide">
                                <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                            </div>
                        @empty
                            <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
                                <input type="text" name="includes[]" style="flex:1;" placeholder="Professional guide">
                                <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-soft" onclick="addRow('includedRow', 'includedRows')">+ Add included item</button>
                </div>
                <div>
                    <label class="rep-label"><strong>Excluded</strong></label>
                    <div id="excludedRows">
                        @forelse($dest->excluded ?: [] as $exc)
                            <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
                                <input type="text" name="excluded[]" value="{{ $exc }}" style="flex:1;" placeholder="Travel insurance">
                                <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                            </div>
                        @empty
                            <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
                                <input type="text" name="excluded[]" style="flex:1;" placeholder="Travel insurance">
                                <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                            </div>
                        @endforelse
                    </div>
                    <button type="button" class="btn btn-soft" onclick="addRow('excludedRow', 'excludedRows')">+ Add excluded item</button>
                </div>
            </div>
        </div>

        {{-- FAQs --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>Frequently Asked Questions</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Empty = default content</span>
            </div>
            <div style="padding:18px;">
                <div id="faqRows">
                    @forelse($dest->faqs ?: [] as $faq)
                        <div class="faq-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
                            <div class="field">
                                <label>Question</label>
                                <input type="text" name="faqs[][q]" value="{{ $faq['q'] ?? '' }}" placeholder="Is lunch included?">
                            </div>
                            <div class="field">
                                <label>Answer</label>
                                <textarea name="faqs[][a]" rows="2" placeholder="Yes, a traditional lunch is included.">{{ $faq['a'] ?? '' }}</textarea>
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)">✕ Remove question</button>
                        </div>
                    @empty
                        <div class="faq-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
                            <div class="field">
                                <label>Question</label>
                                <input type="text" name="faqs[][q]" placeholder="Is lunch included?">
                            </div>
                            <div class="field">
                                <label>Answer</label>
                                <textarea name="faqs[][a]" rows="2" placeholder="Yes, a traditional lunch is included."></textarea>
                            </div>
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)">✕ Remove question</button>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-soft" onclick="addRow('faqRow', 'faqRows')">+ Add question</button>
            </div>
        </div>

        {{-- Gallery --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong>Tour Gallery</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Image URLs shown on the tour page. Empty = default content</span>
            </div>
            <div style="padding:18px;">
                <div id="galleryRows">
                    @forelse($dest->gallery ?: [] as $g)
                        <div class="gallery-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:center;">
                            <img src="{{ $g }}" alt="" onerror="this.style.display='none'" style="width:70px;height:50px;object-fit:cover;border-radius:8px;flex:none;">
                            <input type="text" name="gallery[]" value="{{ $g }}" style="flex:1;" placeholder="https://…/photo.jpg" oninput="previewGalleryRow(this)">
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                        </div>
                    @empty
                        <div class="gallery-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:center;">
                            <img src="" alt="" onerror="this.style.display='none'" style="width:70px;height:50px;object-fit:cover;border-radius:8px;flex:none;display:none;">
                            <input type="text" name="gallery[]" style="flex:1;" placeholder="https://…/photo.jpg" oninput="previewGalleryRow(this)">
                            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
                        </div>
                    @endforelse
                </div>
                <button type="button" class="btn btn-soft" onclick="addRow('galleryRow', 'galleryRows')">+ Add image</button>
            </div>
        </div>

        {{-- SEO --}}
        <div class="table-card" style="margin-bottom:18px;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);"><strong>SEO</strong></div>
            <div style="padding:18px;">
                <div class="field">
                    <label>Meta title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $dest->meta_title) }}">
                </div>
                <div class="field">
                    <label>Meta description</label>
                    <textarea name="meta_description" rows="3">{{ old('meta_description', $dest->meta_description) }}</textarea>
                </div>
                <div class="field">
                    <label>Meta keywords</label>
                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $dest->meta_keywords) }}">
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;align-items:center;">
            <button type="submit" class="btn btn-primary">Save destination</button>
            <a href="{{ route('admin.destinations') }}" class="btn btn-ghost">Cancel</a>
            <span style="flex:1;"></span>
        </div>
    </form>

    <div style="margin-top:26px;padding-top:18px;border-top:1px solid var(--line);">
        <form method="POST" action="{{ route('admin.destinations.destroy', $dest->id) }}" onsubmit="return confirm('Delete &quot;{{ $dest->name }}&quot;? This removes it from the live site listings.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete destination</button>
        </form>
    </div>
</div>

<script>
const ICON_OPTIONS = @json($iconOptions);

function updatePreview(input) {
    const preview = document.getElementById('imagePreview');
    if (input.value) {
        preview.src = input.value;
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

function previewGalleryRow(input) {
    const img = input.closest('.gallery-row').querySelector('img');
    if (input.value) {
        img.src = input.value;
        img.style.display = 'block';
    } else {
        img.style.display = 'none';
    }
}

function removeRow(btn) {
    btn.closest('.rep-row').remove();
}

function iconSelect(selected = 'fa-leaf') {
    return ICON_OPTIONS.map(icon =>
        `<option value="${icon}" ${icon === selected ? 'selected' : ''}>${icon}</option>`
    ).join('');
}

const builders = {
    qfactRow: () => `
        <div class="qfact-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
            <div class="field" style="flex:1;margin-bottom:0;"><label>Label</label><input type="text" name="quick_facts[][label]" placeholder="Duration"></div>
            <div class="field" style="flex:2;margin-bottom:0;"><label>Value</label><input type="text" name="quick_facts[][value]" placeholder="1 Day (approx. 7 hours)"></div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    highlightRow: () => `
        <div class="highlight-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
            <div class="field" style="flex:1;margin-bottom:0;"><label>Icon</label><select name="highlights[][icon]">${iconSelect()}</select></div>
            <div class="field" style="flex:3;margin-bottom:0;"><label>Text</label><input type="text" name="highlights[][text]" placeholder="Materuni Waterfall"></div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    itinRow: () => `
        <div class="itin-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
            <div class="form-row">
                <div class="field"><label>Label / time</label><input type="text" name="itinerary[][label]" placeholder="DAY 01"></div>
                <div class="field" style="flex:2;"><label>Title</label><input type="text" name="itinerary[][title]" placeholder="Pickup &amp; drive"></div>
            </div>
            <div class="field"><label>Description</label><textarea name="itinerary[][desc]" rows="2" placeholder="Hotel pickup and drive to…"></textarea></div>
            <div class="form-row">
                <div class="field"><label>Activities</label><input type="text" name="itinerary[][activities]" placeholder="Transfer"></div>
                <div class="field"><label>Meals</label><input type="text" name="itinerary[][meals]" placeholder="Lunch"></div>
                <div class="field"><label>Accommodation</label><input type="text" name="itinerary[][accommodation]" placeholder="Lodge or Tented Camp"></div>
            </div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" style="margin-top:6px;">✕ Remove this day</button>
        </div>`,
    includedRow: () => `
        <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
            <input type="text" name="includes[]" style="flex:1;" placeholder="Professional guide">
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    excludedRow: () => `
        <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
            <input type="text" name="excluded[]" style="flex:1;" placeholder="Travel insurance">
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    faqRow: () => `
        <div class="faq-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
            <div class="field"><label>Question</label><input type="text" name="faqs[][q]" placeholder="Is lunch included?"></div>
            <div class="field"><label>Answer</label><textarea name="faqs[][a]" rows="2" placeholder="Yes, a traditional lunch is included."></textarea></div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)">✕ Remove question</button>
        </div>`,
    galleryRow: () => `
        <div class="gallery-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:center;">
            <img src="" alt="" style="width:70px;height:50px;object-fit:cover;border-radius:8px;flex:none;display:none;">
            <input type="text" name="gallery[]" style="flex:1;" placeholder="https://…/photo.jpg" oninput="previewGalleryRow(this)">
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
};

function addRow(type, containerId) {
    const builder = builders[type];
    if (!builder) return;
    const temp = document.createElement('div');
    temp.innerHTML = builder();
    document.getElementById(containerId).appendChild(temp.firstElementChild);
}
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection