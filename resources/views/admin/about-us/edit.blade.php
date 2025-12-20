@extends('layouts.admin')

@section('title', 'Edit About Us - Admin Panel')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit About Us Page</h5>
                    <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.about-us.update', $aboutUs->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Page Title</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                   value="{{ old('title', $aboutUs->title ?? '') }}">
                        </div>

                        <h6 class="mt-4 mb-3">Hero Section</h6>
                        <div class="mb-3">
                            <label for="hero_title" class="form-label">Hero Title</label>
                            <input type="text" name="hero_title" id="hero_title" class="form-control" 
                                   value="{{ old('hero_title', $aboutUs->hero_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" id="hero_subtitle" class="form-control" 
                                   value="{{ old('hero_subtitle', $aboutUs->hero_subtitle ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="hero_description" class="form-label">Hero Description</label>
                            <textarea name="hero_description" id="hero_description" rows="3" class="form-control">{{ old('hero_description', $aboutUs->hero_description ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="hero_image" class="form-label">Hero Image</label>
                            @php
                                $heroImageUrl = $aboutUs->hero_image_url ?? null;
                                $heroImageUrl = is_array($heroImageUrl) ? null : $heroImageUrl;
                            @endphp
                            @if($heroImageUrl)
                                <div class="mb-2">
                                    <img src="{{ $heroImageUrl }}" alt="Hero Image" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-muted mt-1">Current Hero Image</p>
                                    <div class="form-check">
                                        <input type="checkbox" name="remove_hero_image" id="remove_hero_image" class="form-check-input" value="1">
                                        <label class="form-check-label" for="remove_hero_image">Remove current image</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="hero_image" id="hero_image" 
                                   class="form-control @error('hero_image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('hero_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current image.
                            </small>
                        </div>

                        <h6 class="mt-4 mb-3">Main Content</h6>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content (Our Story)</label>
                            <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $aboutUs->content ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="our_story_image" class="form-label">Our Story Image</label>
                            @php
                                $ourStoryImageUrl = $aboutUs->our_story_image_url ?? null;
                                $ourStoryImageUrl = is_array($ourStoryImageUrl) ? null : $ourStoryImageUrl;
                            @endphp
                            @if($ourStoryImageUrl)
                                <div class="mb-2">
                                    <img src="{{ $ourStoryImageUrl }}" alt="Our Story Image" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-muted mt-1">Current Our Story Image</p>
                                    <div class="form-check">
                                        <input type="checkbox" name="remove_our_story_image" id="remove_our_story_image" class="form-check-input" value="1">
                                        <label class="form-check-label" for="remove_our_story_image">Remove current image</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="our_story_image" id="our_story_image" 
                                   class="form-control @error('our_story_image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('our_story_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current image.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="mission" class="form-label">Mission</label>
                            <textarea name="mission" id="mission" rows="3" class="form-control">{{ old('mission', $aboutUs->mission ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="mission_image" class="form-label">Mission Image</label>
                            @php
                                $missionImageUrl = $aboutUs->mission_image_url ?? null;
                                $missionImageUrl = is_array($missionImageUrl) ? null : $missionImageUrl;
                            @endphp
                            @if($missionImageUrl)
                                <div class="mb-2">
                                    <img src="{{ $missionImageUrl }}" alt="Mission Image" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-muted mt-1">Current Mission Image</p>
                                    <div class="form-check">
                                        <input type="checkbox" name="remove_mission_image" id="remove_mission_image" class="form-check-input" value="1">
                                        <label class="form-check-label" for="remove_mission_image">Remove current image</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="mission_image" id="mission_image" 
                                   class="form-control @error('mission_image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('mission_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current image.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="vision" class="form-label">Vision</label>
                            <textarea name="vision" id="vision" rows="3" class="form-control">{{ old('vision', $aboutUs->vision ?? '') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="vision_image" class="form-label">Vision Image</label>
                            @php
                                $visionImageUrl = $aboutUs->vision_image_url ?? null;
                                $visionImageUrl = is_array($visionImageUrl) ? null : $visionImageUrl;
                            @endphp
                            @if($visionImageUrl)
                                <div class="mb-2">
                                    <img src="{{ $visionImageUrl }}" alt="Vision Image" 
                                         class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                    <p class="text-muted mt-1">Current Vision Image</p>
                                    <div class="form-check">
                                        <input type="checkbox" name="remove_vision_image" id="remove_vision_image" class="form-check-input" value="1">
                                        <label class="form-check-label" for="remove_vision_image">Remove current image</label>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="vision_image" id="vision_image" 
                                   class="form-control @error('vision_image') is-invalid @enderror" 
                                   accept="image/*">
                            @error('vision_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Accepted formats: JPEG, PNG, JPG, GIF, SVG. Max size: 2MB. Leave empty to keep current image.
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="values" class="form-label">Values</label>
                            <textarea name="values" id="values" rows="3" class="form-control">{{ old('values', $aboutUs->values ?? '') }}</textarea>
                        </div>

                        <h6 class="mt-4 mb-3">Features Section</h6>
                        <div class="mb-3">
                            <label class="form-label">Features (Why Choose Us)</label>
                            <div id="features-container">
                                @php
                                    $features = old('features', $aboutUs->features ?? []);
                                    if (empty($features)) {
                                        $features = [
                                            ['title' => '', 'description' => '', 'icon' => 'fas fa-star']
                                        ];
                                    }
                                @endphp
                                @foreach($features as $index => $feature)
                                <div class="card mb-3 feature-item">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Feature Title</label>
                                                <input type="text" name="feature_titles[]" class="form-control" 
                                                       value="{{ $feature['title'] ?? '' }}" placeholder="e.g., Quality Assurance">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Icon (Font Awesome class)</label>
                                                <input type="text" name="feature_icons[]" class="form-control" 
                                                       value="{{ $feature['icon'] ?? 'fas fa-star' }}" placeholder="fas fa-shield-check">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="feature_descriptions[]" class="form-control" rows="2" 
                                                          placeholder="Feature description">{{ $feature['description'] ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-feature">
                                <i class="bi bi-plus-lg"></i> Add Feature
                            </button>
                        </div>

                        <h6 class="mt-4 mb-3">Statistics Section</h6>
                        <div class="mb-3">
                            <label class="form-label">Statistics</label>
                            <div id="stats-container">
                                @php
                                    // Handle old input for validation errors
                                    if (old('stat_numbers')) {
                                        $stats = [];
                                        $numbers = old('stat_numbers', []);
                                        $labels = old('stat_labels', []);
                                        foreach ($numbers as $index => $number) {
                                            $stats[] = [
                                                'number' => $number ?? '',
                                                'label' => $labels[$index] ?? '',
                                            ];
                                        }
                                    } else {
                                        $stats = $aboutUs->stats ?? [];
                                    }
                                    if (empty($stats)) {
                                        $stats = [
                                            ['number' => '', 'label' => '']
                                        ];
                                    }
                                @endphp
                                @foreach($stats as $index => $stat)
                                <div class="card mb-3 stat-item">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label">Number/Value</label>
                                                <input type="text" name="stat_numbers[]" class="form-control" 
                                                       value="{{ $stat['number'] ?? '' }}" placeholder="e.g., 50K+, 4.8★">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Label</label>
                                                <input type="text" name="stat_labels[]" class="form-control" 
                                                       value="{{ $stat['label'] ?? '' }}" placeholder="e.g., Happy Customers">
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm w-100 remove-stat">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-stat">
                                <i class="bi bi-plus-lg"></i> Add Statistic
                            </button>
                        </div>

                        <h6 class="mt-4 mb-3">Team Section</h6>
                        <div class="mb-3">
                            <label class="form-label">Team Members</label>
                            <div id="team-container">
                                @php
                                    // Handle old input for validation errors
                                    if (old('team_names')) {
                                        $team = [];
                                        $names = old('team_names', []);
                                        $positions = old('team_positions', []);
                                        $descriptions = old('team_descriptions', []);
                                        foreach ($names as $index => $name) {
                                            $team[] = [
                                                'name' => $name ?? '',
                                                'position' => $positions[$index] ?? '',
                                                'description' => $descriptions[$index] ?? '',
                                            ];
                                        }
                                    } else {
                                        $team = $aboutUs->team ?? [];
                                    }
                                    if (empty($team)) {
                                        $team = [
                                            ['name' => '', 'position' => '', 'description' => '']
                                        ];
                                    }
                                @endphp
                                @foreach($team as $index => $member)
                                <div class="card mb-3 team-item">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Name</label>
                                                <input type="text" name="team_names[]" class="form-control" 
                                                       value="{{ $member['name'] ?? '' }}" placeholder="Team member name">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Position</label>
                                                <input type="text" name="team_positions[]" class="form-control" 
                                                       value="{{ $member['position'] ?? '' }}" placeholder="e.g., Founder & CEO">
                                            </div>
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label">Description</label>
                                                <textarea name="team_descriptions[]" class="form-control" rows="2" 
                                                          placeholder="Team member description">{{ $member['description'] ?? '' }}</textarea>
                                            </div>
                                            <div class="col-md-1 mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <button type="button" class="btn btn-danger btn-sm w-100 remove-team">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-team">
                                <i class="bi bi-plus-lg"></i> Add Team Member
                            </button>
                        </div>

                        <!-- <h6 class="mt-4 mb-3">SEO</h6>
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                                   value="{{ old('meta_title', $aboutUs->meta_title ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="2" class="form-control">{{ old('meta_description', $aboutUs->meta_description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" 
                                       {{ old('is_active', $aboutUs->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active (visible on website)</label>
                            </div>
                        </div> -->

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-floppy"></i> Update About Us
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Features Management
    const featuresContainer = document.getElementById('features-container');
    const addFeatureBtn = document.getElementById('add-feature');
    
    addFeatureBtn.addEventListener('click', function() {
        const newFeature = document.createElement('div');
        newFeature.className = 'card mb-3 feature-item';
        newFeature.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Feature Title</label>
                        <input type="text" name="feature_titles[]" class="form-control" placeholder="e.g., Quality Assurance">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Icon (Font Awesome class)</label>
                        <input type="text" name="feature_icons[]" class="form-control" value="fas fa-star" placeholder="fas fa-shield-check">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="feature_descriptions[]" class="form-control" rows="2" placeholder="Feature description"></textarea>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm w-100 remove-feature">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        featuresContainer.appendChild(newFeature);
    });
    
    featuresContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-feature') || e.target.closest('.remove-feature')) {
            const item = e.target.closest('.feature-item');
            if (featuresContainer.children.length > 1) {
                item.remove();
            }
        }
    });
    
    // Stats Management
    const statsContainer = document.getElementById('stats-container');
    const addStatBtn = document.getElementById('add-stat');
    
    addStatBtn.addEventListener('click', function() {
        const newStat = document.createElement('div');
        newStat.className = 'card mb-3 stat-item';
        newStat.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Number/Value</label>
                        <input type="text" name="stat_numbers[]" class="form-control" placeholder="e.g., 50K+, 4.8★">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Label</label>
                        <input type="text" name="stat_labels[]" class="form-control" placeholder="e.g., Happy Customers">
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm w-100 remove-stat">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        statsContainer.appendChild(newStat);
    });
    
    statsContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-stat') || e.target.closest('.remove-stat')) {
            const item = e.target.closest('.stat-item');
            if (statsContainer.children.length > 1) {
                item.remove();
            }
        }
    });
    
    // Team Management
    const teamContainer = document.getElementById('team-container');
    const addTeamBtn = document.getElementById('add-team');
    
    addTeamBtn.addEventListener('click', function() {
        const newTeam = document.createElement('div');
        newTeam.className = 'card mb-3 team-item';
        newTeam.innerHTML = `
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="team_names[]" class="form-control" placeholder="Team member name">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Position</label>
                        <input type="text" name="team_positions[]" class="form-control" placeholder="e.g., Founder & CEO">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="team_descriptions[]" class="form-control" rows="2" placeholder="Team member description"></textarea>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm w-100 remove-team">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        teamContainer.appendChild(newTeam);
    });
    
    teamContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-team') || e.target.closest('.remove-team')) {
            const item = e.target.closest('.team-item');
            if (teamContainer.children.length > 1) {
                item.remove();
            }
        }
    });
});
</script>
@endsection
