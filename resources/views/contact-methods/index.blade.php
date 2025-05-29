@extends('layouts.app')

@section('title', 'Manage Contact Methods')

@section('content')
    <h2 class="mb-4 animate__animated animate__fadeInDown">Manage Contact Methods</h2>

    <a href="{{ route('contact-methods.create') }}" class="btn btn-primary mb-3 animate__animated animate__bounceIn">Add New Contact Method</a>

    <table class="table table-striped">
        <thead>
            <tr class="animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                <th>Title</th>
                <th>Icon</th>
                <th>URL</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contactMethods as $method)
                <tr class="animate__animated animate__fadeInUp" style="animation-delay: {{ 0.3 + $loop->index * 0.1 }}s;">
                    <td>{{ $method->title }}</td>
                    <td>{{ $method->icon ?? 'N/A' }}</td>
                    <td>
                        @if ($method->url)
                            <a href="{{ $method->url }}" @if(preg_match('/^tel:/', $method->url)) {{ '' }} @else target="_blank" @endif>{{ $method->url }}</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $method->type }}</td>
                    <td>
                        <a href="{{ route('contact-methods.edit', $method->id) }}" class="btn btn-sm btn-warning animate__animated animate__bounceIn" style="animation-delay: {{ 0.5 + $loop->index * 0.1 }}s;">Edit</a>
                        <form action="{{ route('contact-methods.destroy', $method->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger animate__animated animate__bounceIn" style="animation-delay: {{ 0.6 + $loop->index * 0.1 }}s;">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection