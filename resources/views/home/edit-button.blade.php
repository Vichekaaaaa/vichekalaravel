<?php
// resources/views/home/edit-button.blade.php
?>

@extends('layouts.app')

@section('title', 'Edit Button')

@section('content')
    <div class="container">
        <h2 class="mb-4 animate__animated animate__fadeInDown">Edit Button</h2>
        <form action="{{ route('home.update.button', ['index' => $index]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <label for="text" class="form-label">Button Text</label>
                <input type="text" class="form-control" id="text" name="text" value="{{ $button['text'] }}" required>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <label for="link" class="form-label">Button Link</label>
                <input type="text" class="form-control" id="link" name="link" value="{{ $button['link'] }}" required>
            </div>
            <button type="submit" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 0.5s;">Update Button</button>
            <a href="{{ route('home.index') }}" class="btn btn-secondary animate__animated animate__bounceIn" style="animation-delay: 0.6s;">Cancel</a>
        </form>
    </div>
@endsection