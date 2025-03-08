<div class="text-center mt-2">
    <img id="logoPreview" class="img-thumbnail d-none"
        style="max-width: 150px; max-height: 150px;">
</div>
<div class="mb-4">
    <label for="logo" class="form-label fw-bold">شعار المتجر</label>
    <div class="input-group">
        <!-- زر مخصص لاختيار الملف -->
        <label class="input-group-text btn btn-outline-primary" for="logo">اختر
            الشعار</label>
        <!-- حقل رفع مخفي -->
        <input type="file" name="logo" id="logo" class="d-none" accept="image/*"
            onchange="previewLogo(event)">
        <!-- حقل عرض اسم الملف -->
        <input type="text" class="form-control" id="fileName"
            placeholder="لم يتم اختيار ملف" readonly>
    </div>
    <small class="form-text text-muted">
        الصيغ المدعومة: JPG, PNG, SVG (الحجم الأقصى: 2MB)
    </small>
    @error('logo')
        <div class="invalid-feedback d-block">
            {{ $message }}
        </div>
    @enderror
</div>