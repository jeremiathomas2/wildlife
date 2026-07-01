@extends('admin.layout')

@section('title', 'Reviews')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Traveler Reviews</h2>
            <p class="sub">Approve, feature, or remove reviews submitted by guests.</p>
        </div>
        <div class="view-actions">
            <div class="chip-filters" style="margin:0;">
                <button class="chip active" data-filter="all" onclick="setReviewFilter('all')">All</button>
                <button class="chip" data-filter="Pending" onclick="setReviewFilter('Pending')">Pending</button>
                <button class="chip" data-filter="Published" onclick="setReviewFilter('Published')">Published</button>
            </div>
        </div>
    </div>

    <div id="reviewsList">
        @if($reviews->isEmpty())
        <div style="text-align: center; padding: 40px; color: var(--ink-soft);">No reviews yet.</div>
        @else
        @foreach($reviews as $review)
        <div class="review-card" data-id="{{ $review->id }}" data-status="{{ $review->status }}">
            <div class="review-avatar">{{ strtoupper(substr($review->name, 0, 1)) }}</div>
            <div style="flex:1;">
                <div class="review-top">
                    <div>
                        <div class="review-name">{{ $review->name }}</div>
                        <div class="review-tour">{{ $review->tour }}</div>
                    </div>
                    {!! \App\Http\Controllers\AdminController::statusTag($review->status) !!}
                </div>
                <div class="stars" style="font-size: 16px;">
                    @for($i=0; $i < 5; $i++)
                        @if($i < $review->rating)
                            <span style="color: #D4A24C;">★</span>
                        @else
                            <span style="color: #d1d5db;">★</span>
                        @endif
                    @endfor
                </div>
                <p class="review-text">{{ $review->text }}</p>
                <div class="review-actions">
                    @if($review->status === 'Pending')
                    <form action="{{ route('admin.reviews.update', [$review->id, 'Published']) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-soft btn-sm">Approve</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>

<script>
function setReviewFilter(filter) {
    document.querySelectorAll('.chip').forEach(c => c.classList.toggle('active', c.dataset.filter === filter));
    document.querySelectorAll('.review-card').forEach(card => {
        if (filter === 'all' || card.dataset.status === filter) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection
