@extends('admin.layout')

@section('title', 'Site Content')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Site Content</h2>
            <p class="sub">Edit the copy and assets shown across the public pages.</p>
        </div>
        <div class="view-actions">
            <button type="submit" form="contentForm" class="btn btn-primary">Save all changes</button>
        </div>
    </div>

    <form id="contentForm" action="{{ route('admin.content.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="settings-grid settings-grid-single">
            <div class="settings-panel">
                @foreach($contentGroups as $group => $label)
                    @php $items = $contents->where('group', $group); @endphp
                    @if($items->isNotEmpty())
                        <div class="settings-section">
                            <h4>{{ $label }}</h4>
                        </div>
                        <div class="form-row">
                            @foreach($items as $content)
                                <div class="field">
                                    <label>{{ $content->label ?? ucwords(str_replace('_', ' ', $content->key)) }}</label>
                                    @if($content->type === 'textarea')
                                        <textarea name="content[{{ $content->key }}]" rows="3">{{ old('content.' . $content->key, $content->value) }}</textarea>
                                    @elseif($content->type === 'html')
                                        <textarea name="content[{{ $content->key }}]" rows="6" class="mono">{{ old('content.' . $content->key, $content->value) }}</textarea>
                                    @elseif($content->type === 'image')
                                        <div class="image-field">
                                            @if($content->value)
                                                <img src="{{ $content->value }}" alt="{{ $content->label }}" style="width:88px;height:88px;object-fit:cover;border-radius:10px;border:1px solid var(--line);margin-bottom:10px;">
                                            @endif
                                            <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" placeholder="Image URL">
                                        </div>
                                    @elseif($content->type === 'email')
                                        <input type="email" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}">
                                    @elseif($content->type === 'select')
                                        <select name="content[{{ $content->key }}]">
                                            @if($content->key === 'default_currency')
                                                <option {{ $content->value === 'USD ($)' ? 'selected' : '' }}>USD ($)</option>
                                                <option {{ $content->value === 'TZS (TSh)' ? 'selected' : '' }}>TZS (TSh)</option>
                                                <option {{ $content->value === 'EUR (€)' ? 'selected' : '' }}>EUR (€)</option>
                                            @elseif($content->key === 'timezone')
                                                <option {{ $content->value === 'Africa/Dar es Salaam (EAT)' ? 'selected' : '' }}>Africa/Dar es Salaam (EAT)</option>
                                                <option {{ $content->value === 'UTC' ? 'selected' : '' }}>UTC</option>
                                            @endif
                                        </select>
                                    @else
                                        <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach

                <div class="view-head" style="margin-top:28px;">
                    <button type="submit" class="btn btn-primary">Save all changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection