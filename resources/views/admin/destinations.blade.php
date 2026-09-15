@extends('admin.layout')

@section('title', 'Destinations')

@section('content')
@php
$adminIconOptions = ['fa-leaf','fa-water','fa-mountain','fa-mug-hot','fa-users','fa-utensils','fa-camera','fa-tree','fa-sun','fa-swimmer','fa-landmark','fa-hiking','fa-binoculars','fa-elephant','fa-lion','fa-paw','fa-rhino','fa-umbrella-beach','fa-seedling','fa-ship','fa-fish','fa-pencil-ruler','fa-user-tie','fa-calendar-alt','fa-wallet','fa-map','fa-heart','fa-flag','fa-mountain-sun','fa-snowflake','fa-truck-monster'];
@endphp
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Destinations & Tours</h2>
            <p class="sub">Manage day trips and multi-day safari packages shown on the live site.</p>
        </div>
        <div class="view-actions">
            <button class="btn btn-primary" onclick="openDestinationModal()">+ Add destination</button>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="chip-filters" id="destFilterChips">
                <button class="chip active" data-filter="all" onclick="setDestFilter('all')">All</button>
                <button class="chip" data-filter="Day Trip" onclick="setDestFilter('Day Trip')">Day Trips</button>
                <button class="chip" data-filter="Multi-Day Safari" onclick="setDestFilter('Multi-Day Safari')">Multi-Day Safaris</button>
                <button class="chip" data-filter="Published" onclick="setDestFilter('Published')">Published</button>
                <button class="chip" data-filter="Draft" onclick="setDestFilter('Draft')">Drafts</button>
            </div>
            <div class="table-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Search destinations…" oninput="filterDestinations(this.value)">
            </div>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Destination</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Adult Price</th>
                        <th>Child Price</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="destinationsBody">
                    @if($destinations->isEmpty())
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M3 11 12 4l9 7"></path>
                                    <path d="M5 10v10h14V10"></path>
                                </svg>
                                <h4>No destinations found</h4>
                                <p>Try a different filter or add a new destination.</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach($destinations as $dest)
                    <tr data-id="{{ $dest->id }}" data-category="{{ $dest->category }}" data-status="{{ $dest->status }}" data-name="{{ strtolower($dest->name) }}">
                        <td>
                            <div class="cell-main">
                                <img class="thumb" src="{{ $dest->image }}" alt="">
                                <div>
                                    <div class="cell-title">{{ $dest->name }}</div>
                                    <div class="cell-sub">{{ \Illuminate\Support\Str::limit($dest->desc, 46) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $dest->category }}</td>
                        <td>{{ $dest->duration }}</td>
                        <td>${{ number_format($dest->price_adult ?? $dest->price) }}</td>
                        <td>${{ number_format($dest->price_child ?? ($dest->price / 2)) }}</td>
                        <td>{!! \App\Http\Controllers\AdminController::statusTag($dest->status) !!}</td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('destination.detail', $dest->slug) }}" target="_blank" rel="noopener" title="View live page">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <button onclick="openDestinationModal({{ $dest->id }})" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                    </svg>
                                </button>
                                <button class="danger" onclick="confirmDeleteDest({{ $dest->id }}, '{{ htmlspecialchars(str_replace("'", "\\'", $dest->name), ENT_QUOTES, 'UTF-8') }}')" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if($destinations->hasPages())
        <div class="table-pagination">
            {{ $destinations->appends(request()->query())->links('vendor.pagination.admin') }}
        </div>
        @endif
    </div>
</div>

<div class="modal-backdrop" id="destModalBackdrop">
    <div class="modal" style="max-width:860px;">
        <div class="modal-head">
            <h3 id="destModalTitle">Add destination</h3>
            <button class="modal-close" onclick="closeModal('destModalBackdrop')">✕</button>
        </div>
        <form id="destForm" onsubmit="handleSubmit(event)">
            @csrf
            <input type="hidden" id="destId" name="id">
            <input type="hidden" name="_method" value="" id="destMethod">
            <div class="modal-body">
                <div style="font-size:12.5px;color:var(--ink-soft);margin:-6px 0 16px;">All fields shown here appear on the live destination page. Blank rich-content sections fall back to the default tour content.</div>

                <div class="field">
                    <label>Destination name</label>
                    <input type="text" id="destName" name="name" placeholder="e.g. Materuni Waterfall & Coffee Tour" required>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Category</label>
                        <select id="destCategory" name="category">
                            <option>Day Trip</option>
                            <option>Multi-Day Safari</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select id="destStatus" name="status">
                            <option>Published</option>
                            <option>Draft</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Duration</label>
                        <input type="text" id="destDuration" name="duration" placeholder="e.g. Full day or 3-5 Days" required>
                    </div>
                    <div class="field">
                        <label>Rating (0–5)</label>
                        <input type="number" id="destRating" name="rating" step="0.1" min="0" max="5" placeholder="4.9">
                    </div>
                </div>
                <div class="field">
                    <label>Location</label>
                    <input type="text" id="destLocation" name="location" placeholder="e.g. Moshi, Kilimanjaro">
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Adult Price (USD)</label>
                        <input type="number" id="destPriceAdult" name="price_adult" step="0.01" placeholder="80">
                    </div>
                    <div class="field">
                        <label>Child Price (USD)</label>
                        <input type="number" id="destPriceChild" name="price_child" step="0.01" placeholder="40">
                    </div>
                </div>
                <div class="field">
                    <label>Cover image URL</label>
                    <input type="text" id="destImage" name="image" oninput="updatePreview(this)" placeholder="https://…/tour-materuni.jpg">
                    <div style="margin-top:10px;">
                        <img id="imagePreview" src="" alt="" onerror="this.style.display='none'" style="width:120px;height:80px;object-fit:cover;border-radius:10px;display:none;">
                    </div>
                </div>
                <div class="field">
                    <label>Short description (listing cards)</label>
                    <textarea id="destDesc" name="desc" rows="3" placeholder="Hike through lush forests to a stunning waterfall…"></textarea>
                </div>
                <div class="field">
                    <label>Overview / long description (HTML allowed)</label>
                    <textarea id="destLongDesc" name="long_description" rows="5" placeholder="A full-day cultural immersion in Marangu…"></textarea>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:4px;">
                    <label><strong>Quick facts</strong></label>
                    <div id="qfactRows"></div>
                    <button type="button" class="btn btn-soft" onclick="addRow('qfactRow', 'qfactRows')">+ Add fact</button>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:18px;">
                    <label><strong>Highlights</strong></label>
                    <div id="highlightRows"></div>
                    <button type="button" class="btn btn-soft" onclick="addRow('highlightRow', 'highlightRows')">+ Add highlight</button>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:18px;">
                    <label><strong>Detailed Itinerary</strong></label>
                    <div id="itinRows"></div>
                    <button type="button" class="btn btn-soft" onclick="addRow('itinRow', 'itinRows')">+ Add day / step</button>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:18px;display:grid;grid-template-columns:1fr 1fr;gap:24px;">
                    <div>
                        <label><strong>Included</strong></label>
                        <div id="includedRows"></div>
                        <button type="button" class="btn btn-soft" onclick="addRow('includedRow', 'includedRows')">+ Add included item</button>
                    </div>
                    <div>
                        <label><strong>Excluded</strong></label>
                        <div id="excludedRows"></div>
                        <button type="button" class="btn btn-soft" onclick="addRow('excludedRow', 'excludedRows')">+ Add excluded item</button>
                    </div>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:18px;">
                    <label><strong>Frequently Asked Questions</strong></label>
                    <div id="faqRows"></div>
                    <button type="button" class="btn btn-soft" onclick="addRow('faqRow', 'faqRows')">+ Add question</button>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:18px;">
                    <label><strong>Tour Gallery</strong></label>
                    <div id="galleryRows"></div>
                    <button type="button" class="btn btn-soft" onclick="addRow('galleryRow', 'galleryRows')">+ Add image</button>
                </div>

                <div style="border-top:1px solid var(--line);padding-top:16px;margin-top:18px;">
                    <label><strong>SEO</strong></label>
                    <div class="field">
                        <label>Meta title</label>
                        <input type="text" id="destMetaTitle" name="meta_title">
                    </div>
                    <div class="field">
                        <label>Meta description</label>
                        <textarea id="destMetaDesc" name="meta_description" rows="3"></textarea>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Meta keywords</label>
                        <input type="text" id="destMetaKeywords" name="meta_keywords">
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('destModalBackdrop')">Cancel</button>
                <button type="submit" class="btn btn-primary" id="destSubmitBtn">Save destination</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-backdrop" id="confirmModalBackdrop">
    <div class="modal" style="max-width:400px;">
        <div class="modal-head">
            <h3>Delete item?</h3>
            <button class="modal-close" onclick="closeModal('confirmModalBackdrop')">✕</button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--ink-soft);line-height:1.6;" id="confirmText">This action cannot be undone.</p>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('confirmModalBackdrop')">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn" onclick="executeDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
let destinationsData = @json($destinations->items());
let currentFilter = 'all';
let currentSearch = '';

const ICON_OPTIONS = @json($adminIconOptions);

function escAttr(s) {
    return String(s == null ? '' : s)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;')
        .replace(/</g, '&lt;');
}

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

function iconSelect(selected) {
    return ICON_OPTIONS.map(icon =>
        `<option value="${icon}" ${String(icon) === String(selected || 'fa-leaf') ? 'selected' : ''}>${icon}</option>`
    ).join('');
}

const builders = {
    qfactRow: (d) => `
        <div class="qfact-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
            <div class="field" style="flex:1;margin-bottom:0;"><label>Label</label><input type="text" name="quick_facts[][label]" value="${escAttr(d && d.label)}" placeholder="Duration"></div>
            <div class="field" style="flex:2;margin-bottom:0;"><label>Value</label><input type="text" name="quick_facts[][value]" value="${escAttr(d && d.value)}" placeholder="1 Day (approx. 7 hours)"></div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    highlightRow: (d) => `
        <div class="highlight-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:flex-end;">
            <div class="field" style="flex:1;margin-bottom:0;"><label>Icon</label><select name="highlights[][icon]">${iconSelect(d && d.icon)}</select></div>
            <div class="field" style="flex:3;margin-bottom:0;"><label>Text</label><input type="text" name="highlights[][text]" value="${escAttr(d && d.text)}" placeholder="Materuni Waterfall"></div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    itinRow: (d) => `
        <div class="itin-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
            <div class="form-row">
                <div class="field"><label>Label / time</label><input type="text" name="itinerary[][label]" value="${escAttr(d && d.label)}" placeholder="DAY 01"></div>
                <div class="field" style="flex:2;"><label>Title</label><input type="text" name="itinerary[][title]" value="${escAttr(d && d.title)}" placeholder="Pickup &amp; drive"></div>
            </div>
            <div class="field"><label>Description</label><textarea name="itinerary[][desc]" rows="2" placeholder="Hotel pickup and drive to…">${escAttr(d && d.desc)}</textarea></div>
            <div class="form-row">
                <div class="field"><label>Activities</label><input type="text" name="itinerary[][activities]" value="${escAttr(d && d.activities)}" placeholder="Transfer"></div>
                <div class="field"><label>Meals</label><input type="text" name="itinerary[][meals]" value="${escAttr(d && d.meals)}" placeholder="Lunch"></div>
                <div class="field"><label>Accommodation</label><input type="text" name="itinerary[][accommodation]" value="${escAttr(d && d.accommodation)}" placeholder="Lodge or Tented Camp"></div>
            </div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" style="margin-top:6px;">✕ Remove this day</button>
        </div>`,
    includedRow: (v) => `
        <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
            <input type="text" name="includes[]" value="${escAttr(v)}" style="flex:1;" placeholder="Professional guide">
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    excludedRow: (v) => `
        <div class="list-row rep-row" style="display:flex;gap:10px;margin-bottom:8px;align-items:center;">
            <input type="text" name="excluded[]" value="${escAttr(v)}" style="flex:1;" placeholder="Travel insurance">
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
    faqRow: (d) => `
        <div class="faq-row rep-row" style="border:1px solid var(--line);border-radius:12px;padding:14px;margin-bottom:12px;">
            <div class="field"><label>Question</label><input type="text" name="faqs[][q]" value="${escAttr(d && d.q)}" placeholder="Is lunch included?"></div>
            <div class="field"><label>Answer</label><textarea name="faqs[][a]" rows="2" placeholder="Yes, a traditional lunch is included.">${escAttr(d && d.a)}</textarea></div>
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)">✕ Remove question</button>
        </div>`,
    galleryRow: (v) => `
        <div class="gallery-row rep-row" style="display:flex;gap:10px;margin-bottom:10px;align-items:center;">
            <img src="${escAttr(v)}" alt="" onerror="this.style.display='none'" ${v ? 'style="width:70px;height:50px;object-fit:cover;border-radius:8px;flex:none;display:block;"' : 'style="display:none;width:70px;height:50px;object-fit:cover;border-radius:8px;flex:none;"'}>
            <input type="text" name="gallery[]" value="${escAttr(v)}" style="flex:1;" placeholder="https://…/photo.jpg" oninput="previewGalleryRow(this)">
            <button type="button" class="btn btn-ghost" onclick="removeRow(this)" title="Remove">✕</button>
        </div>`,
};

function addRow(type, containerId, data) {
    const builder = builders[type];
    if (!builder) return;
    const temp = document.createElement('div');
    temp.innerHTML = builder(data);
    document.getElementById(containerId).appendChild(temp.firstElementChild);
}

function fillRepeater(containerId, type, rows) {
    const el = document.getElementById(containerId);
    el.innerHTML = '';
    if (rows && rows.length) {
        rows.forEach(r => addRow(type, containerId, r));
    } else {
        addRow(type, containerId, null);
    }
}

function resetDestinationModal() {
    document.getElementById('destMethod').value = '';
    document.getElementById('destId').value = '';
    document.getElementById('destName').value = '';
    document.getElementById('destCategory').value = 'Day Trip';
    document.getElementById('destStatus').value = 'Published';
    document.getElementById('destDuration').value = '';
    document.getElementById('destLocation').value = '';
    document.getElementById('destRating').value = '';
    document.getElementById('destPriceAdult').value = '';
    document.getElementById('destPriceChild').value = '';
    document.getElementById('destImage').value = '';
    document.getElementById('destDesc').value = '';
    document.getElementById('destLongDesc').value = '';
    document.getElementById('destMetaTitle').value = '';
    document.getElementById('destMetaDesc').value = '';
    document.getElementById('destMetaKeywords').value = '';
    const preview = document.getElementById('imagePreview');
    preview.style.display = 'none';
    fillRepeater('qfactRows', 'qfactRow', null);
    fillRepeater('highlightRows', 'highlightRow', null);
    fillRepeater('itinRows', 'itinRow', null);
    fillRepeater('includedRows', 'includedRow', null);
    fillRepeater('excludedRows', 'excludedRow', null);
    fillRepeater('faqRows', 'faqRow', null);
    fillRepeater('galleryRows', 'galleryRow', null);
}

function escapeQuotes(str) {
    return str.replace(/'/g, '\\\'').replace(/"/g, '\\"');
}

function setDestFilter(filter) {
    currentFilter = filter;
    document.querySelectorAll('#destFilterChips .chip').forEach(c => c.classList.toggle('active', c.dataset.filter === filter));
    renderFilteredDestinations();
}

function filterDestinations(search) {
    currentSearch = search.toLowerCase();
    renderFilteredDestinations();
}

function renderFilteredDestinations() {
    document.querySelectorAll('#destinationsBody tr').forEach(tr => {
        if (!tr.dataset.id) return;
        let match = true;
        if (currentFilter !== 'all') {
            match = (tr.dataset.category === currentFilter || tr.dataset.status === currentFilter);
        }
        if (currentSearch) {
            match = match && tr.dataset.name.includes(currentSearch);
        }
        tr.style.display = match ? 'table-row' : 'none';
    });
}

function openDestinationModal(id = null) {
    const title = document.getElementById('destModalTitle');
    title.textContent = id ? 'Edit destination' : 'Add destination';
    const form = document.getElementById('destForm');
    const submitBtn = document.getElementById('destSubmitBtn');
    submitBtn.textContent = id ? 'Update destination' : 'Save destination';

    resetDestinationModal();

    if (id) {
        const destData = destinationsData.find(d => d.id === id);
        if (destData) {
            document.getElementById('destMethod').value = 'PUT';
            document.getElementById('destId').value = destData.id;
            document.getElementById('destName').value = destData.name;
            document.getElementById('destCategory').value = destData.category;
            document.getElementById('destStatus').value = destData.status;
            document.getElementById('destDuration').value = destData.duration;
            document.getElementById('destLocation').value = destData.location || '';
            document.getElementById('destRating').value = destData.rating ?? '';
            document.getElementById('destPriceAdult').value = destData.price_adult;
            document.getElementById('destPriceChild').value = destData.price_child;
            document.getElementById('destImage').value = destData.image;
            document.getElementById('destDesc').value = destData.desc;
            document.getElementById('destLongDesc').value = destData.long_description || '';
            document.getElementById('destMetaTitle').value = destData.meta_title || '';
            document.getElementById('destMetaDesc').value = destData.meta_description || '';
            document.getElementById('destMetaKeywords').value = destData.meta_keywords || '';
            if (destData.image) {
                const preview = document.getElementById('imagePreview');
                preview.src = destData.image;
                preview.style.display = 'block';
            }
            fillRepeater('qfactRows', 'qfactRow', destData.quick_facts || null);
            fillRepeater('highlightRows', 'highlightRow', destData.highlights || null);
            fillRepeater('itinRows', 'itinRow', destData.itinerary || null);
            fillRepeater('includedRows', 'includedRow', destData.includes || null);
            fillRepeater('excludedRows', 'excludedRow', destData.excluded || null);
            fillRepeater('faqRows', 'faqRow', destData.faqs || null);
            fillRepeater('galleryRows', 'galleryRow', destData.gallery || null);
        }
    }
    openModal('destModalBackdrop');
}

function editDestination(id) {
    openDestinationModal(id);
}

async function handleSubmit(event) {
    event.preventDefault();
    const form = document.getElementById('destForm');
    const submitBtn = document.getElementById('destSubmitBtn');
    const id = document.getElementById('destId').value;
    submitBtn.disabled = true;
    submitBtn.textContent = id ? 'Updating...' : 'Saving...';
    
    const formData = new FormData(form);
    let url = "{{ route('admin.destinations.store') }}";
    let method = 'POST';
    
    if (id) {
        url = `/live/destinations/${id}`;
        formData.append('_method', 'PUT');
    }
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData,
        });

        const rawText = await response.text();
        let data = null;
        try {
            data = rawText ? JSON.parse(rawText) : null;
        } catch (e) {
            data = null;
        }

        if (response.status === 419) {
            toast('Session expired or invalid. Please log in again and retry.', 'error');
            return;
        }

        if (!response.ok) {
            console.error('Server Error:', response.status, rawText);
            toast(data && data.message ? data.message : `Error: ${response.status}`, 'error');
            return;
        }

        if (!data) {
            console.error('Non-JSON response:', rawText);
            toast('Your admin session may have expired. Please refresh, log in again, and retry.', 'error');
            return;
        }

        if (data.success) {
            toast(data.message, 'success');
            window.location.reload();
        } else if (data.errors) {
            const errorMessages = Object.values(data.errors).flat().join(', ');
            toast(errorMessages, 'error');
        } else {
            toast(data.message || 'Something went wrong!', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        toast('Something went wrong! Please check the console.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = id ? 'Update destination' : 'Save destination';
    }
}

function confirmDeleteDest(id, name) {
    document.getElementById('confirmText').textContent = 'Delete "' + name + '"? This will remove it from the live site listings.';
    pendingDeleteFunc = async () => {
        try {
            const response = await fetch(`/live/destinations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Content-Type': 'application/json',
                },
            });

            const rawText = await response.text();
            let data = null;
            try {
                data = rawText ? JSON.parse(rawText) : null;
            } catch (e) {
                data = null;
            }

            if (response.status === 419) {
                toast('Session expired or invalid. Please log in again and retry.', 'error');
                return;
            }

            if (!response.ok) {
                toast(data && data.message ? data.message : `Error: ${response.status}`, 'error');
                return;
            }

            if (!data) {
                toast('Your admin session may have expired. Please refresh, log in again, and retry.', 'error');
                return;
            }

            if (data.success) {
                toast(data.message, 'success');
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
            toast('Something went wrong! Please check the console.', 'error');
        }
    };
    openModal('confirmModalBackdrop');
}

function executeDelete() {
    if (pendingDeleteFunc) {
        pendingDeleteFunc();
    }
    closeModal('confirmModalBackdrop');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    renderFilteredDestinations();
});
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection
