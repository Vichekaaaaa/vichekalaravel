<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit About</title>
    <style>
        .about-container {
            background: linear-gradient(135deg, #f4f6f9 0%, #e9ecef 100%);
            min-height: calc(100vh - 140px);
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
        .btn-primary, .btn-secondary, .btn-add {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover, .btn-secondary:hover, .btn-add:hover {
            transform: translateY(-2px);
        }
        .form-label {
            color: #1a1f2e;
            font-weight: 600;
        }
        .form-control {
            border-radius: 8px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        }
        .form-text {
            color: #6c757d;
        }
        .skill-item {
            margin-bottom: 0.5rem;
            padding: 0.5rem 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .experience-item, .education-item {
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .remove-btn {
            color: #dc3545;
            cursor: pointer;
        }
        .remove-btn:hover {
            color: #a71d2a;
        }
    </style>
</head>
<body>
    @extends('layouts.app')

    @section('content')
        <div class="container about-container animate__animated animate__fadeIn">
            <h1 class="text-3xl font-bold mb-6 animate__animated animate__fadeInDown">Edit About</h1>

            @if ($errors->any())
                <div class="alert alert-danger animate__animated animate__fadeInDown mb-6">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card about-card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-body">
                    <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data" id="aboutForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea name="bio" id="bio" class="form-control" rows="5">{{ old('bio', $about->bio) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Skills</label>
                            <div id="skillsContainer">
                                @php
                                    // Initialize categorized skills
                                    $categorizedSkills = [
                                        'Front-End Development' => [],
                                        'Back-End Development' => [],
                                        'Tools & Others' => [],
                                    ];
                                    if (is_array($about->skills)) {
                                        foreach ($about->skills as $skill) {
                                            if (isset($skill['name'], $skill['category']) && $skill['name'] && $skill['category']) {
                                                $categorizedSkills[$skill['category']][] = $skill['name'];
                                            } elseif (is_string($skill)) {
                                                // Handle legacy flat skills
                                                if (in_array($skill, ['React', 'JavaScript (ES6+)', 'HTML5', 'CSS3', 'Tailwind CSS', 'Responsive Design'])) {
                                                    $categorizedSkills['Front-End Development'][] = $skill;
                                                } elseif (in_array($skill, ['Laravel', 'PHP', 'MySQL', 'RESTful APIs', 'Node.js'])) {
                                                    $categorizedSkills['Back-End Development'][] = $skill;
                                                } else {
                                                    $categorizedSkills['Tools & Others'][] = $skill;
                                                }
                                            }
                                        }
                                    }
                                    // Merge with old input if available
                                    $oldSkills = old('skills', []);
                                    if (is_array($oldSkills)) {
                                        foreach ($oldSkills as $category => $skills) {
                                            if (is_array($skills)) {
                                                foreach ($skills as $skill) {
                                                    if (isset($skill['category'], $skill['name']) && $skill['name']) {
                                                        $categorizedSkills[$skill['category']][] = $skill['name'];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                @foreach ($categorizedSkills as $category => $skills)
                                    @if (is_array($skills) && count($skills) > 0)
                                        @foreach ($skills as $index => $skill)
                                            <div class="skill-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $loop->parent->index . '.' . $loop->index }}s;">
                                                <select name="skills[{{ $category }}][{{ $index }}][category]" class="form-control w-auto" style="max-width: 150px;">
                                                    <option value="Front-End Development" {{ $category === 'Front-End Development' ? 'selected' : '' }}>Front-End Development</option>
                                                    <option value="Back-End Development" {{ $category === 'Back-End Development' ? 'selected' : '' }}>Back-End Development</option>
                                                    <option value="Tools & Others" {{ $category === 'Tools & Others' ? 'selected' : '' }}>Tools & Others</option>
                                                </select>
                                                <input type="text" name="skills[{{ $category }}][{{ $index }}][name]" class="form-control d-inline-block w-auto" value="{{ trim($skill) }}" style="max-width: 200px;">
                                                <span class="remove-btn bi bi-trash" onclick="removeSkill(this)"></span>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                            <div class="mt-2">
                                <select id="newSkillCategory" class="form-control d-inline-block w-auto" style="max-width: 150px;">
                                    <option value="Front-End Development">Front-End Development</option>
                                    <option value="Back-End Development">Back-End Development</option>
                                    <option value="Tools & Others">Tools & Others</option>
                                </select>
                                <input type="text" id="newSkillName" class="form-control d-inline-block w-auto" style="max-width: 200px;" placeholder="Enter a skill">
                                <button type="button" class="btn btn-primary btn-sm btn-add ms-2" onclick="addSkill()">Add Skill</button>
                            </div>
                            <small class="form-text">e.g., React, Laravel, Git</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Experience</label>
                            <div id="experienceContainer">
                                @if (is_array($about->experience))
                                    @foreach ($about->experience as $index => $exp)
                                        <div class="experience-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <input type="text" name="experience[{{ $index }}][title]" class="form-control" value="{{ $exp['title'] ?? '' }}" placeholder="Title">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <input type="text" name="experience[{{ $index }}][company]" class="form-control" value="{{ $exp['company'] ?? '' }}" placeholder="Company">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <input type="text" name="experience[{{ $index }}][period]" class="form-control" value="{{ $exp['period'] ?? '' }}" placeholder="Period (e.g., 2022-Present)">
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <span class="remove-btn bi bi-trash" onclick="removeExperience(this)"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Description</label>
                                                    @if (isset($exp['description']) && is_array($exp['description']))
                                                        @foreach ($exp['description'] as $descIndex => $desc)
                                                            <div class="input-group mb-2">
                                                                <input type="text" name="experience[{{ $index }}][description][{{ $descIndex }}]" class="form-control" value="{{ $desc }}" placeholder="Description">
                                                                <button type="button" class="btn btn-danger btn-sm remove-desc" onclick="removeDescription(this)">Remove</button>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div class="input-group mb-2">
                                                            <input type="text" name="experience[{{ $index }}][description][0]" class="form-control" value="" placeholder="Description">
                                                            <button type="button" class="btn btn-danger btn-sm remove-desc" onclick="removeDescription(this)">Remove</button>
                                                        </div>
                                                    @endif
                                                    <button type="button" class="btn btn-success btn-sm" onclick="addDescription(this)">Add Description</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary btn-add mt-3" onclick="addExperience()">Add Experience</button>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Education</label>
                            <div id="educationContainer">
                                @if (is_array($about->education))
                                    @foreach ($about->education as $index => $edu)
                                        <div class="education-item animate__animated animate__fadeIn" style="animation-delay: {{ 0.1 * $loop->index }}s;">
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <input type="text" name="education[{{ $index }}][degree]" class="form-control" value="{{ $edu['degree'] ?? '' }}" placeholder="Degree">
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <input type="text" name="education[{{ $index }}][institution]" class="form-control" value="{{ $edu['institution'] ?? '' }}" placeholder="Institution">
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <input type="text" name="education[{{ $index }}][period]" class="form-control" value="{{ $edu['period'] ?? '' }}" placeholder="Period (e.g., 2016-2020)">
                                                </div>
                                                <div class="col-md-1 mb-3">
                                                    <span class="remove-btn bi bi-trash" onclick="removeEducation(this)"></span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" name="education[{{ $index }}][description]" class="form-control" value="{{ $edu['description'] ?? '' }}" placeholder="Description">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-primary btn-add mt-3" onclick="addEducation()">Add Education</button>
                        </div>

                        <div class="mb-4">
                            <label for="hobbies" class="form-label">Hobbies</label>
                            <textarea name="hobbies" id="hobbies" class="form-control" rows="5">{{ old('hobbies', $about->hobbies) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Image</label>
                            @if ($about->image)
                                <img src="{{ asset('storage/' . $about->image) }}" alt="Current Image" class="img-fluid rounded shadow-sm mb-4 about-image" style="max-width: 200px;">
                            @else
                                <p class="text-gray-700 mb-2">No image uploaded.</p>
                            @endif
                            <input type="file" name="image" id="image" class="form-control">
                            <small class="form-text">Accepted formats: JPEG, PNG, JPG, GIF (max 2MB)</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
                                <i class="bi bi-save-fill me-2"></i> Update
                            </button>
                            <a href="{{ route('about.index') }}" class="btn btn-secondary animate__animated animate__fadeIn" style="animation-delay: 0.3s;">
                                <i class="bi bi-x-circle-fill me-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Track indices for each category
                const skillIndices = {
                    'Front-End Development': document.querySelectorAll('#skillsContainer [name*="skills[Front-End Development]"]').length,
                    'Back-End Development': document.querySelectorAll('#skillsContainer [name*="skills[Back-End Development]"]').length,
                    'Tools & Others': document.querySelectorAll('#skillsContainer [name*="skills[Tools & Others]"]').length,
                };

                // Add Skill
                window.addSkill = function() {
                    const container = document.getElementById('skillsContainer');
                    const newSkillCategory = document.getElementById('newSkillCategory');
                    const newSkillName = document.getElementById('newSkillName');
                    const skillValue = newSkillName.value.trim();
                    const category = newSkillCategory.value;

                    if (skillValue) {
                        const index = skillIndices[category]; // Get current index for the category
                        const item = document.createElement('div');
                        item.className = 'skill-item animate__animated animate__fadeIn';
                        item.innerHTML = `
                            <select name="skills[${category}][${index}][category]" class="form-control w-auto" style="max-width: 150px;">
                                <option value="Front-End Development" ${category === 'Front-End Development' ? 'selected' : ''}>Front-End Development</option>
                                <option value="Back-End Development" ${category === 'Back-End Development' ? 'selected' : ''}>Back-End Development</option>
                                <option value="Tools & Others" ${category === 'Tools & Others' ? 'selected' : ''}>Tools & Others</option>
                            </select>
                            <input type="text" name="skills[${category}][${index}][name]" class="form-control d-inline-block w-auto" value="${skillValue}" style="max-width: 200px;">
                            <span class="remove-btn bi bi-trash" onclick="removeSkill(this)"></span>
                        `;
                        container.appendChild(item);
                        skillIndices[category]++; // Increment index for the category
                        newSkillName.value = '';
                    }
                };

                // Remove Skill
                window.removeSkill = function(btn) {
                    const skillItem = btn.closest('.skill-item');
                    const category = skillItem.querySelector('select').value;
                    skillItem.remove();
                    // Recalculate indices for the category
                    const skillsInCategory = document.querySelectorAll(`#skillsContainer [name*="skills[${category}]"]`);
                    skillIndices[category] = skillsInCategory.length / 2; // Divide by 2 because each skill has two inputs
                };

                // Add Experience
                window.addExperience = function() {
                    const container = document.getElementById('experienceContainer');
                    const index = container.children.length;
                    const item = document.createElement('div');
                    item.className = 'experience-item animate__animated animate__fadeIn';
                    item.innerHTML = `
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" name="experience[${index}][title]" class="form-control" placeholder="Title">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" name="experience[${index}][company]" class="form-control" placeholder="Company">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" name="experience[${index}][period]" class="form-control" placeholder="Period (e.g., 2022-Present)">
                            </div>
                            <div class="col-md-1 mb-3">
                                <span class="remove-btn bi bi-trash" onclick="removeExperience(this)"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <div class="input-group mb-2">
                                    <input type="text" name="experience[${index}][description][0]" class="form-control" placeholder="Description">
                                    <button type="button" class="btn btn-danger btn-sm remove-desc" onclick="removeDescription(this)">Remove</button>
                                </div>
                                <button type="button" class="btn btn-success btn-sm" onclick="addDescription(this)">Add Description</button>
                            </div>
                        </div>
                    `;
                    container.appendChild(item);
                };

                // Add Education
                window.addEducation = function() {
                    const container = document.getElementById('educationContainer');
                    const index = container.children.length;
                    const item = document.createElement('div');
                    item.className = 'education-item animate__animated animate__fadeIn';
                    item.innerHTML = `
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" name="education[${index}][degree]" class="form-control" placeholder="Degree">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" name="education[${index}][institution]" class="form-control" placeholder="Institution">
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" name="education[${index}][period]" class="form-control" placeholder="Period (e.g., 2016-2020)">
                            </div>
                            <div class="col-md-1 mb-3">
                                <span class="remove-btn bi bi-trash" onclick="removeEducation(this)"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <input type="text" name="education[${index}][description]" class="form-control" placeholder="Description">
                            </div>
                        </div>
                    `;
                    container.appendChild(item);
                };

                // Remove Experience
                window.removeExperience = function(btn) {
                    btn.closest('.experience-item').remove();
                };

                // Remove Education
                window.removeEducation = function(btn) {
                    btn.closest('.education-item').remove();
                };

                // Add Description
                window.addDescription = function(btn) {
                    const container = btn.parentElement;
                    const experienceItem = container.closest('.experience-item');
                    const experienceIndex = Array.from(document.querySelectorAll('#experienceContainer .experience-item')).indexOf(experienceItem);
                    const descIndex = container.querySelectorAll('.input-group').length;
                    const inputGroup = document.createElement('div');
                    inputGroup.className = 'input-group mb-2';
                    inputGroup.innerHTML = `
                        <input type="text" name="experience[${experienceIndex}][description][${descIndex}]" class="form-control" placeholder="Description">
                        <button type="button" class="btn btn-danger btn-sm remove-desc" onclick="removeDescription(this)">Remove</button>
                    `;
                    container.insertBefore(inputGroup, btn);
                };

                // Remove Description
                window.removeDescription = function(btn) {
                    btn.parentElement.remove();
                };
            });
        </script>
    @endsection
</body>
</html>