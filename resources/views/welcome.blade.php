@extends('layouts.master')
@section('content')
  <!-- مثال على استدعاء Bootstrap وFont Awesome -->
  <!-- قسم الهيرو -->
  <section class="hero text-white">
    <div class="container">
      <div class="row align-items-center g-5 mt-1"  >
        <div class="col-lg-6">
          <h1 class="display-4 fw-bold animate__animated animate__fadeInUp">
            أنشئ متجرك الإلكتروني خلال دقائق!
          </h1>
          <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
            منصة عربية متكاملة مع كل ما تحتاجه لبدء تجارتك الإلكترونية
          </p>
          <div class="d-flex gap-3 animate__animated animate__fadeInUp animate__delay-2s">
            <a href="{{ route('templates') }}" class="btn btn-light btn-lg rounded-pill">ابدأ مجانًا</a>
            <a href="#features" class="btn btn-outline-light btn-lg rounded-pill">استكشاف المميزات</a>
          </div>
        </div>
        <div class="col-lg-5">
          <img src="{{ asset('assets/logoo-removebg.png') }}" class="hero-img" alt="واجهة المنصّة">
        </div>
      </div>
    </div>
  </section>

  <!-- قسم المميزات (Features) الجديد -->
  <section id="features" class="py-5">
    <div class="container">
      <div id="" class="text-center mb-5">
        <h2 class="display-5 fw-bold">مميزات منصتنا</h2>
        <p class="text-muted">كل ما تحتاجه لبناء وإدارة متجرك الإلكتروني بنجاح</p>
      </div>
      <!-- الصف الأول من الميزات -->
      <div class="row g-4">
        <div class="col-md-3">
          <div class="feature-card p-4 text-center">
            <div class="feature-icon mb-3">
              <!-- مثال على أيقونة (يمكنك تغييرها أو استخدام صورة) -->
              <span class="material-icons" style="font-size:2rem;">smartphone</span>
            </div>
            <h5 class="mb-2">إدارة متجرك من الهاتف</h5>
            <p class="text-muted">
              إدارة متجرك من أي مكان باستخدام هاتفك  </p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="feature-card p-4 text-center">
            <div class="feature-icon mb-3">
              <span class="material-icons" style="font-size:2rem;">inventory_2</span>
            </div>
            <h5 class="mb-2">تحكم في منتجاتك</h5>
            <p class="text-muted">
              أضف منتجاتك بسهولة وتحكم فيها من لوحة التحكم
            </p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="feature-card p-4 text-center">
            <div class="feature-icon mb-3">
              <span class="material-icons" style="font-size:2rem;">shopping_cart</span>
            </div>
            <h5 class="mb-2">ابدأ البيع فورًا</h5>
            <p class="text-muted">
              انشئ متجرك الإلكتروني في دقائق</p>
          </div>
        </div>
        <div class="col-md-3">
          <div class="feature-card p-4 text-center">
            <div class="feature-icon mb-3">
              <span class="material-icons" style="font-size:2rem;">translate</span>
            </div>
            <h5 class="mb-2">متجرك بلغات مختلفة</h5>
            <p class="text-muted">
              ترجم متجرك واحصل على زوار من دول مختلفة
            </p>
          </div>
        </div>
      
      </div>

      <!-- الصف الثاني من الميزات -->
      <div class="row g-4 mt-4">
       
      </div>
    </div>
  </section>

  <!-- قسم الآراء -->
  <section id="testimonials" class="py-5 bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="display-5 fw-bold">آراء عملائنا</h2>
        <p class="text-muted">ما يقوله رواد الأعمال عنا</p>
      </div>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="testimonial-card">
            <img src="{{ asset('assets/avatar3 (2).png') }}" class="rounded-circle" alt="عميل">
            <h4 class="mt-3">اسامة محمد قائد</h4>
            <p class="mt-2">"أفضل منصة عربية واجهتها، ساعدتني في إطلاق متجري خلال ساعات"</p>
            <div class="rating">★★★★★</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="testimonial-card">
            <img src="{{ asset('assets/avatar2.png') }}" class="rounded-circle" alt="عميل">
            <h4 class="mt-3">امجد طالب الشيباني</h4>
            <p class="mt-2">"أفضل منصة عربية واجهتها، ساعدتني في إطلاق متجري خلال ساعات"</p>
            <div class="rating">★★★★★</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="testimonial-card">
            <img src="{{ asset('assets/avatar3 (2).png') }}" class="rounded-circle" alt="عميل">
            <h4 class="mt-3"> حمزة جلال الصلوي</h4>
            <p class="mt-2">"أفضل منصة عربية واجهتها، ساعدتني في إطلاق متجري خلال ساعات"</p>
            <div class="rating">★★★★★</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="testimonial-card">
            <img src="{{ asset('assets/avatar2.png') }}" class="rounded-circle" alt="عميل">
            <h4 class="mt-3">رامي حزام الصلوي</h4>
            <p class="mt-2">"أفضل منصة عربية واجهتها، ساعدتني في إطلاق متجري خلال ساعات"</p>
            <div class="rating" style="    color: #ff6a00;">★★★★★</div>
          </div>
        </div>
        <!-- يمكن إضافة المزيد من الشهادات هنا -->
      </div>
    </div>
  </section>
  <!-- قسم الأسئلة المتكررة -->
  <section id="faq" class="py-5">
    <div class="container">
      <div class="text-center mb-5 section-title">
        <h2 class="display-5 fw-bold">الأسئلة المتكررة</h2>
        <p class="text-muted">أجوبة على أكثر الاستفسارات شيوعاً</p>
      </div>
      <div class="row">
        <!-- بطاقة سؤال -->
        <div class="col-md-6">
          <div class="faq-card">
            <h3>
              <span>هل تصميم المتاجر صعب؟</span>
              <i class="fas fa-angle-down toggle-icon"></i>
            </h3>
            <div class="faq-answer">
              <p>
                مع منصتنا، أصبح تصميم المتاجر أسهل من أي وقت. نوفر لك أدوات بسيطة وقوالب جاهزة
                مع دعم فني متكامل لمساعدتك في كل خطوة.
              </p>
            </div>
          </div>
        </div>
        <!-- بطاقة سؤال -->
        <div class="col-md-6">
          <div class="faq-card">
            <h3>
              <span>هل يمكن التصميم دون خبرة تقنية؟</span>
              <i class="fas fa-angle-down toggle-icon"></i>
            </h3>
            <div class="faq-answer">
              <p>
                نعم! صممنا المنصة لتكون سهلة الاستخدام للمبتدئين. يمكنك إنشاء متجرك باختيار القالب الناسب لك
              </p>
            </div>
          </div>
        </div>
        <!-- بطاقة سؤال -->
        <div class="col-md-6">
          <div class="faq-card">
            <h3>
              <span>ما قطاعات الأعمال المدعومة؟</span>
              <i class="fas fa-angle-down toggle-icon"></i>
            </h3>
            <div class="faq-answer">
              <p>
                نغطي جميع القطاعات: المتاجر الإلكترونية،  مع تحديثات مستمرة للقوالب والأدوات.
              </p>
            </div>
          </div>
        </div>
        <!-- بطاقة سؤال -->
        <div class="col-md-6">
          <div class="faq-card">
            <h3>
              <span>كيفية إدارة المحتوى؟</span>
              <i class="fas fa-angle-down toggle-icon"></i>
            </h3>
            <div class="faq-answer">
              <p>
                نوفر لوحة تحكم عربية بديهية مع إمكانية إدارة المحتوى، الطلبات، العملاء،
                والإحصائيات في مكان واحد.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
