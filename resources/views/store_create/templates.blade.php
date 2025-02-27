@extends('layouts.master')
@section('content')
<section class="templates-section py-5">
    <div class="container">
        <h1 class="text-center mb-5 display-4 fw-bold " style="color: rgba(44, 62, 80, 0.95); ">اختار تصميم متجرك</h1>
        
        <div class="row g-4 justify-content-center">
            @foreach ($templates as $template)
            <div class="col-lg-4 col-md-6">
                <div class="template-card shadow-lg rounded-4 overflow-hidden transition-all">
                    <div class="template-image-container position-relative">
                        <img src="{{ asset($template->image) }}" 
                             class="img-fluid template-image" 
                             alt="{{ $template->name }}"
                             loading="lazy">
                        
                        <div class="template-hover-overlay position-absolute top-0 start-0 w-100 h-100">
                            <div class="template-actions d-flex flex-column justify-content-center h-100 gap-3">
                                <form action="{{ route('store.create.view',[ $template->id ]) }}" method="GET">
                                    @csrf
                                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                        <i class="fas fa-magic me-2"></i> اختيار القالب
                                    </button>
                                </form>
                                <a href="{{ route('template.show',[$template->id ,'welcome'])}}" class="btn btn-outline-light btn-lg px-5 rounded-pill shadow-sm preview-btn"
                               
                                   data-template-id="{{ $template->id }}">
                                    معاينة القالب
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="template-info bg-white p-4">
                        <h3 class="mb-3 fw-bold text-dark">{{ $template->name }}</h3>
                        <div class="template-features">
                            <span class="badge bg-success me-2 mb-2">
                                <i class="fas fa-mobile-alt"></i> متجاوب
                            </span>
                           
                        </div>
                    </div> --}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal -->
{{-- <div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">معاينة القالب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <iframe id="templatePreviewFrame" class="w-100" style="height: 70vh"></iframe>
            </div>
        </div>
    </div>
</div> --}}


<style>
    .templates-section {
        
        margin-top: 50px;
        background: linear-gradient(to bottom, #f8f9fa, #ffffff);
    }
    
    .template-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid rgba(0,0,0,0.1);
    }
    
    .template-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    
    .template-image-container {
        height: 300px;
        overflow: hidden;
    }
    
    .template-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .template-hover-overlay {
        opacity: 0;
        background: rgba(0,0,0,0.7);
        transition: opacity 0.3s ease;
        padding: 20px;
    }
    
    .template-card:hover .template-hover-overlay {
        opacity: 1;
    }
    
    .template-actions .btn {
        transform: translateY(20px);
        opacity: 0;
        transition: all 0.3s ease;
    }
    
    .template-card:hover .template-actions .btn {
        transform: translateY(0);
        opacity: 1;
    }
    
    .preview-btn {
        transition-delay: 0.1s !important;
    }
</style>
{{-- 
<script>
document.addEventListener('DOMContentLoaded', function() {
    // معاينة القالب
    document.querySelectorAll('.preview-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const templateId = this.dataset.templateId;
            document.getElementById('templatePreviewFrame').src = `/templates/preview/${templateId}`;
        });
    });
});
</script> --}}

@endsection