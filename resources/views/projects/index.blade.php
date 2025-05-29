@extends('layouts.app')

@section('title', 'Manage Projects')

@section('content')
<div class="container">
    <h2 class="mb-4 animate__animated animate__fadeInDown">Manage Projects</h2>
    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-3 animate__animated animate__bounceIn">Add New Project</a>

    <table class="table table-striped">
        <thead>
            <tr class="animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                <th>Title</th>
                <th>Image</th>
                <th>Link</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ 0.3 + $loop->index * 0.1 }}s;">
                    <td>{{ $project->title }}</td>
                    <td>
                        @if ($project->image)
                            <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" width="100" class="animate__animated animate__fadeIn" style="animation-delay: {{ 0.4 + $loop->index * 0.1 }}s;">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>
                        @if ($project->link)
                            {{ $project->link }}
                        @else
                            No Link
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 0.5 + $loop->index * 0.1 }}s;">Edit</a>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 0.6 + $loop->index * 0.1 }}s;" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection