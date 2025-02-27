
document.addEventListener('DOMContentLoaded', function() {
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
});

    
    function fillDefaultAbout() {
        const storeName = window.StoreName;
        const defaultAbout = `مرحبًا بكم في متجر ${storeName} نسعى دائمًا لتقديم أفضل المنتجات والخدمات لعملائنا الكرام، مع التزامنا بمعايير الجودة العالية وخدمة العملاء المتميزة.
 نحرص على توفير تجربة تسوق فريدة من خلال: تشكيلة منتجات متنوعة ومميزة عروض وتخفيضات حصرية دعم فني متاح على مدار الساعة
سياسة إرجاع مرنة شكرًا لثقتكم بنا، فريق ${storeName} دائمًا بخدمتكم.`;

        const textarea = document.getElementById('about');
        textarea.value = defaultAbout;
        updateCharCount(); // تحديث عداد الأحرف
    }

    // عداد الأحرف للنبذة
    document.getElementById('about').addEventListener('input', updateCharCount);

    function updateCharCount() {
        const textarea = document.getElementById('about');
        const charCount = document.getElementById('charCount');
        charCount.textContent = textarea.value.length;
    }

    // تحديث العداد عند التحميل
    window.addEventListener('DOMContentLoaded', updateCharCount);

