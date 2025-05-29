@extends('layouts.app')

@section('title', 'Edit Contact Method')

@section('content')
    <h2 class="mb-4">Edit Contact Method</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact-methods.update', $contactMethod->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $contactMethod->title }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="icon" class="form-label">Icon (e.g., fa-phone, fa-telegram, fa-whatsapp)</label>
            <input type="text" name="icon" id="icon" class="form-control @error('icon') is-invalid @enderror" value="{{ $contactMethod->icon ?? '' }}">
            @error('icon')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="url" class="form-label">URL (e.g., https://example.com, tel:+1234567890)</label>
            <input type="text" name="url" id="url" class="form-control @error('url') is-invalid @enderror" value="{{ $contactMethod->url ?? '' }}" required>
            @error('url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="phone" {{ $contactMethod->type === 'phone' ? 'selected' : '' }}>Phone</option>
                <option value="social" {{ $contactMethod->type === 'social' ? 'selected' : '' }}>Social</option>
                <option value="email" {{ $contactMethod->type === 'email' ? 'selected' : '' }}>Email</option>
            </select>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('contact-methods.index') }}" class="btn btn-secondary">Back</a>
    </form>

    @push('scripts')
        <script>
            const typeSelect = document.getElementById('type');
            const urlInput = document.getElementById('url');

            function updateFormFields() {
                if (typeSelect.value === 'phone') {
                    // No specific validation for phone; url is required for all types
                } else {
                    // No changes needed for other types
                }
            }

            // Update fields when type changes
            typeSelect.addEventListener('change', updateFormFields);

            // Trigger initial update on page load to handle existing values
            updateFormFields();
        </script>
    @endpush
@endsection