@extends('layouts.app')

@section('title', 'Manage Logo')

@section('content')
    <div class="container">
        <h1 class="mb-4 animate__animated animate__fadeInDown">Manage Logo</h1>
        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                {{ session('error') }}
            </div>
        @endif

        <div class="card animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
            <div class="card-header">
                Current Logo
            </div>
            <div class="card-body">
                @if ($logo && $logo->image_data)
                    <img src="{{ $logo->image_data }}" alt="Website Logo" style="max-width: 200px; height: auto;" class="animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                @else
                    <p class="animate__animated animate__fadeIn" style="animation-delay: 0.5s;">No logo uploaded yet.</p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('logo.edit') }}" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 0.6s;">Edit Logo</a>
            </div>
        </div>
    </div>
@endsection