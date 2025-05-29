@extends('layouts.app')

@section('title', 'Edit Logo')

@section('content')
    <div class="container">
        <h1>Edit Logo</h1>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('logo.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="logo" class="form-label">Upload New Logo</label>
                <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            @if ($logo && $logo->image_data)
                <div class="mb-3">
                    <label class="form-label">Current Logo</label>
                    <div>
                        <img src="{{ $logo->image_data }}" alt="Current Logo" style="max-width: 200px; height: auto;">
                    </div>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">Update Logo</button>
            <a href="{{ route('logo.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection