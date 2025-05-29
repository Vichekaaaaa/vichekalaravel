<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @section('title', 'Manage About')
    <style>
        .about-container {
            background: linear-gradient(135deg, #f4f6f9 0%, #e9ecef 100%);
            min-height: calc(100vh - 140px); /* Adjust for header and footer */
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        .about-card {
            background: white;
            border: none;
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .about-image {
            transition: transform 0.3s ease;
        }
        .about-image:hover {
            transform: scale(1.05);
        }
        .btn-primary, .btn-danger, .btn-success {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover, .btn-danger:hover, .btn-success:hover {
            transform: translateY(-2px);
        }
        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
            background: transparent;
        }
        .list-group-item i {
            color: #007bff;
            margin-right: 0.5rem;
        }
        .section-title {
            color: #1a1f2e;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .category-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1a1f2e;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <div class="container about-container animate__animated animate__fadeIn">
            <h1 class="text-3xl font-bold mb-6 animate__animated animate__fadeInDown">Manage About</h1>

            @if ($about)
                <div class="card about-card shadow-sm mb-6 animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <h2 class="section-title text-2xl font-semibold mb-4">Bio</h2>
                        <p class="text-gray-700 mb-4">{{ $about->bio ?? 'No bio available.' }}</p>

                        <h2 class="section-title text-2xl font-semibold mb-4">Skills</h2>
                        @php
                            // Categorize skills to match the frontend display
                            $categorizedSkills = [
                                'Front-End Development' => [],
                                'Back-End Development' => [],
                                'Tools & Others' => [],
                            ];
                            if (is_array($about->skills)) {
                                foreach ($about->skills as $skill) {
                                    if (in_array($skill, ['React', 'JavaScript (ES6+)', 'HTML5', 'CSS3', 'Tailwind CSS', 'Responsive Design'])) {
                                        $categorizedSkills['Front-End Development'][] = $skill;
                                    } elseif (in_array($skill, ['Laravel', 'PHP', 'MySQL', 'RESTful APIs', 'Node.js'])) {
                                        $categorizedSkills['Back-End Development'][] = $skill;
                                    } elseif (in_array($skill, ['Git', 'Vite', 'Webpack', 'Figma', 'Agile Methodologies', 'CI/CD'])) {
                                        $categorizedSkills['Tools & Others'][] = $skill;
                                    } else {
                                        // Fallback for uncategorized skills
                                        $categorizedSkills['Tools & Others'][] = $skill;
                                    }
                                }
                            }
                        @endphp
                        @if (array_filter($categorizedSkills, fn($category) => !empty($category)))
                            @foreach ($categorizedSkills as $category => $skills)
                                @if (!empty($skills))
                                    <h3 class="category-title">{{ $category }}</h3>
                                    <ul class="list-group list-group-flush mb-2">
                                        @foreach ($skills as $skill)
                                            <li class="list-group-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                                <i class="bi bi-check-circle-fill"></i> {{ $skill }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endforeach
                        @else
                            <p class="text-gray-700 mb-4">No skills available.</p>
                        @endif

                        <h2 class="section-title text-2xl font-semibold mb-4">Experience</h2>
                        @if (is_array($about->experience) && count($about->experience) > 0)
                            <ul class="list-group list-group-flush mb-4">
                                @foreach ($about->experience as $exp)
                                    <li class="list-group-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                        <strong>{{ $exp['title'] ?? 'Untitled' }}</strong> at {{ $exp['company'] ?? 'Unknown Company' }} ({{ $exp['period'] ?? 'Unknown Period' }})
                                        @if (isset($exp['description']) && is_array($exp['description']) && count($exp['description']) > 0)
                                            <ul class="list-disc pl-5 mt-2">
                                                @foreach ($exp['description'] as $desc)
                                                    <li>{{ $desc }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mt-2 text-gray-600">No description available.</p>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-700 mb-4">No experience available.</p>
                        @endif

                        <h2 class="section-title text-2xl font-semibold mb-4">Education</h2>
                        @if (is_array($about->education) && count($about->education) > 0)
                            <ul class="list-group list-group-flush mb-4">
                                @foreach ($about->education as $edu)
                                    <li class="list-group-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                        <strong>{{ $edu['degree'] ?? 'Unknown Degree' }}</strong> at {{ $edu['institution'] ?? 'Unknown Institution' }} ({{ $edu['period'] ?? 'Unknown Period' }})
                                        <p class="mt-2">{{ $edu['description'] ?? 'No description available.' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-700 mb-4">No education available.</p>
                        @endif

                        <h2 class="section-title text-2xl font-semibold mb-4">Hobbies</h2>
                        <p class="text-gray-700 mb-4">{{ $about->hobbies ?? 'No hobbies listed.' }}</p>

                        @if ($about->image)
                            <h2 class="section-title text-2xl font-semibold mb-4">Image</h2>
                            <img src="{{ asset('storage/' . $about->image) }}" alt="About Image" class="img-fluid rounded shadow-sm mb-4 about-image" style="max-width: 200px;">
                        @else
                            <p class="text-gray-700 mb-4">No image uploaded.</p>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('about.edit', $about->id) }}" class="btn btn-primary animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                                <i class="bi bi-pencil-fill me-2"></i> Edit
                            </a>
                            <form action="{{ route('about.destroy', $about->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this About entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                                    <i class="bi bi-trash-fill me-2"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info animate__animated animate__fadeIn">
                    No About data available.
                </div>
                <a href="{{ route('about.create') }}" class="btn btn-success animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                    <i class="bi bi-plus-circle-fill me-2"></i> Create About
                </a>
            @endif
        </div>
    @endsection
</body>
</html>