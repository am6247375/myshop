
// تحديث شريط التقدّم أثناء التمرير
$(window).on('scroll', function() {
    const scrollable = $(document).height() - $(window).height();
    const scrolled = ($(window).scrollTop() / scrollable) * 100;
    $('#progress-bar').css('width', `${scrolled}%`);
});

// تفعيل تأثيرات الظهور التدريجي للعناصر باستخدام Intersection Observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            $(entry.target).addClass('animate__animated animate__fadeInUp');
        }
    });
}, {
    threshold: 0.1
});

$('.feature-card, .testimonial-card').each(function() {
    observer.observe(this);
});

// إغلاق القائمة عند النقر على أحد الروابط في الأجهزة الصغيرة
$('.nav-link').on('click', function() {
    const navbarCollapse = $('.navbar-collapse');
    if (navbarCollapse.hasClass('show')) {
        new bootstrap.Collapse(navbarCollapse[0]).hide();
    }
});

// تفعيل تأثير الأسئلة المتكررة (FAQ)
document.querySelectorAll('#faq .faq-card').forEach(card => {
    card.addEventListener('click', () => {
        card.classList.toggle('active');
    });
});

    function previewLogo(event) {
        const fileInput = event.target;
        const fileNameField = document.getElementById('fileName');
        if (fileInput.files && fileInput.files[0]) {
            // تحديث حقل اسم الملف
            fileNameField.value = fileInput.files[0].name;
            // قراءة الملف لعرض المعاينة
            const reader = new FileReader();
            reader.onload = function(e) {
                const logoPreview = document.getElementById('logoPreview');
                logoPreview.src = e.target.result;
                logoPreview.classList.remove('d-none');
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

document.getElementById('storeForm').addEventListener('submit', function(e) {
    const nameField = document.getElementById('name');
    if (nameField.value.trim().length < 3) {
        e.preventDefault();
        alert('الرجاء إدخال اسم متجر صالح (3 أحرف على الأقل)');
        nameField.focus();
    }
});
