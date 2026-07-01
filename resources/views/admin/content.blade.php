@extends('admin.layout')

@section('title', 'Content Management')

@section('content')
    <h1 class="text-3xl font-bold mb-8" style="font-family: 'Playfair Display', serif; color: #854208;">Content Management</h1>

    <form action="{{ route('admin.content.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- General Group -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold mb-4" style="color: #854208;">General Settings</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($contents->where('group', 'general') as $content)
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">{{ $content->label }}</label>
                        @if($content->type === 'image')
                            <div class="space-y-2">
                                @if($content->value)
                                    <img src="{{ $content->value }}" alt="{{ $content->label }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                @endif
                                <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Image URL">
                            </div>
                        @elseif($content->type === 'html')
                            <textarea name="content[{{ $content->key }}]" rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="{{ $content->label }}">{{ old('content.' . $content->key, $content->value) }}</textarea>
                        @else
                            <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="{{ $content->label }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Home Group -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold mb-4" style="color: #854208;">Home Page</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($contents->where('group', 'home') as $content)
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">{{ $content->label }}</label>
                        @if($content->type === 'image')
                            <div class="space-y-2">
                                @if($content->value)
                                    <img src="{{ $content->value }}" alt="{{ $content->label }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                @endif
                                <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Image URL">
                            </div>
                        @elseif($content->type === 'html')
                            <textarea name="content[{{ $content->key }}]" rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="{{ $content->label }}">{{ old('content.' . $content->key, $content->value) }}</textarea>
                        @else
                            <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="{{ $content->label }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- About Group -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-bold mb-4" style="color: #854208;">About Page</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($contents->where('group', 'about') as $content)
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-gray-700">{{ $content->label }}</label>
                        @if($content->type === 'image')
                            <div class="space-y-2">
                                @if($content->value)
                                    <img src="{{ $content->value }}" alt="{{ $content->label }}" class="w-32 h-32 object-cover rounded-lg border border-gray-200">
                                @endif
                                <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Image URL">
                            </div>
                        @elseif($content->type === 'html')
                            <textarea name="content[{{ $content->key }}]" rows="4" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="{{ $content->label }}">{{ old('content.' . $content->key, $content->value) }}</textarea>
                        @else
                            <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="{{ $content->label }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-full text-white font-semibold transition-all hover:opacity-90" style="background-color: #088529;">
            Save All Changes
        </button>
    </form>
@endsection
