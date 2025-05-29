@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="container">
        <h1 class="mb-4 animate__animated animate__fadeInDown">Manage Categories</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message (if any) -->
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-4 animate__animated animate__bounceIn" style="animation-delay: 0.4s;">Add New Category</a>

        <table class="table table-bordered animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ 0.6 + $loop->index * 0.1 }}s;">
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 0.7 + $loop->index * 0.1 }}s;">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 0.8 + $loop->index * 0.1 }}s;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                        <td colspan="3" class="text-center">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection