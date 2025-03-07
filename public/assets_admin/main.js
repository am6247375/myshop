document.addEventListener('DOMContentLoaded', function () {
    const stepItems = document.querySelectorAll('li[data-step]');
    const autoStep =window.nextStep ;

    function hideAllCards() {
        document.querySelectorAll('.step-card').forEach(card => card.style.display = 'none');
    }

    if (autoStep) {
        hideAllCards();
        document.getElementById(`card-${autoStep}`).style.display = 'block';
    }

    stepItems.forEach(item => {
        item.addEventListener('click', function() {
            // إذا كان العنصر غير قابل للنقر، لا يتم تنفيذ الإجراء
            if (this.style.cursor === 'not-allowed') return;
            hideAllCards();
            document.getElementById(`card-${this.getAttribute('data-step')}`).style.display = 'block';
        });
    });

    // التأكد من تعريف اسم المتجر
    const storeName = window.StoreName ;

    // قوالب السياسات الافتراضية
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
   
    // دالة تعبئة النصوص الافتراضية
    function fillDefault(fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) {
            console.error(`❌ خطأ: العنصر ذو المعرف '${fieldId}' غير موجود في DOM.`);
            return;
        }

        const content = defaultTemplates[fieldId];
        if (!content) {
            console.error(`❌ خطأ: لا يوجد قالب افتراضي لـ '${fieldId}'.`);
            return;
        }

        field.value = content;
        field.dispatchEvent(new Event('input')); // تفعيل الحدث ليتم تحديث العداد
        field.focus();
    }

    // جعل الدالة متاحة عالميًا
    window.fillDefault = fillDefault;

    // إضافة الحدث لجميع الأزرار تلقائيًا
    document.querySelectorAll('.btn-outline-primary').forEach(button => {
        button.addEventListener('click', function () {
            const fieldId = this.getAttribute('onclick')?.match(/'([^']+)'/)?.[1];
            if (fieldId) fillDefault(fieldId);
        });
    });

    // تحديث عداد الأحرف لكل الحقول تلقائيًا
    function updateCharCount(fieldId, counterId) {
        const field = document.getElementById(fieldId);
        const counter = document.getElementById(counterId);
        if (field && counter) {
            counter.textContent = field.value.length;
        }
    }

    // قائمة الحقول التي تحتاج إلى عداد
    const fields = [
        { fieldId: "privacy_policy", counterId: "charCountPrivacy" },
        { fieldId: "terms_and_conditions", counterId: "charCountTerms" },
        { fieldId: "about", counterId: "charCountabout" },
        { fieldId: "return__policy", counterId: "charCountReturn" }
    ];

    // ربط الأحداث بكل حقل نصي
    fields.forEach(({ fieldId, counterId }) => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', () => updateCharCount(fieldId, counterId));
            updateCharCount(fieldId, counterId); // تحديث العداد عند تحميل الصفحة
        }
    });

});

