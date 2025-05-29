@extends('layouts.app')

@section('title', 'Edit Support Us Section')

@section('content')
<div class="container">
    <h2 class="mb-4 animate__animated animate__fadeInDown">Edit Support Us Section</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-4 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="min-height: calc(100vh - 200px); padding-bottom: 100px;">
        <form action="{{ route('support-us.update', $section->id) }}" method="POST" id="support-us-form">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="section" class="form-label">Section Name</label>
                <input type="text" name="section" id="section" class="form-control" value="{{ old('section', $section->section) }}" required>
            </div>
            <div class="mb-4">
                <label for="parent_section" class="form-label">Parent Section (Optional)</label>
                <select name="parent_section" id="parent_section" class="form-control">
                    <option value="" {{ old('parent_section', $section->parent_section) === '' ? 'selected' : '' }}>None (Top-level Section)</option>
                    @foreach ($sections as $parent)
                        <option value="{{ $parent }}" {{ old('parent_section', $section->parent_section) === $parent ? 'selected' : '' }}>{{ $parent }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $section->title) }}">
            </div>
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control">{{ old('description', $section->description) }}</textarea>
            </div>
            <div class="mb-4">
                <label for="icon" class="form-label">Icon (e.g., 'fas fa-coffee' for Font Awesome)</label>
                <div id="style2-icon-message" class="alert alert-info mb-2" style="display: none;">
                    Note: Style 2 (List) does not support adding icons.
                </div>
                <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $section->icon ?? '') }}">
            </div>
            <div class="mb-4">
                <label for="style" class="form-label">Style (Required)</label>
                <select name="style" id="style" class="form-control" required>
                    <option value="" {{ old('style', $section->style) === '' ? 'selected' : '' }} disabled>Select a style</option>
                    <option value="style1" {{ old('style', $section->style) === 'style1' ? 'selected' : '' }}>Style 1 (Grid)</option>
                    <option value="style2" {{ old('style', $section->style) === 'style2' ? 'selected' : '' }}>Style 2 (List)</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label">Buttons</label>
                <div id="style2-message" class="alert alert-info mb-2" style="display: none;">
                    Note: Style 2 (List) does not support adding buttons.
                </div>
                <div id="buttons-container">
                    @foreach ($section->buttons ?? [] as $index => $button)
                        <div class="mb-2 button-group">
                            <div class="row align-items-center">
                                <div class="col">
                                    <input type="text" name="buttons[{{ $index }}][text]" placeholder="Button Text" class="form-control" value="{{ $button['text'] ?? '' }}">
                                </div>
                                <div class="col">
                                    <input type="text" name="buttons[{{ $index }}][url]" placeholder="Button URL or Path (e.g., /Contact or https://example.com)" class="form-control" value="{{ $button['url'] ?? '' }}">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger remove-button" {{ $index === 0 ? 'disabled' : '' }}>Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-2" id="button-actions">
                    <button type="button" id="add-button" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 0.3s;">Add Another Button</button>
                    <button type="button" id="cancel-button" class="btn btn-secondary animate__animated animate__bounceIn" style="animation-delay: 0.4s;">Cancel</button>
                </div>
            </div>
            <div class="mb-4">
                <label for="order" class="form-label">Order</label>
                <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $section->order) }}" required>
            </div>
            <button type="submit" class="btn btn-primary animate__animated animate__bounceIn" style="animation-delay: 0.5s;">Update</button>
        </form>
    </div>
</div>

<script>
    // Function to toggle visibility of the "Add Another Button" button, style2 messages, and icon field
    function toggleAddButtonVisibility() {
        const styleSelect = document.getElementById('style');
        const addButton = document.getElementById('add-button');
        const cancelButton = document.getElementById('cancel-button');
        const style2Message = document.getElementById('style2-message');
        const style2IconMessage = document.getElementById('style2-icon-message');
        const iconInput = document.getElementById('icon');

        if (styleSelect.value === 'style1') {
            addButton.style.display = 'inline-block';
            cancelButton.style.display = 'inline-block';
            style2Message.style.display = 'none';
            style2IconMessage.style.display = 'none';
            iconInput.disabled = false;
            iconInput.classList.remove('bg-gray-200');
        } else if (styleSelect.value === 'style2') {
            addButton.style.display = 'none';
            cancelButton.style.display = 'inline-block';
            style2Message.style.display = 'block';
            style2IconMessage.style.display = 'block';
            iconInput.disabled = true;
            iconInput.classList.add('bg-gray-200');
            iconInput.value = ''; // Clear the icon field
        } else {
            addButton.style.display = 'none';
            cancelButton.style.display = 'inline-block';
            style2Message.style.display = 'none';
            style2IconMessage.style.display = 'none';
            iconInput.disabled = false;
            iconInput.classList.remove('bg-gray-200');
        }
    }

    // Add button functionality
    document.getElementById('add-button').addEventListener('click', () => {
        const container = document.getElementById('buttons-container');
        const index = container.children.length;
        const newButtonGroup = document.createElement('div');
        newButtonGroup.className = 'mb-2 button-group';
        newButtonGroup.innerHTML = `
            <div class="row align-items-center">
                <div class="col">
                    <input type="text" name="buttons[${index}][text]" placeholder="Button Text" class="form-control">
                </div>
                <div class="col">
                    <input type="text" name="buttons[${index}][url]" placeholder="Button URL or Path (e.g., /Contact or https://example.com)" class="form-control">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-danger remove-button">Remove</button>
                </div>
            </div>
        `;
        container.appendChild(newButtonGroup);
        updateRemoveButtons();
    });

    // Remove button functionality
    document.addEventListener('click', (event) => {
        if (event.target.classList.contains('remove-button')) {
            const buttonGroup = event.target.closest('.button-group');
            if (buttonGroup) {
                buttonGroup.remove();
                updateRemoveButtons();
            }
        }
    });

    // Cancel button functionality
    document.getElementById('cancel-button').addEventListener('click', () => {
        const container = document.getElementById('buttons-container');
        container.innerHTML = '';
        updateRemoveButtons();
    });

    // Update remove buttons state
    function updateRemoveButtons() {
        const container = document.getElementById('buttons-container');
        const removeButtons = container.querySelectorAll('.remove-button');
        removeButtons.forEach((button, index) => {
            button.disabled = index === 0;
        });
    }

    // Run on page load
    document.addEventListener('DOMContentLoaded', () => {
        updateRemoveButtons();
        toggleAddButtonVisibility(); // Initial toggle based on loaded style
    });

    // Add event listener for style change
    document.getElementById('style').addEventListener('change', toggleAddButtonVisibility);
</script>

<style>
body {
    margin-bottom: 100px;
}

footer {
    position: relative;
    width: 100%;
    bottom: 0;
    padding: 20px 0;
}

.bg-gray-200 {
    background-color: #e5e7eb; /* Tailwind's bg-gray-200 color */
}
</style>

@endsection