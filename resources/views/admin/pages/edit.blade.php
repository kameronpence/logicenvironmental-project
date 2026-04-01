@extends('layouts.admin')

@section('title', 'Edit Page')

@push('styles')
<style>
    .section-item {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 1rem;
        background: #fff;
    }
    .section-header {
        background: #f8f9fa;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: grab;
    }
    .section-body {
        padding: 1rem;
    }
    .section-preview {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .section-preview .col-preview {
        background: #e9ecef;
        height: 40px;
        border-radius: 4px;
        flex: 1;
    }
    .layout-option {
        cursor: pointer;
        padding: 0.5rem;
        border: 2px solid #dee2e6;
        border-radius: 4px;
        text-align: center;
    }
    .layout-option:hover {
        border-color: #742E6F;
    }
    .layout-option.active {
        border-color: #742E6F;
        background: #f8f4f8;
    }
    .layout-cols {
        display: flex;
        gap: 2px;
        height: 30px;
        margin-bottom: 4px;
    }
    .layout-cols div {
        background: #742E6F;
        flex: 1;
        border-radius: 2px;
    }
    .bg-preview {
        width: 100%;
        height: 40px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-top: 0.5rem;
    }
    .column-content {
        margin-top: 1rem;
    }
    .column-content label {
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Edit Page: {{ $page->title }}</h2>
    </div>
</div>

<form action="{{ route('admin.pages.update', $page) }}" method="POST" id="pageForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">
        <div class="col-md-8">
            <!-- Basic Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Page Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Page Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $page->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text">/page/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug', $page->slug) }}" required>
                        </div>
                        @error('slug')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sections Builder -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Page Sections</h6>
                    <button type="button" class="btn btn-sm btn-primary" id="addSection">
                        <i class="fas fa-plus"></i> Add Section
                    </button>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Build your page with multiple sections. Each section can have its own layout and background.</p>

                    <div id="sectionsContainer">
                        <!-- Sections will be added here dynamically -->
                    </div>

                    <div id="noSections" class="text-center py-4 text-muted" style="display: none;">
                        <i class="fas fa-layer-group fa-2x mb-2"></i>
                        <p>No sections yet. Click "Add Section" to get started, or use the simple content editor below.</p>
                    </div>
                </div>
            </div>

            <!-- Simple Content (fallback) -->
            <div class="card border-0 shadow-sm mb-4" id="simpleContentCard">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Simple Content <small class="text-muted">(used if no sections defined)</small></h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control" id="content" name="content" rows="15">{{ old('content', $page->content) }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Publish Settings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Publish Settings</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_published"
                               name="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            Published
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order"
                               name="sort_order" value="{{ old('sort_order', $page->sort_order) }}">
                    </div>
                </div>
            </div>

            <!-- Menu Settings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Menu Settings</h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="show_in_menu"
                               name="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_in_menu">
                            Show in Menu
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="menu_location" class="form-label">Menu Location</label>
                        <select class="form-select" id="menu_location" name="menu_location">
                            <option value="main" {{ old('menu_location', $page->menu_location) === 'main' ? 'selected' : '' }}>Main Navigation (Top Level)</option>
                            <option value="about" {{ old('menu_location', $page->menu_location) === 'about' ? 'selected' : '' }}>"About" Dropdown</option>
                            <option value="footer" {{ old('menu_location', $page->menu_location) === 'footer' ? 'selected' : '' }}>Footer Only</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="menu_title" class="form-label">Menu Title</label>
                        <input type="text" class="form-control" id="menu_title"
                               name="menu_title" value="{{ old('menu_title', $page->menu_title) }}" placeholder="Uses page title if empty">
                    </div>
                </div>
            </div>

            @if(isset($imageLocation))
            <!-- Page Image -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Page Image</h6>
                    <small class="text-muted">For simple content layout only</small>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($pageImage && $pageImage->image_path)
                            <img src="{{ Storage::url($pageImage->image_path) }}" alt="{{ $pageImage->alt_text ?? $page->title }}" class="img-fluid rounded" style="max-height: 150px;">
                        @else
                            <div class="rounded d-flex align-items-center justify-content-center mx-auto" style="height: 120px; width: 100%; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
                                <i class="fas fa-image fa-2x text-muted"></i>
                            </div>
                            <p class="text-muted mt-2 mb-0 small">No image uploaded</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="page_image" class="form-label">{{ $pageImage && $pageImage->image_path ? 'Replace Image' : 'Upload Image' }}</label>
                        <input type="file" class="form-control form-control-sm @error('page_image') is-invalid @enderror" id="page_image" name="page_image" accept="image/*">
                        <small class="text-muted d-block">Max 5MB. JPEG, PNG, GIF, WebP</small>
                        <small class="text-muted"><strong>Recommended:</strong> 600 x 500 pixels</small>
                        @error('page_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image_alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control form-control-sm" id="image_alt_text" name="image_alt_text" value="{{ old('image_alt_text', $pageImage->alt_text ?? '') }}" placeholder="Descriptive text for accessibility">
                    </div>

                    @if($pageImage && $pageImage->image_path)
                    <button type="button" class="btn btn-sm btn-outline-danger w-100 delete-page-image-btn"
                            data-url="{{ route('admin.pages.destroy-image', $page) }}">
                        <i class="fas fa-trash me-1"></i>Remove Image
                    </button>
                    @endif
                </div>
            </div>
            @endif

            @if(isset($multiImageLocations) && count($pageImages) > 0)
            <!-- Page Images -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Page Images</h6>
                    <small class="text-muted">For simple content layout only</small>
                </div>
                <div class="card-body">
                    @foreach($pageImages as $location => $data)
                    <div class="mb-4 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="text-center mb-2">
                            @if($data['image'] && $data['image']->image_path)
                                <img src="{{ Storage::url($data['image']->image_path) }}" alt="{{ $data['image']->alt_text ?? $data['label'] }}" class="img-fluid rounded" style="max-height: 120px;">
                            @else
                                <div class="rounded d-flex align-items-center justify-content-center mx-auto" style="height: 80px; width: 100%; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>

                        <div class="mb-2">
                            <label class="form-label small mb-1">Title</label>
                            <input type="text" class="form-control form-control-sm" name="image_title[{{ $location }}]" value="{{ old("image_title.{$location}", $data['image']->title ?? '') }}" placeholder="e.g., Georgia">
                        </div>

                        <div class="mb-2">
                            <label class="form-label small mb-1">Image</label>
                            <input type="file" class="form-control form-control-sm" name="images[{{ $location }}]" accept="image/*">
                            <small class="text-muted">Recommended: 800 x 400 pixels</small>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small mb-1">Alt Text</label>
                            <input type="text" class="form-control form-control-sm" name="image_alt[{{ $location }}]" value="{{ old("image_alt.{$location}", $data['image']->alt_text ?? '') }}" placeholder="Descriptive text for accessibility">
                        </div>

                        @if($data['image'] && $data['image']->image_path)
                        <button type="button" class="btn btn-sm btn-outline-danger w-100 delete-page-image-btn"
                                data-url="{{ route('admin.pages.destroy-image', [$page, $location]) }}">
                            <i class="fas fa-trash me-1"></i>Remove
                        </button>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- SEO Settings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">SEO Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title"
                               name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description"
                                  name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 mb-5 pb-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>

    <!-- Hidden input for sections JSON -->
    <input type="hidden" name="sections" id="sectionsInput" value="{{ old('sections', json_encode($page->sections ?? [])) }}">
</form>

<!-- Section Template -->
<template id="sectionTemplate">
    <div class="section-item" data-section-id="">
        <div class="section-header">
            <span class="section-title"><i class="fas fa-grip-vertical me-2"></i>Section <span class="section-number"></span></span>
            <div>
                <button type="button" class="btn btn-sm btn-outline-secondary toggle-section"><i class="fas fa-chevron-down"></i></button>
                <button type="button" class="btn btn-sm btn-outline-danger delete-section"><i class="fas fa-trash"></i></button>
            </div>
        </div>
        <div class="section-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Layout</label>
                    <div class="d-flex gap-2">
                        <div class="layout-option active" data-layout="1">
                            <div class="layout-cols"><div></div></div>
                            <small>1 Column</small>
                        </div>
                        <div class="layout-option" data-layout="2">
                            <div class="layout-cols"><div></div><div></div></div>
                            <small>2 Columns</small>
                        </div>
                        <div class="layout-option" data-layout="3">
                            <div class="layout-cols"><div></div><div></div><div></div></div>
                            <small>3 Columns</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Background</label>
                    <select class="form-select bg-type-select">
                        <option value="none">None (White)</option>
                        <option value="light">Light Gray</option>
                        <option value="dark">Dark</option>
                        <option value="primary">Primary Color</option>
                        <option value="color">Custom Color</option>
                    </select>
                    <input type="color" class="form-control form-control-color mt-2 bg-color-input" value="#f8f9fa" style="display: none;">
                </div>
            </div>

            <div class="column-editors">
                <!-- Column editors will be inserted here -->
            </div>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/hugerte@1/hugerte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let sections = [];
    let editorInstances = {};

    // Load existing sections
    try {
        const existingSections = JSON.parse(document.getElementById('sectionsInput').value || '[]');
        if (existingSections && existingSections.length > 0) {
            existingSections.forEach(section => addSection(section));
        }
    } catch(e) {
        console.error('Error parsing sections:', e);
    }

    updateNoSectionsVisibility();

    // Initialize simple content editor
    hugerte.init({
        selector: '#content',
        plugins: 'link image lists table code',
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
        height: 300,
        menubar: false,
        relative_urls: false,
        remove_script_host: false,
    });

    // Make sections sortable
    new Sortable(document.getElementById('sectionsContainer'), {
        animation: 150,
        handle: '.section-header',
        onEnd: updateSectionNumbers
    });

    // Add section button
    document.getElementById('addSection').addEventListener('click', function() {
        addSection();
    });

    function addSection(data = null) {
        const template = document.getElementById('sectionTemplate');
        const clone = template.content.cloneNode(true);
        const sectionEl = clone.querySelector('.section-item');
        const sectionId = 'section_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

        sectionEl.dataset.sectionId = sectionId;

        // Set layout
        const layout = data?.layout || 1;
        sectionEl.querySelectorAll('.layout-option').forEach(opt => {
            opt.classList.toggle('active', parseInt(opt.dataset.layout) === layout);
        });

        // Set background
        if (data?.bg_type) {
            sectionEl.querySelector('.bg-type-select').value = data.bg_type;
            if (data.bg_type === 'color' && data.bg_color) {
                sectionEl.querySelector('.bg-color-input').value = data.bg_color;
                sectionEl.querySelector('.bg-color-input').style.display = 'block';
            }
        }

        document.getElementById('sectionsContainer').appendChild(sectionEl);

        // Create column editors
        createColumnEditors(sectionEl, layout, data?.columns || []);

        // Setup event listeners
        setupSectionEvents(sectionEl);

        updateSectionNumbers();
        updateNoSectionsVisibility();
    }

    function createColumnEditors(sectionEl, numColumns, existingColumns = []) {
        const container = sectionEl.querySelector('.column-editors');
        container.innerHTML = '';

        for (let i = 0; i < numColumns; i++) {
            const colDiv = document.createElement('div');
            colDiv.className = 'column-content';
            colDiv.dataset.columnIndex = i;
            const editorId = sectionEl.dataset.sectionId + '_col_' + i;

            // Get existing column data (could be string for backwards compat or object)
            let colData = existingColumns[i] || { type: 'text', content: '' };
            if (typeof colData === 'string') {
                colData = { type: 'text', content: colData };
            }

            colDiv.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="mb-0">${numColumns > 1 ? 'Column ' + (i + 1) : 'Content'}</label>
                    <div class="btn-group btn-group-sm" role="group">
                        <input type="radio" class="btn-check" name="colType_${editorId}" id="colTypeText_${editorId}" value="text" ${colData.type === 'text' ? 'checked' : ''}>
                        <label class="btn btn-outline-secondary" for="colTypeText_${editorId}"><i class="fas fa-align-left"></i> Text</label>
                        <input type="radio" class="btn-check" name="colType_${editorId}" id="colTypeImage_${editorId}" value="image" ${colData.type === 'image' ? 'checked' : ''}>
                        <label class="btn btn-outline-secondary" for="colTypeImage_${editorId}"><i class="fas fa-image"></i> Image</label>
                    </div>
                </div>
                <div class="text-content-wrapper" style="${colData.type === 'image' ? 'display:none;' : ''}">
                    <textarea id="${editorId}" class="form-control column-editor">${colData.type === 'text' ? (colData.content || '') : ''}</textarea>
                </div>
                <div class="image-content-wrapper" style="${colData.type === 'text' ? 'display:none;' : ''}">
                    <input type="file" class="form-control form-control-sm column-image-input mb-2" accept="image/*" data-column="${i}">
                    <input type="hidden" class="column-image-path" value="${colData.type === 'image' ? (colData.content || '') : ''}">
                    <small class="text-muted d-block mb-2">Recommended: 800 x 500 pixels</small>
                    <div class="image-preview rounded" style="height: 120px; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        ${colData.type === 'image' && colData.content ? `<img src="/storage/${colData.content}" class="img-fluid h-100" style="object-fit: cover;">` : '<i class="fas fa-image fa-2x text-muted"></i>'}
                    </div>
                </div>
            `;
            container.appendChild(colDiv);

            // Setup type toggle
            const textRadio = colDiv.querySelector(`#colTypeText_${editorId}`);
            const imageRadio = colDiv.querySelector(`#colTypeImage_${editorId}`);
            const textWrapper = colDiv.querySelector('.text-content-wrapper');
            const imageWrapper = colDiv.querySelector('.image-content-wrapper');

            // Function to initialize editor for this column
            const initEditor = () => {
                if (!hugerte.get(editorId)) {
                    hugerte.init({
                        selector: '#' + editorId,
                        plugins: 'link image lists table code',
                        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
                        height: 250,
                        menubar: false,
                        relative_urls: false,
                        remove_script_host: false,
                        setup: function(editor) {
                            editorInstances[editorId] = editor;
                        }
                    });
                }
            };

            textRadio.addEventListener('change', () => {
                textWrapper.style.display = 'block';
                imageWrapper.style.display = 'none';
                // Initialize editor when switching to text
                setTimeout(initEditor, 100);
            });
            imageRadio.addEventListener('change', () => {
                textWrapper.style.display = 'none';
                imageWrapper.style.display = 'block';
            });

            // Image preview on file select
            const imageInput = colDiv.querySelector('.column-image-input');
            const imagePreview = colDiv.querySelector('.image-preview');
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.innerHTML = `<img src="${e.target.result}" class="img-fluid h-100" style="object-fit: cover;">`;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Always initialize text editor (even if image type, in case user switches)
            setTimeout(initEditor, 100);
        }
    }

    function setupSectionEvents(sectionEl) {
        // Layout selection
        sectionEl.querySelectorAll('.layout-option').forEach(opt => {
            opt.addEventListener('click', function() {
                sectionEl.querySelectorAll('.layout-option').forEach(o => o.classList.remove('active'));
                this.classList.add('active');

                const numColumns = parseInt(this.dataset.layout);
                const existingColumns = getColumnData(sectionEl);

                // Clean up existing editors
                sectionEl.querySelectorAll('.column-editor').forEach(editor => {
                    if (editorInstances[editor.id]) {
                        editorInstances[editor.id].remove();
                        delete editorInstances[editor.id];
                    }
                });

                createColumnEditors(sectionEl, numColumns, existingColumns);
            });
        });

        // Background type
        sectionEl.querySelector('.bg-type-select').addEventListener('change', function() {
            const colorInput = sectionEl.querySelector('.bg-color-input');
            colorInput.style.display = this.value === 'color' ? 'block' : 'none';
        });

        // Delete section
        sectionEl.querySelector('.delete-section').addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this section?')) {
                // Remove editors
                sectionEl.querySelectorAll('.column-editor').forEach(editor => {
                    if (editorInstances[editor.id]) {
                        editorInstances[editor.id].remove();
                        delete editorInstances[editor.id];
                    }
                });
                sectionEl.remove();
                updateSectionNumbers();
                updateNoSectionsVisibility();
            }
        });

        // Toggle section
        sectionEl.querySelector('.toggle-section').addEventListener('click', function() {
            const body = sectionEl.querySelector('.section-body');
            const icon = this.querySelector('i');
            body.style.display = body.style.display === 'none' ? 'block' : 'none';
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    }

    function updateSectionNumbers() {
        document.querySelectorAll('.section-item').forEach((section, index) => {
            section.querySelector('.section-number').textContent = index + 1;
        });
    }

    function updateNoSectionsVisibility() {
        const hasSections = document.querySelectorAll('.section-item').length > 0;
        document.getElementById('noSections').style.display = hasSections ? 'none' : 'block';
        document.getElementById('simpleContentCard').style.display = hasSections ? 'none' : 'block';
    }

    function getColumnData(sectionEl) {
        const columns = [];
        sectionEl.querySelectorAll('.column-content').forEach(colDiv => {
            const textarea = colDiv.querySelector('.column-editor');
            const editorId = textarea ? textarea.id : null;
            const textRadio = colDiv.querySelector(`input[value="text"]:checked`);
            const isText = textRadio !== null;

            if (isText) {
                // Get content from HugeRTE or textarea
                let content = '';
                // Try to get from HugeRTE instance first
                const editor = editorId ? hugerte.get(editorId) : null;
                if (editor) {
                    content = editor.getContent();
                } else if (textarea) {
                    content = textarea.value;
                }
                columns.push({ type: 'text', content: content });
            } else {
                // Get image path
                const imagePath = colDiv.querySelector('.column-image-path')?.value || '';
                columns.push({ type: 'image', content: imagePath });
            }
        });
        return columns;
    }

    // Form submission - collect sections data
    document.getElementById('pageForm').addEventListener('submit', function(e) {
        const sectionsData = [];

        document.querySelectorAll('.section-item').forEach((sectionEl, sectionIndex) => {
            const layout = parseInt(sectionEl.querySelector('.layout-option.active').dataset.layout);
            const bgType = sectionEl.querySelector('.bg-type-select').value;
            const bgColor = sectionEl.querySelector('.bg-color-input').value;

            const columns = getColumnData(sectionEl);

            sectionsData.push({
                layout: layout,
                bg_type: bgType,
                bg_color: bgColor,
                columns: columns
            });

            // Update image input names with current section index for proper form submission
            sectionEl.querySelectorAll('.column-image-input').forEach(input => {
                const colIndex = input.dataset.column;
                input.name = `section_images[${sectionIndex}][${colIndex}]`;
            });
        });

        document.getElementById('sectionsInput').value = JSON.stringify(sectionsData);

        // Sync simple content editor
        if (hugerte.get('content')) {
            document.getElementById('content').value = hugerte.get('content').getContent();
        }
    });

    // Delete page image buttons
    document.querySelectorAll('.delete-page-image-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Are you sure you want to remove this image?')) {
                return;
            }

            const url = this.dataset.url;
            const btn = this;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Find the card body and update it
                    const cardBody = btn.closest('.card-body');
                    if (cardBody) {
                        // If it's a multi-image section, just update that section
                        const imageContainer = cardBody.querySelector('.text-center');
                        if (imageContainer && imageContainer.querySelector('img')) {
                            imageContainer.innerHTML = `
                                <div class="rounded d-flex align-items-center justify-content-center mx-auto" style="height: 80px; width: 100%; background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            `;
                        }
                        btn.remove();
                    }
                } else {
                    alert('Failed to remove image: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while removing the image.');
            });
        });
    });
});
</script>
@endpush
