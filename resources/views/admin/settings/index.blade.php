@extends('layouts.admin')

@section('title', 'Master Settings')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="bi bi-gear"></i> Master Settings
    </h1>
    <!-- <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to clear all cache?')">
            <i class="bi bi-arrow-clockwise"></i> Clear Cache
        </button>
    </form> -->
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle"></i> General Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name *</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                               id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required>
                        @error('site_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="site_description" class="form-label">Site Description *</label>
                        <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                  id="site_description" name="site_description" rows="3" required>{{ old('site_description', $settings['site_description']) }}</textarea>
                        @error('site_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="site_email" class="form-label">Site Email *</label>
                        <input type="email" class="form-control @error('site_email') is-invalid @enderror" 
                               id="site_email" name="site_email" value="{{ old('site_email', $settings['site_email']) }}" required>
                        @error('site_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('site_phone') is-invalid @enderror" 
                                       id="site_phone" name="site_phone" value="{{ old('site_phone', $settings['site_phone'] ?? '') }}">
                                @error('site_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('site_address') is-invalid @enderror" 
                                       id="site_address" name="site_address" value="{{ old('site_address', $settings['site_address'] ?? '') }}">
                                @error('site_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="free_shipping_threshold" class="form-label">
                                    <i class="bi bi-truck"></i> Free Shipping Threshold
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control @error('free_shipping_threshold') is-invalid @enderror" 
                                           id="free_shipping_threshold" name="free_shipping_threshold" 
                                           value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold'] ?? '') }}" 
                                           min="0" step="0.01" placeholder="500">
                                    @error('free_shipping_threshold')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Orders above this amount will qualify for free shipping. Leave empty to disable free shipping.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currency & Pricing -->
            <!-- <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-currency-dollar"></i> Currency & Pricing
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency Code *</label>
                                <input type="text" class="form-control @error('currency') is-invalid @enderror" 
                                       id="currency" name="currency" value="{{ old('currency', $settings['currency']) }}" 
                                       maxlength="3" placeholder="USD" required>
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency_symbol" class="form-label">Currency Symbol *</label>
                                <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror" 
                                       id="currency_symbol" name="currency_symbol" value="{{ old('currency_symbol', $settings['currency_symbol']) }}" 
                                       maxlength="10" placeholder="$" required>
                                @error('currency_symbol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                                <input type="number" class="form-control @error('tax_rate') is-invalid @enderror" 
                                       id="tax_rate" name="tax_rate" value="{{ old('tax_rate', $settings['tax_rate'] ?? '') }}" 
                                       min="0" max="100" step="0.01">
                                @error('tax_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="shipping_fee" class="form-label">Shipping Fee</label>
                                <input type="number" class="form-control @error('shipping_fee') is-invalid @enderror" 
                                       id="shipping_fee" name="shipping_fee" value="{{ old('shipping_fee', $settings['shipping_fee'] ?? '') }}" 
                                       min="0" step="0.01">
                                @error('shipping_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="free_shipping_threshold" class="form-label">Free Shipping Threshold</label>
                                <input type="number" class="form-control @error('free_shipping_threshold') is-invalid @enderror" 
                                       id="free_shipping_threshold" name="free_shipping_threshold" value="{{ old('free_shipping_threshold', $settings['free_shipping_threshold'] ?? '') }}" 
                                       min="0" step="0.01">
                                @error('free_shipping_threshold')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>

        <!-- Display Settings -->
        <div class="col-lg-6">
            <!-- Theme & Colors -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-palette"></i> Theme & Colors
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admin_primary_color" class="form-label">Primary Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('admin_primary_color') is-invalid @enderror" 
                                           id="admin_primary_color" name="admin_primary_color" 
                                           value="{{ old('admin_primary_color', $settings['admin_primary_color'] ?? '#667eea') }}">
                                    <input type="text" class="form-control @error('admin_primary_color') is-invalid @enderror" 
                                           id="admin_primary_color_text" name="admin_primary_color_text" 
                                           value="{{ old('admin_primary_color', $settings['admin_primary_color'] ?? '#667eea') }}" 
                                           placeholder="#667eea">
                                </div>
                                @error('admin_primary_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Main color for buttons and highlights</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admin_secondary_color" class="form-label">Secondary Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('admin_secondary_color') is-invalid @enderror" 
                                           id="admin_secondary_color" name="admin_secondary_color" 
                                           value="{{ old('admin_secondary_color', $settings['admin_secondary_color'] ?? '#5a67d8') }}">
                                    <input type="text" class="form-control @error('admin_secondary_color') is-invalid @enderror" 
                                           id="admin_secondary_color_text" name="admin_secondary_color_text" 
                                           value="{{ old('admin_secondary_color', $settings['admin_secondary_color'] ?? '#5a67d8') }}" 
                                           placeholder="#5a67d8">
                                </div>
                                @error('admin_secondary_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Secondary color for hover effects</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admin_sidebar_color" class="form-label">Sidebar Background</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('admin_sidebar_color') is-invalid @enderror" 
                                           id="admin_sidebar_color" name="admin_sidebar_color" 
                                           value="{{ old('admin_sidebar_color', $settings['admin_sidebar_color'] ?? '#1a202c') }}">
                                    <input type="text" class="form-control @error('admin_sidebar_color') is-invalid @enderror" 
                                           id="admin_sidebar_color_text" name="admin_sidebar_color_text" 
                                           value="{{ old('admin_sidebar_color', $settings['admin_sidebar_color'] ?? '#1a202c') }}" 
                                           placeholder="#1a202c">
                                </div>
                                @error('admin_sidebar_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Sidebar background color</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admin_sidebar_hover_color" class="form-label">Sidebar Hover Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('admin_sidebar_hover_color') is-invalid @enderror" 
                                           id="admin_sidebar_hover_color" name="admin_sidebar_hover_color" 
                                           value="{{ old('admin_sidebar_hover_color', $settings['admin_sidebar_hover_color'] ?? '#2d3748') }}">
                                    <input type="text" class="form-control @error('admin_sidebar_hover_color') is-invalid @enderror" 
                                           id="admin_sidebar_hover_color_text" name="admin_sidebar_hover_color_text" 
                                           value="{{ old('admin_sidebar_hover_color', $settings['admin_sidebar_hover_color'] ?? '#2d3748') }}" 
                                           placeholder="#2d3748">
                                </div>
                                @error('admin_sidebar_hover_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Sidebar menu hover color</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admin_text_color" class="form-label">Text Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('admin_text_color') is-invalid @enderror" 
                                           id="admin_text_color" name="admin_text_color" 
                                           value="{{ old('admin_text_color', $settings['admin_text_color'] ?? '#2d3748') }}">
                                    <input type="text" class="form-control @error('admin_text_color') is-invalid @enderror" 
                                           id="admin_text_color_text" name="admin_text_color_text" 
                                           value="{{ old('admin_text_color', $settings['admin_text_color'] ?? '#2d3748') }}" 
                                           placeholder="#2d3748">
                                </div>
                                @error('admin_text_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Main text color</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="admin_background_color" class="form-label">Background Color</label>
                                <div class="input-group">
                                    <input type="color" class="form-control form-control-color @error('admin_background_color') is-invalid @enderror" 
                                           id="admin_background_color" name="admin_background_color" 
                                           value="{{ old('admin_background_color', $settings['admin_background_color'] ?? '#f7fafc') }}">
                                    <input type="text" class="form-control @error('admin_background_color') is-invalid @enderror" 
                                           id="admin_background_color_text" name="admin_background_color_text" 
                                           value="{{ old('admin_background_color', $settings['admin_background_color'] ?? '#f7fafc') }}" 
                                           placeholder="#f7fafc">
                                </div>
                                @error('admin_background_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Main background color</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="reset-colors">
                                    <i class="bi bi-arrow-clockwise"></i> Reset to Default Colors
                                </button>
                                <button type="button" class="btn btn-outline-info btn-sm ms-2" id="preview-colors">
                                    <i class="bi bi-eye"></i> Preview Colors
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Brand Assets -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-images"></i> Brand Assets
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="favicon" class="form-label">Favicon</label>
                                <input type="file" class="form-control @error('favicon') is-invalid @enderror" 
                                       id="favicon" name="favicon" accept="image/*">
                                @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload a favicon (16x16 or 32x32 pixels recommended)</div>
                                @if(isset($settings['favicon']) && $settings['favicon'])
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($settings['favicon']) }}" alt="Current Favicon" 
                                             style="width: 32px; height: 32px; object-fit: cover;">
                                        <small class="text-muted ms-2">Current favicon</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       id="logo" name="logo" accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Upload a site logo (recommended: 200x50 pixels)</div>
                                @if(isset($settings['logo']) && $settings['logo'])
                                    <div class="mt-2">
                                        <img src="{{ Storage::url($settings['logo']) }}" alt="Current Logo" 
                                             style="max-width: 200px; height: 50px; object-fit: contain;">
                                        <small class="text-muted ms-2">Current logo</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display Options -->
            <!-- <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-display"></i> Display Options
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="items_per_page" class="form-label">Items Per Page *</label>
                                <input type="number" class="form-control @error('items_per_page') is-invalid @enderror" 
                                       id="items_per_page" name="items_per_page" value="{{ old('items_per_page', $settings['items_per_page']) }}" 
                                       min="1" max="50" required>
                                @error('items_per_page')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="featured_products_count" class="form-label">Featured Products *</label>
                                <input type="number" class="form-control @error('featured_products_count') is-invalid @enderror" 
                                       id="featured_products_count" name="featured_products_count" value="{{ old('featured_products_count', $settings['featured_products_count']) }}" 
                                       min="1" max="20" required>
                                @error('featured_products_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="latest_products_count" class="form-label">Latest Products *</label>
                                <input type="number" class="form-control @error('latest_products_count') is-invalid @enderror" 
                                       id="latest_products_count" name="latest_products_count" value="{{ old('latest_products_count', $settings['latest_products_count']) }}" 
                                       min="1" max="20" required>
                                @error('latest_products_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Social Media Links -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="bi bi-share"></i> Social Media Links
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">
                            <i class="bi bi-facebook text-primary"></i> Facebook URL
                        </label>
                        <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                               id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}">
                        @error('facebook_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="twitter_url" class="form-label">
                            <i class="bi bi-twitter text-info"></i> Twitter URL
                        </label>
                        <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                               id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}">
                        @error('twitter_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="instagram_url" class="form-label">
                            <i class="bi bi-instagram text-danger"></i> Instagram URL
                        </label>
                        <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                               id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}">
                        @error('instagram_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label for="youtube_url" class="form-label">
                            <i class="bi bi-youtube text-danger"></i> YouTube URL
                        </label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                               id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}">
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mb-4">
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-circle"></i> Save Settings
        </button>
    </div>
</form>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Color picker and text input synchronization
    const colorFields = [
        'admin_primary_color',
        'admin_secondary_color', 
        'admin_sidebar_color',
        'admin_sidebar_hover_color',
        'admin_text_color',
        'admin_background_color'
    ];
    
    colorFields.forEach(field => {
        const colorInput = document.getElementById(field);
        const textInput = document.getElementById(field + '_text');
        
        // Sync color picker to text input
        colorInput.addEventListener('input', function() {
            textInput.value = this.value;
        });
        
        // Sync text input to color picker
        textInput.addEventListener('input', function() {
            if (isValidHexColor(this.value)) {
                colorInput.value = this.value;
            }
        });
    });
    
    // Reset to default colors
    document.getElementById('reset-colors').addEventListener('click', function() {
        if (confirm('Are you sure you want to reset all colors to default values?')) {
            const defaults = {
                'admin_primary_color': '#667eea',
                'admin_secondary_color': '#5a67d8',
                'admin_sidebar_color': '#1a202c',
                'admin_sidebar_hover_color': '#2d3748',
                'admin_text_color': '#2d3748',
                'admin_background_color': '#f7fafc'
            };
            
            Object.keys(defaults).forEach(field => {
                document.getElementById(field).value = defaults[field];
                document.getElementById(field + '_text').value = defaults[field];
            });
        }
    });
    
    // Preview colors
    document.getElementById('preview-colors').addEventListener('click', function() {
        const colors = {};
        colorFields.forEach(field => {
            colors[field] = document.getElementById(field).value;
        });
        
        // Apply preview styles
        applyPreviewStyles(colors);
        
        // Show preview notification
        showPreviewNotification();
    });
    
    function isValidHexColor(hex) {
        return /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/.test(hex);
    }
    
    function applyPreviewStyles(colors) {
        // Remove existing preview styles
        const existingStyle = document.getElementById('preview-styles');
        if (existingStyle) {
            existingStyle.remove();
        }
        
        // Create new preview styles
        const style = document.createElement('style');
        style.id = 'preview-styles';
        style.textContent = `
            :root {
                --primary-color: ${colors.admin_primary_color} !important;
                --primary-dark: ${colors.admin_secondary_color} !important;
                --sidebar-bg: ${colors.admin_sidebar_color} !important;
                --sidebar-hover: ${colors.admin_sidebar_hover_color} !important;
                --text-color: ${colors.admin_text_color} !important;
                --bg-color: ${colors.admin_background_color} !important;
            }
            
            body {
                background-color: var(--bg-color) !important;
                color: var(--text-color) !important;
            }
            
            .sidebar {
                background: linear-gradient(180deg, var(--sidebar-bg) 0%, var(--sidebar-hover) 100%) !important;
            }
            
            .nav-link:hover {
                background-color: var(--sidebar-hover) !important;
            }
            
            .nav-link.active {
                background: linear-gradient(90deg, var(--primary-color), var(--primary-dark)) !important;
            }
            
            .btn-primary {
                background-color: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
            }
            
            .btn-primary:hover {
                background-color: var(--primary-dark) !important;
                border-color: var(--primary-dark) !important;
            }
            
            .card {
                color: var(--text-color) !important;
            }
            
            .form-control {
                color: var(--text-color) !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    function showPreviewNotification() {
        // Remove existing notification
        const existingNotification = document.querySelector('.preview-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Create preview notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-info alert-dismissible fade show preview-notification';
        notification.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px;';
        notification.innerHTML = `
            <strong>Preview Mode Active!</strong> Colors are being previewed. Save settings to apply permanently.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="stop-preview">
                    <i class="bi bi-x-circle"></i> Stop Preview
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Add stop preview functionality
        document.getElementById('stop-preview').addEventListener('click', function() {
            const previewStyles = document.getElementById('preview-styles');
            if (previewStyles) {
                previewStyles.remove();
            }
            notification.remove();
        });
        
        // Auto-dismiss after 10 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 10000);
    }
});
</script>
@endsection 