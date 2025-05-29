@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
    <h1 class="mb-4">Add New Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
            @error('slug')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection