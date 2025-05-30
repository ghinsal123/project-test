@extends('layouts.app')

@section('title', 'Buat Ticket Baru')

@section('content')
<h1>Buat Ticket Baru</h1>

<form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Title -->
    <div class="mb-3">
        <label for="title" class="form-label">Judul Ticket</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        @error('title')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description') }}</textarea>
        @error('description')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Labels (Checkbox) -->
    <div class="mb-3">
        <label class="form-label">Label</label><br>
        @php
            $labels = ['bug', 'question', 'enhancement'];
        @endphp
        @foreach ($labels as $label)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="labels[]" value="{{ $label }}" id="label_{{ $label }}" class="form-check-input"
                {{ is_array(old('labels')) && in_array($label, old('labels')) ? 'checked' : '' }}>
                <label class="form-check-label" for="label_{{ $label }}">{{ ucfirst($label) }}</label>
            </div>
        @endforeach
        @error('labels')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Categories (Checkbox) -->
    <div class="mb-3">
        <label class="form-label">Categories</label><br>
        @php
            $categories = ['uncategorized', 'billing/payments', 'technical question'];
        @endphp
        @foreach ($categories as $category)
            <div class="form-check form-check-inline">
                <input type="checkbox" name="categories[]" value="{{ $category }}" id="category_{{ str_replace(' ', '_', $category) }}" class="form-check-input"
                {{ is_array(old('categories')) && in_array($category, old('categories')) ? 'checked' : '' }}>
                <label class="form-check-label" for="category_{{ str_replace(' ', '_', $category) }}">{{ ucfirst($category) }}</label>
            </div>
        @endforeach
        @error('categories')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Priority (Radio Button) -->
    <div class="mb-3">
        <label class="form-label">Priority</label><br>
        @php
            $priorities = ['low', 'medium', 'high'];
        @endphp
        @foreach ($priorities as $priority)
            <div class="form-check form-check-inline">
                <input type="radio" name="priority" value="{{ $priority }}" id="priority_{{ $priority }}" class="form-check-input"
                {{ old('priority') == $priority ? 'checked' : '' }} required>
                <label class="form-check-label" for="priority_{{ $priority }}">{{ ucfirst($priority) }}</label>
            </div>
        @endforeach
        @error('priority')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Attachment -->
    <div class="mb-3">
        <label for="attachment" class="form-label">Attachment</label>
        <input type="file" name="attachment" id="attachment" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
        @error('attachment')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary">Submit Ticket</button>
</form>
@endsection
