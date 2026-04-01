@extends('layouts.admin')

@section('title', 'Create Page')

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
        <h2>Create New Page</h2>
    </div>
</div>

<form action="{{ route('admin.pages.store') }}" method="POST" id="pageForm">
    @csrf
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
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">URL Slug</label>
                        <div class="input-group">
                            <span class="input-group-text">/page/</span>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                   id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generated-from-title">
                        </div>
                        <small class="text-muted">Leave empty to auto-generate from title</small>
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

                    <div id="noSections" class="text-center py-4 text-muted">
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
                    <textarea class="form-control" id="content" name="content" rows="15">{{ old('content') }}</textarea>
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
                               name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_published">
                            Published
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sort_order"
                               name="sort_order" value="{{ old('sort_order', 0) }}">
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
                               name="show_in_menu" value="1" {{ old('show_in_menu', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="show_in_menu">
                            Show in Menu
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="menu_location" class="form-label">Menu Location</label>
                        <select class="form-select" id="menu_location" name="menu_location">
                            <option value="main" {{ old('menu_location', 'main') === 'main' ? 'selected' : '' }}>Main Navigation (Top Level)</option>
                            <option value="about" {{ old('menu_location') === 'about' ? 'selected' : '' }}>"About" Dropdown</option>
                            <option value="footer" {{ old('menu_location') === 'footer' ? 'selected' : '' }}>Footer Only</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="menu_title" class="form-label">Menu Title</label>
                        <input type="text" class="form-control" id="menu_title"
                               name="menu_title" value="{{ old('menu_title') }}" placeholder="Uses page title if empty">
                    </div>
                </div>
            </div>

            <!-- SEO Settings -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">SEO Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title"
                               name="meta_title" value="{{ old('meta_title') }}">
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description"
                                  name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Page
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>

    <!-- Hidden input for sections JSON -->
    <input type="hidden" name="sections" id="sectionsInput" value="{{ old('sections', '[]') }}">
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
    let editorInstances = {};

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

    function createColumnEditors(sectionEl, numColumns, existingContent = []) {
        const container = sectionEl.querySelector('.column-editors');
        container.innerHTML = '';

        for (let i = 0; i < numColumns; i++) {
            const colDiv = document.createElement('div');
            colDiv.className = 'column-content';
            const editorId = sectionEl.dataset.sectionId + '_col_' + i;

            colDiv.innerHTML = `
                <label>${numColumns > 1 ? 'Column ' + (i + 1) : 'Content'}</label>
                <textarea id="${editorId}" class="form-control column-editor">${existingContent[i] || ''}</textarea>
            `;
            container.appendChild(colDiv);

            // Initialize editor
            setTimeout(() => {
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
            }, 100);
        }
    }

    function setupSectionEvents(sectionEl) {
        // Layout selection
        sectionEl.querySelectorAll('.layout-option').forEach(opt => {
            opt.addEventListener('click', function() {
                sectionEl.querySelectorAll('.layout-option').forEach(o => o.classList.remove('active'));
                this.classList.add('active');

                const numColumns = parseInt(this.dataset.layout);
                const existingEditors = sectionEl.querySelectorAll('.column-editor');
                const existingContent = [];

                existingEditors.forEach((editor, i) => {
                    const editorId = editor.id;
                    if (editorInstances[editorId]) {
                        existingContent.push(editorInstances[editorId].getContent());
                        editorInstances[editorId].remove();
                        delete editorInstances[editorId];
                    }
                });

                createColumnEditors(sectionEl, numColumns, existingContent);
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

    // Form submission
    document.getElementById('pageForm').addEventListener('submit', function(e) {
        const sectionsData = [];

        document.querySelectorAll('.section-item').forEach(sectionEl => {
            const layout = parseInt(sectionEl.querySelector('.layout-option.active').dataset.layout);
            const bgType = sectionEl.querySelector('.bg-type-select').value;
            const bgColor = sectionEl.querySelector('.bg-color-input').value;

            const columns = [];
            sectionEl.querySelectorAll('.column-editor').forEach(editor => {
                if (editorInstances[editor.id]) {
                    columns.push(editorInstances[editor.id].getContent());
                } else {
                    columns.push(editor.value);
                }
            });

            sectionsData.push({
                layout: layout,
                bg_type: bgType,
                bg_color: bgColor,
                columns: columns
            });
        });

        document.getElementById('sectionsInput').value = JSON.stringify(sectionsData);

        if (hugerte.get('content')) {
            document.getElementById('content').value = hugerte.get('content').getContent();
        }
    });
});
</script>
@endpush
