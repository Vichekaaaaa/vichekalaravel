@extends('layouts.app')

@section('title', 'Add Tutorial')

@section('content')
    <style>
        /* Ensure the form is scrollable on small screens */
        .form-container {
            max-height: calc(100vh - 150px); /* Adjust height based on viewport, minus header/footer */
            overflow-y: auto; /* Enable vertical scrolling */
            padding: 15px;
            box-sizing: border-box;
        }

        /* Ensure form elements are responsive */
        .form-control, .form-select {
            width: 100%;
            box-sizing: border-box;
        }

        /* Adjust textarea for smaller screens */
        textarea.form-control {
            min-height: 150px;
            max-height: 300px;
            resize: vertical; /* Allow vertical resize only */
        }

        /* Formatting tips box */
        .formatting-tips {
            font-size: 0.9rem;
            max-height: 150px;
            overflow-y: auto;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            .form-container {
                padding: 10px;
            }

            h1.mb-4 {
                font-size: 1.5rem; /* Smaller heading on mobile */
            }

            .formatting-tips {
                font-size: 0.8rem;
            }

            .btn-primary {
                width: 100%; /* Full-width button on small screens */
            }
        }
    </style>

    <div class="form-container">
        <h1 class="mb-4">Add New Tutorial</h1>
        <form action="{{ route('tutorials.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <!-- Formatting Reminder Note -->
                 <div class="mb-2 p-3 bg-gray-100 border rounded">
                <strong>Formatting Tips:</strong><br />
                - Use <code>&lt;b&gt;</code> for <b>bold</b> text.<br />
                - Use <code>&lt;i&gt;</code> for <i>italic</i> text.<br />
                - Use <code>&lt;u&gt;</code> for <u>underlined</u> text.<br />
                - Use <code>&lt;span style="font-size: 20px;"&gt;</code> for larger text (e.g., <span style="font-size: 20px;">bigger text</span>).<br />
                - Use <code>&lt;br /&gt;</code> for a line break.<br />
                - Use <code>&lt;i class="fas fa-phone"&gt;&lt;/i&gt;</code> for icons (e.g., <i class="fas fa-phone"></i>).
            </div>
                <!-- Larger textarea for description -->
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="10"></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="url" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}">
                @error('link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    <!-- Include Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Include TinyMCE -->
    @push('scripts')
        <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: '#description',
                height: 400,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                menubar: false,
                setup: function (editor) {
                    editor.on('change', function () {
                        editor.save(); // Sync TinyMCE content with the textarea
                    });
                }
            });
        </script>
    @endpush
@endsection