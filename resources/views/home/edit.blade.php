<?php
// resources/views/home/edit-home-data.blade.php
?>

@extends('layouts.app')

@section('title', 'Edit Home Data')

@section('content')
    <div class="container">
        <h2 class="mb-4 animate__animated animate__fadeInDown">Edit Home Data</h2>
        @if (session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn" style="animation-delay: 0.2s;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger animate__animated animate__fadeIn" style="animation-delay: 0.2s;">{{ session('error') }}</div>
        @endif
        <form action="{{ route('home.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $homeData->name ?? 'NY Vicheka' }}" required>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                <label for="roles" class="form-label">Roles (comma-separated)</label>
                <input type="text" class="form-control" id="roles" name="roles" value="{{ implode(', ', $homeData->roles ?? ['UI/UX Designer', 'Web Developer', 'Freelancer']) }}" required>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.5s;">
                <label for="bio" class="form-label">Hero Section Bio (Short Introduction)</label>
                <textarea class="form-control" id="bio" name="bio" rows="3">{{ $homeData->bio ?? '' }}</textarea>
                <small class="text-muted">This appears in the hero section below the roles (e.g., "Crafting beautiful and functional web experiences...").</small>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.6s;">
                <label for="cta_text" class="form-label">Call-to-Action Text (Engagement Prompt)</label>
                <textarea class="form-control" id="cta_text" name="cta_text" rows="5">{{ $homeData->cta_text ?? "Ready to Bring Your Vision to Life?" }}</textarea>
                <small class="text-muted">This is the primary text for the Call-to-Action section.</small>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.7s;">
                <label for="cta_bio" class="form-label">Call-to-Action Bio (Optional Extension)</label>
                <textarea class="form-control" id="cta_bio" name="cta_bio" rows="5">{{ $homeData->cta_bio ?? "Let's collaborate to create something extraordinary. Whether you need a stunning website, a brand refresh, or custom digital solutions, I'm here to help." }}</textarea>
                <small class="text-muted">This is an optional extension text for the Call-to-Action section, displayed below the primary text.</small>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.8s;">
                <label class="form-label">Stats</label>
                @foreach ($homeData->stats ?? [] as $index => $stat)
                    <div class="row mb-2 animate__animated animate__fadeInUp" style="animation-delay: {{ 0.9 + $loop->index * 0.1 }}s;">
                        <div class="col">
                            <input type="text" class="form-control" name="stats[{{ $index }}][number]" value="{{ $stat['number'] ?? '' }}" placeholder="Number" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="stats[{{ $index }}][label]" value="{{ $stat['label'] ?? '' }}" placeholder="Label" required>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 0.9s;">
                <label class="form-label">Social Links</label>
                @foreach ($homeData->social_links ?? [] as $index => $social)
                    <div class="row mb-2 animate__animated animate__fadeInUp" style="animation-delay: {{ 1.0 + $loop->index * 0.1 }}s;">
                        <div class="col">
                            <input type="text" class="form-control" name="social_links[{{ $index }}][platform]" value="{{ $social['platform'] ?? '' }}" placeholder="Platform" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="social_links[{{ $index }}][url]" value="{{ $social['url'] ?? '' }}" placeholder="URL" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="social_links[{{ $index }}][color]" value="{{ $social['color'] ?? '' }}" placeholder="Color" required>
                        </div>
                        <div class="col">
                            <textarea class="form-control" name="social_links[{{ $index }}][icon]" rows="2" placeholder="Icon SVG Path" required>{{ $social['icon'] ?? '' }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 1.0s;">
                <label class="form-label">Hero Section Buttons</label>
                <div id="buttons-container">
                    @foreach ($homeData->buttons ?? [] as $index => $button)
                        <div class="row mb-2 button-row animate__animated animate__fadeInUp" style="animation-delay: {{ 1.1 + $loop->index * 0.1 }}s;">
                            <div class="col">
                                <input type="text" class="form-control" name="buttons[{{ $index }}][text]" value="{{ $button['text'] ?? '' }}" placeholder="Button Text" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="buttons[{{ $index }}][link]" value="{{ $button['link'] ?? '' }}" placeholder="Button Link (e.g., /contact)" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remove-button animate__animated animate__bounceIn" style="animation-delay: {{ 1.2 + $loop->index * 0.1 }}s;">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-button" class="btn btn-primary mt-2 animate__animated animate__bounceIn" style="animation-delay: 1.3s; background-color: #17a2b8; border-color: #17a2b8;">Add New Button</button>
            </div>
            <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 1.1s;">
                <label class="form-label">Call-to-Action Buttons</label>
                <div id="cta-buttons-container">
                    @foreach ($homeData->cta_buttons ?? [] as $index => $button)
                        <div class="row mb-2 cta-button-row animate__animated animate__fadeInUp" style="animation-delay: {{ 1.2 + $loop->index * 0.1 }}s;">
                            <div class="col">
                                <input type="text" class="form-control" name="cta_buttons[{{ $index }}][text]" value="{{ $button['text'] ?? '' }}" placeholder="Button Text" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="cta_buttons[{{ $index }}][link]" value="{{ $button['link'] ?? '' }}" placeholder="Button Link (e.g., /contact)" required>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger remove-cta-button animate__animated animate__bounceIn" style="animation-delay: {{ 1.3 + $loop->index * 0.1 }}s;">Remove</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-cta-button" class="btn btn-primary mt-2 animate__animated animate__bounceIn" style="animation-delay: 1.4s; background-color: #17a2b8; border-color: #17a2b8;">Add New CTA Button</button>
            </div>
            <button type="submit" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 1.5s; background-color: #28a745; border-color: #28a745;">Update</button>
            <a href="{{ route('home.index') }}" class="btn btn-secondary animate__animated animate__bounceIn" style="animation-delay: 1.6s;">Cancel</a>
        </form>
    </div>

    <script>
        // Hero Section Buttons
        document.getElementById('add-button').addEventListener('click', function () {
            const container = document.getElementById('buttons-container');
            const index = container.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 button-row animate__animated animate__fadeInUp';
            newRow.style.animationDelay = (1.1 + index * 0.1) + 's';
            newRow.innerHTML = `
                <div class="col">
                    <input type="text" class="form-control" name="buttons[${index}][text]" placeholder="Button Text" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="buttons[${index}][link]" placeholder="Button Link (e.g., /contact)" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-button animate__animated animate__bounceIn" style="animation-delay: ${(1.2 + index * 0.1)}s;">Remove</button>
                </div>
            `;
            container.appendChild(newRow);
            attachRemoveEvent(newRow.querySelector('.remove-button'), 'button-row', 'buttons');
        });

        function attachRemoveEvent(button, rowClass, inputPrefix) {
            button.addEventListener('click', function () {
                this.closest('.' + rowClass).remove();
                const rows = document.querySelectorAll(`#${rowClass}-container .${rowClass}`);
                rows.forEach((row, idx) => {
                    const textInput = row.querySelector('input[name$="[text]"]');
                    const linkInput = row.querySelector('input[name$="[link]"]');
                    textInput.name = `${inputPrefix}[${idx}][text]`;
                    linkInput.name = `${inputPrefix}[${idx}][link]`;
                });
            });
        }

        document.querySelectorAll('.remove-button').forEach(button => attachRemoveEvent(button, 'button-row', 'buttons'));

        // Call-to-Action Buttons
        document.getElementById('add-cta-button').addEventListener('click', function () {
            const container = document.getElementById('cta-buttons-container');
            const index = container.children.length;
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 cta-button-row animate__animated animate__fadeInUp';
            newRow.style.animationDelay = (1.2 + index * 0.1) + 's';
            newRow.innerHTML = `
                <div class="col">
                    <input type="text" class="form-control" name="cta_buttons[${index}][text]" placeholder="Button Text" required>
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="cta_buttons[${index}][link]" placeholder="Button Link (e.g., /contact)" required>
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-cta-button animate__animated animate__bounceIn" style="animation-delay: ${(1.3 + index * 0.1)}s;">Remove</button>
                </div>
            `;
            container.appendChild(newRow);
            attachRemoveEvent(newRow.querySelector('.remove-cta-button'), 'cta-button-row', 'cta_buttons');
        });

        document.querySelectorAll('.remove-cta-button').forEach(button => attachRemoveEvent(button, 'cta-button-row', 'cta_buttons'));
    </script>
@endsection