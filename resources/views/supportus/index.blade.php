@extends('layouts.app')

@section('title', 'Manage Support Us')

@section('content')
<div class="container">
    <h2 class="mb-4 animate__animated animate__fadeInDown">Manage Support Us Sections</h2>
    <a href="{{ route('support-us.create') }}" class="btn btn-primary mb-3 animate__animated animate__bounceIn">Create New Section</a>

    <div class="table-responsive" style="max-height: calc(100vh - 200px); overflow-y: auto; overflow-x: auto; padding-bottom: 100px;">
        <table class="table table-striped table-hover">
            <thead class="thead-dark" style="position: sticky; top: 0; z-index: 1;">
                <tr class="animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                    <th>Section</th>
                    <th>Parent Section</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Icon</th>
                    <th>Buttons</th>
                    <th>Order</th>
                    <th>Style</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supportUs as $section)
                    <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ 0.3 + $loop->index * 0.1 }}s;">
                        <td>{{ $section->section }}</td>
                        <td>{{ $section->parent_section ?? 'None' }}</td>
                        <td>{{ $section->title }}</td>
                        <td>{{ Str::limit($section->description, 50) }}</td>
                        <td>{{ $section->icon ?? 'None' }}</td>
                        <td>
                            @php
                                $buttons = $section->buttons;
                                if (is_string($buttons)) {
                                    $buttons = json_decode($buttons, true) ?: [];
                                } elseif (!is_array($buttons)) {
                                    $buttons = [];
                                }
                            @endphp
                            @if (!empty($buttons))
                                @foreach ($buttons as $button)
                                    <div class="animate__animated animate__fadeIn" style="animation-delay: {{ 0.4 + $loop->parent->index * 0.1 }}s;">
                                        {{ $button['text'] ?? 'N/A' }}: {{ Str::limit($button['url'] ?? '', 30) }}
                                    </div>
                                @endforeach
                            @else
                                None
                            @endif
                        </td>
                        <td>{{ $section->order }}</td>
                        <td>{{ $section->style ?? 'None' }}</td>
                        <td>
                            <a href="{{ route('support-us.edit', $section->id) }}" class="btn btn-warning btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 0.5 + $loop->index * 0.1 }}s;">Edit</a>
                            <form action="{{ route('support-us.destroy', $section->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm animate__animated animate__fadeIn" style="animation-delay: {{ 0.6 + $loop->index * 0.1 }}s;" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
.table-responsive table {
    width: 100%;
    min-width: 1000px;
}

.table th, .table td {
    vertical-align: middle;
}

.thead-dark {
    background-color: #343a40;
    color: white;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}

body {
    margin-bottom: 100px;
}

footer {
    position: relative;
    width: 100%;
    bottom: 0;
    padding: 20px 0;
}
</style>

@endsection