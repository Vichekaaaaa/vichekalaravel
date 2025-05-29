@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-2xl font-bold animate__animated animate__fadeInDown">Home Data</h2>
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeIn" style="animation-delay: 0.2s;">{{ session('error') }}</div>
        @endif
        
        <!-- Personal Information Card -->
        <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <div class="card-body">
                <h5 class="card-title text-lg font-semibold mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.4s;">Personal Information</h5>
                <p><strong>Name:</strong> {{ $homeData->name ?? 'Not set' }}</p>
                <p><strong>Roles:</strong> {{ !empty($homeData->roles) ? implode(', ', $homeData->roles) : 'Not set' }}</p>
                <p><strong>Bio:</strong> {{ $homeData->bio ?? 'No bio available' }}</p>
            </div>
        </div>

        <!-- Call-to-Action Card with different styling -->
        <div class="card shadow-sm mb-4 border-2 border-blue-200 bg-blue-50 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
            <div class="card-body">
                <h5 class="card-title text-lg font-semibold mb-3 text-blue-700 animate__animated animate__fadeIn" style="animation-delay: 0.5s;">Call-to-Action Section</h5>
                <div class="bg-white p-4 rounded-lg mb-3 animate__animated animate__fadeIn" style="animation-delay: 0.6s;">
                    <p><strong>Call-to-Action Text:</strong></p>
                    <p class="text-lg italic">"{{ $homeData->cta_text ?? 'No Call-to-Action text available' }}"</p>
                </div>
                <div class="bg-white p-4 rounded-lg animate__animated animate__fadeIn" style="animation-delay: 0.7s;">
                    <p><strong>Call-to-Action Bio:</strong></p>
                    <p>{{ $homeData->cta_bio ?? 'No Call-to-Action bio available' }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
            <div class="card-body">
                <h6 class="text-md font-medium animate__animated animate__fadeIn" style="animation-delay: 0.6s;">Statistics</h6>
                <ul class="list-group mt-2">
                    @forelse ($homeData->stats ?? [] as $stat)
                        <li class="list-group-item animate__animated animate__fadeInUp" style="animation-delay: {{ 0.7 + $loop->index * 0.1 }}s;">{{ $stat['number'] ?? 0 }} - {{ $stat['label'] ?? 'No label' }}</li>
                    @empty
                        <li class="list-group-item animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">No statistics available.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Social Links Card -->
        <div class="card shadow-sm mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
            <div class="card-body">
                <h6 class="text-md font-medium animate__animated animate__fadeIn" style="animation-delay: 0.7s;">Social Links</h6>
                <ul class="list-group mt-2">
                    @forelse ($homeData->social_links ?? [] as $social)
                        <li class="list-group-item animate__animated animate__fadeInUp" style="animation-delay: {{ 0.8 + $loop->index * 0.1 }}s;">
                            <strong>{{ $social['platform'] ?? 'Unknown' }}:</strong>
                            <a href="{{ $social['url'] ?? '#' }}" target="_blank" class="ms-2 text-blue-600 hover:underline">
                                {{ $social['url'] ?? 'Not set' }}
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">No social links available.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- Buttons Sections -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <!-- Hero Buttons Card -->
            <div class="card shadow-sm animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
                <div class="card-body">
                    <h6 class="text-md font-medium animate__animated animate__fadeIn" style="animation-delay: 0.8s;">Hero Section Buttons</h6>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @if (!empty($homeData->buttons) && is_iterable($homeData->buttons))
                            @foreach ($homeData->buttons as $index => $button)
                                <a href="{{ route('home.edit.button', ['index' => $index]) }}" class="btn btn-primary btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 0.9 + $loop->index * 0.1 }}s;">
                                    {{ $button['text'] ?? 'Unnamed Button' }}
                                </a>
                            @endforeach
                        @else
                            <p class="text-muted animate__animated animate__fadeIn" style="animation-delay: 0.9s;">No hero section buttons available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CTA Buttons Card -->
            <div class="card shadow-sm animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
                <div class="card-body">
                    <h6 class="text-md font-medium animate__animated animate__fadeIn" style="animation-delay: 0.9s;">Call-to-Action Buttons</h6>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @if (!empty($homeData->cta_buttons) && is_iterable($homeData->cta_buttons))
                            @foreach ($homeData->cta_buttons as $index => $button)
                                <a href="{{ route('home.edit.cta.button', ['index' => $index]) }}" class="btn btn-primary btn-sm animate__animated animate__bounceIn" style="animation-delay: {{ 1.0 + $loop->index * 0.1 }}s;">
                                    {{ $button['text'] ?? 'Unnamed CTA Button' }}
                                </a>
                            @endforeach
                        @else
                            <p class="text-muted animate__animated animate__fadeIn" style="animation-delay: 1.0s;">No CTA buttons available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('home.edit') }}" class="btn btn-warning mt-4 animate__animated animate__bounceIn" style="animation-delay: 0.9s;">Edit Home Data</a>
    </div>
@endsection