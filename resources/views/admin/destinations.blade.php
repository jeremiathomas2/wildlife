@extends('admin.layout')

@section('title', 'Destinations')

@section('content')
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
                                <button onclick="editDestination({{ $dest->id }})" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                    </svg>
                                </button>
                                <button class="danger" onclick="confirmDeleteDest({{ $dest->id }}, '{{ escapeQuotes($dest->name) }}')" title="Delete">
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
            {{ $destinations->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal-backdrop" id="destModalBackdrop">
    <div class="modal">
        <div class="modal-head">
            <h3 id="destModalTitle">Add destination</h3>
            <button class="modal-close" onclick="closeModal('destModalBackdrop')">✕</button>
        </div>
        <form id="destForm" onsubmit="handleSubmit(event)">
            @csrf
            <input type="hidden" id="destId" name="id">
            <input type="hidden" name="_method" value="" id="destMethod">
            <div class="modal-body">
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
                        <input type="text" id="destDuration" name="duration" placeholder="e.g. Full day or 3-5 Days">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Adult Price (USD)</label>
                        <input type="number" id="destPriceAdult" name="price_adult" placeholder="80">
                    </div>
                    <div class="field">
                        <label>Child Price (USD)</label>
                        <input type="number" id="destPriceChild" name="price_child" placeholder="40">
                    </div>
                </div>
                <div class="field">
                    <label>Cover image URL</label>
                    <input type="text" id="destImage" name="image" placeholder="https://…/tour-materuni.jpg">
                </div>
                <div class="field">
                    <label>Short description</label>
                    <textarea id="destDesc" name="desc" rows="3" placeholder="Hike through lush forests to a stunning waterfall…"></textarea>
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

    if (id) {
        const destData = destinationsData.find(d => d.id === id);
        if (destData) {
            document.getElementById('destMethod').value = 'PUT';
            document.getElementById('destId').value = destData.id;
            document.getElementById('destName').value = destData.name;
            document.getElementById('destCategory').value = destData.category;
            document.getElementById('destStatus').value = destData.status;
            document.getElementById('destDuration').value = destData.duration;
            document.getElementById('destPriceAdult').value = destData.price_adult;
            document.getElementById('destPriceChild').value = destData.price_child;
            document.getElementById('destImage').value = destData.image;
            document.getElementById('destDesc').value = destData.desc;
        }
    } else {
        document.getElementById('destMethod').value = '';
        document.getElementById('destId').value = '';
        document.getElementById('destName').value = '';
        document.getElementById('destCategory').value = 'Day Trip';
        document.getElementById('destStatus').value = 'Published';
        document.getElementById('destDuration').value = '';
        document.getElementById('destPriceAdult').value = '';
        document.getElementById('destPriceChild').value = '';
        document.getElementById('destImage').value = '';
        document.getElementById('destDesc').value = '';
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
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Server Error:', response.status, errorText);
            toast(`Error: ${response.status}`, 'error');
            return;
        }
        
        const data = await response.json();
        
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
            
            const data = await response.json();
            
            if (data.success) {
                toast(data.message, 'success');
                window.location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
            toast('Something went wrong!', 'error');
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
