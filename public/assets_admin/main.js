document.addEventListener('DOMContentLoaded', function () {
    setupDataTable();
    setupStepNavigation();
    setupDefaultTemplates();
    setupCharCounters();
});

function setupDataTable() {
    let table = new DataTable('#myTable', {
        "dom": 'Bfrtip',
        "language": {
            "search": "🔍 ابحث: ",
            "lengthMenu": "عرض _MENU_ سجل لكل صفحة",
            "info": "عرض _START_ إلى _END_ من _TOTAL_ سجل",
            "infoEmpty": "لا توجد سجلات متاحة",
            "zeroRecords": "لم يتم العثور على نتائج",
            "paginate": {
                "first": "الأول",
                "last": "الأخير",
                "next": "التالي",
                "previous": "السابق"
            }
        }
    });
    setTimeout(() => {
        document.querySelector('.dataTables_filter').style.textAlign = "center";
    }, 500);
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        });
    }, 2000);
}

function setupStepNavigation() {
    const stepItems = document.querySelectorAll('li[data-step]');
    const autoStep = window.nextStep;

    function hideAllCards() {
        document.querySelectorAll('.step-card').forEach(card => card.style.display = 'none');
    }

    if (autoStep) {
        hideAllCards();
        document.getElementById(`card-${autoStep}`).style.display = 'block';
    }

    stepItems.forEach(item => {
        item.addEventListener('click', function () {
            if (this.style.cursor === 'not-allowed') return;
            hideAllCards();
            document.getElementById(`card-${this.getAttribute('data-step')}`).style.display = 'block';
        });
    });
}

function setupDefaultTemplates() {
    const storeName = window.StoreName;
    const defaultTemplates = {
        privacy_policy: `تلتزم ${storeName} بحماية خصوصية عملائها بشكل كامل. 
1. نقوم بجمع المعلومات الشخصية فقط لأغراض تقديم الخدمات وتحسين التجربة.
2. لا نشارك أي بيانات مع أطراف ثالثة دون موافقتك الكتابية.
3. نستخدم تقنيات تشفير متقدمة لحماية البيانات من الوصول غير المصرح به.
4. يمكنك طلب حذف بياناتك الشخصية في أي وقت عبر التواصل مع الدعم.
5. يتم تحديث هذه السياسة دوريًا وفقًا لأحدث المعايير الأمنية والقانونية.`,

        terms_and_conditions: `باستخدامك خدمات ${storeName} فإنك توافق على الشروط التالية:
1. جميع المنتجات المعروضة ملكية فكرية حصرية للمتجر.
2. يتحمل العميل مسؤولية توفير معلومات دقيقة أثناء الشراء.
3. يحق للمتجر تعديل الأسعار أو الخدمات مع إشعار مسبق قبل 7 أيام.
4. يتم حساب تواريخ التسليم وفقًا لأيام العمل الرسمية.
5. يحق للمتجر تعليق الحسابات المخالفة دون إشعار مسبق.`,

        return__policy: `سياسة الاسترجاع في ${storeName} تشمل:
1. يمكن إرجاع المنتجات غير المستخدمة خلال 14 يومًا من الاستلام.
2. يجب أن يكون المنتج في حالته الأصلية مع جميع الملحقات والفواتير.
3. تتحمل شركة الشحن تكاليف الإرجاع في حالة وجود عيب مصنعي.
4. يتم معالجة طلبات الاسترجاع خلال 3-5 أيام عمل كحد أقصى.
5. يتم استرداد المبالغ عبر نفس طريقة الدفع الأصلية خلال 10 أيام.`,

        about: `مرحبًا بكم في متجر ${storeName} نسعى دائمًا لتقديم أفضل المنتجات والخدمات لعملائنا الكرام، مع التزامنا بمعايير الجودة العالية وخدمة العملاء المتميزة.
نحرص على توفير تجربة تسوق فريدة من خلال: تشكيلة منتجات متنوعة ومميزة عروض وتخفيضات حصرية دعم فني متاح على مدار الساعة
سياسة إرجاع مرنة شكرًا لثقتكم بنا، فريق ${storeName} دائمًا بخدمتكم. `,

    };

    window.fillDefault = function (fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) return console.error(`❌ العنصر '${fieldId}' غير موجود.`);

        const content = defaultTemplates[fieldId];
        if (!content) return console.error(`❌ لا يوجد قالب افتراضي لـ '${fieldId}'.`);

        field.value = content;
        field.dispatchEvent(new Event('input'));
        field.focus();
    };

    document.querySelectorAll('.btn-outline-primary').forEach(button => {
        button.addEventListener('click', function () {
            const fieldId = this.getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
            if (fieldId) window.fillDefault(fieldId);
        });
    });
}

function setupCharCounters() {
    const fields = [
        { fieldId: "privacy_policy", counterId: "charCountPrivacy" },
        { fieldId: "terms_and_conditions", counterId: "charCountTerms" },
        { fieldId: "about", counterId: "charCountabout" },
        { fieldId: "return__policy", counterId: "charCountReturn" }
    ];

    function updateCharCount(fieldId, counterId) {
        const field = document.getElementById(fieldId);
        const counter = document.getElementById(counterId);
        if (field && counter) counter.textContent = field.value.length;
    }

    fields.forEach(({ fieldId, counterId }) => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', () => updateCharCount(fieldId, counterId));
            updateCharCount(fieldId, counterId);
        }
    });
}

function triggerUpload() {
    document.getElementById('logoInput').click();
}
function previewImage(event, targetId) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById(targetId).src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}

function previewLogo(event) {
    const input = event.target;
    const container = document.getElementById('logoPreviewContainer');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            container.innerHTML = `
            <div class="logo-preview-wrapper">
                <img src="${e.target.result}" class="store-logo-preview img-thumbnail rounded" alt="شعار المتجر">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 shadow" onclick="removeLogo()" title="حذف الشعار">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
            document.getElementById('deleteLogo').value = '0';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function removeLogo() {
    const container = document.getElementById('logoPreviewContainer');
    document.getElementById('logoInput').value = '';
    document.getElementById('deleteLogo').value = '1';
    container.innerHTML = `
    <div class="upload-placeholder" onclick="triggerUpload()">
        <div class="store-logo-placeholder d-flex flex-column align-items-center justify-content-center">
            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
            <span class="text-muted">اختر صورة الشعار</span>
        </div>
    </div>
`;
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const link = document.getElementById('copy-link');
        link.innerHTML = '<i class="fas fa-check" style="margin-right: 8px;"></i> تم نسخ الرابط';
        setTimeout(() => {
            link.innerHTML =` <i class="fas fa-copy" style="margin-right: 8px; font-size: 18px;"></i> <span>${text} نسخ رابط المتجر</span>`;
        }, 2000);
    }).catch(err => {
        alert('حدث خطأ أثناء نسخ الرابط');
        console.error('فشل النسخ: ', err);
    });
}

function confirmDelete(event, categoryName) {
    if (!confirm(`هل أنت متأكد أنك تريد حذف المنتج "${categoryName}"؟`)) {
        event.preventDefault();
    }
}
