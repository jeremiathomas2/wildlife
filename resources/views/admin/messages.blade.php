@extends('admin.layout')

@section('title', 'Messages')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Contact Messages</h2>
            <p class="sub">Inquiries submitted through the website contact form.</p>
        </div>
    </div>

    <div class="msg-layout">
        <div class="msg-list">
            @if($messages->isEmpty())
            <div style="padding:40px; text-align:center; color: var(--ink-soft);">No messages yet.</div>
            @else
            @foreach($messages as $msg)
            <div class="msg-item {{ $msg->read ? '' : 'unread' }} {{ request('active') == $msg->id ? 'active' : '' }}" data-id="{{ $msg->id }}" onclick="selectMessage({{ $msg->id }})">
                <div style="flex:1;">
                    <div class="msg-item-name">{{ $msg->name }}</div>
                    <div class="msg-item-prev">{{ $msg->subject ?? $msg->email }} – {{ Str::limit($msg->body, 30) }}</div>
                </div>
                <div class="msg-item-time">{{ $msg->created_at->diffForHumans() }}</div>
            </div>
            @endforeach
            @endif
        </div>
        <div class="msg-detail" id="msgDetail">
            @if($messages->isEmpty())
            <div style="text-align:center; padding:40px; color: var(--ink-soft);">Select a message to view it.</div>
            @else
            @php
                $activeMsg = $messages->firstWhere('id', request('active')) ?? $messages->first();
            @endphp
            <div class="msg-detail-head">
                <div>
                    <strong>{{ $activeMsg->name }}</strong>
                    <div style="font-size: 13px; color: var(--ink-soft);">{{ $activeMsg->email }}</div>
                    @if($activeMsg->subject)
                    <div style="font-size: 14px; font-weight: 600; color: var(--coffee-900); margin-top:4px;">{{ $activeMsg->subject }}</div>
                    @endif
                </div>
                <div style="display: flex; gap: 8px;">
                    @if(!$activeMsg->read)
                    <form action="{{ route('admin.messages.read', $activeMsg->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-soft btn-sm">Mark as Read</button>
                    </form>
                    @endif
                    <form action="{{ route('admin.messages.destroy', $activeMsg->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </div>
            </div>
            <div class="msg-detail-body">{{ $activeMsg->body }}</div>
            <div class="msg-detail-foot"></div>
            @endif
        </div>
    </div>
</div>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif

<script>
function selectMessage(id) {
    window.location.href = '{{ route('admin.messages') }}?active=' + id;
}
</script>
@endsection
