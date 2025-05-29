@extends('layouts.app')

@section('title', 'Manage Tutorials')

@section('content')
    <div class="container">
        <h2 class="mb-4 animate__animated animate__fadeInDown">Manage Tutorials</h2>

        <!-- Search Form -->
        <div class="mb-4 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
            <form action="{{ route('tutorials.index') }}" method="GET" class="row g-3">
                <div class="col-auto">
                    <input type="text" name="title" class="form-control" placeholder="Search by Title" value="{{ request('title') }}">
                </div>
                <div class="col-auto">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 0.3s;">Search</button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('tutorials.index') }}" class="btn btn-secondary animate__animated animate__bounceIn" style="animation-delay: 0.4s;">Clear</a>
                </div>
            </form>
        </div>

        <a href="{{ route('tutorials.create') }}" class="btn btn-primary mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.5s;">Add New Tutorial</a>

        <table class="table table-striped">
            <thead>
                <tr class="animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                    <th>Title</th>
                    <th>Description</th>
                    <th>Link</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tutorials as $tutorial)
                    <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ 0.7 + $loop->index * 0.1 }}s;">
                        <td>{{ $tutorial->title }}</td>
                        <td>{{ Str::limit($tutorial->description, 50) }}</td>
                        <td>
                            @if ($tutorial->link)
                                <a href="{{ $tutorial->link }}" target="_blank">{{ Str::limit($tutorial->link, 30) }}</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $tutorial->category ? $tutorial->category->name : 'N/A' }}</td>
                        <td>
                            @if ($tutorial->image)
                                <img src="{{ asset('storage/' . $tutorial->image) }}" alt="{{ $tutorial->title }}" style="max-width: 50px; max-height: 50px;" class="animate__animated animate__fadeIn" style="animation-delay: {{ 0.8 + $loop->index * 0.1 }}s;">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('tutorials.edit', $tutorial->id) }}" class="btn btn-sm btn-warning animate__animated animate__bounceIn" style="animation-delay: {{ 0.9 + $loop->index * 0.1 }}s;">Edit</a>
                            <form action="{{ route('tutorials.destroy', $tutorial->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger animate__animated animate__bounceIn" style="animation-delay: {{ 1.0 + $loop->index * 0.1 }}s;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr class="animate__animated animate__fadeIn" style="animation-delay: 0.7s;">
                        <td colspan="6" class="text-center text-muted">No tutorials found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection