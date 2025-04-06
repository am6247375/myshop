@extends('layouts.master_store_admin')
@section('content_admin')
    @php
        // المتجر موجود دائماً
        $storeCreated = true;
        // تحقق من إنشاء الأقسام والمنتجات
        $categoryCreated = $store->categories->count() > 0;
        $productCreated = $store->categories->pluck('products')->flatten()->count() > 0;
        // خطوات الدعم الفني والصفحات القانونية (افتراضيًا لم يتم إنشاؤها)
        if ($store->about != null && $store->whatsapp_link != null && $store->email_link != null) {
            $supportCreated = true;
        } else {
            $supportCreated = false;
        }
        if ($store->privacy_policy != null && $store->terms_and_conditions != null && $store->return__policy != null) {
            $conditionsCreated = true;
        } else {
            $conditionsCreated = false;
        }

        // حساب عدد الخطوات المكتملة (يعتبر إنشاء المتجر خطوة ثابتة)
        $completedSteps =
            1 +
            ($categoryCreated ? 1 : 0) +
            ($productCreated ? 1 : 0) +
            ($supportCreated ? 1 : 0) +
            ($conditionsCreated ? 1 : 0);
        // إجمالي الخطوات هو 5 (المتجر + 4 خطوات إضافية)
        $totalSteps = 5;

        // تحديد الخطوة التالية بناءً على الترتيب المنطقي:
        // يجب إنشاء المجموعة أولاً، ثم المنتج، ثم صفحة الدعم الفني، ثم الصفحات القانونية
        $nextStep = !$categoryCreated
            ? 'category'
            : (!$productCreated
                ? 'product'
                : (!$supportCreated
                    ? 'support'
                    : (!$conditionsCreated
                        ? 'conditions'
                        : '')));
    @endphp

    <section class="content-header">
        <div class="container-fluid text-center">
            {{-- <h2 class="mt-4 font-weight-bold">إعداد متجرك الإلكتروني</h2> --}}
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- خطوات المتجر -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0 rounded-lg p-3">
                        <div class="card-body">
                            <h5 class="text-center font-weight-bold mb-3">الخطوات الأساسية</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ([
            'store' => 'إنشاء المتجر',
            'category' => 'إنشاء القسم الأول لمتجرك',
            'product' => 'إضافة المنتج الأول لمتجرك',
            'support' => 'الدعم الفني ونبذة عن متجرك',
            'conditions' => 'الصفحات القانونية',
        ] as $step => $label)
                                    @php
                                        if ($step == 'store') {
                                            // خطوة المتجر دائماً مكتملة ولا يمكن النقر عليها
                                            $completed = true;
                                            $disabled = true;
                                        } else {
                                            $completed =
                                                ($step == 'category' && $categoryCreated) ||
                                                ($step == 'product' && $productCreated) ||
                                                ($step == 'support' && $supportCreated) ||
                                                ($step == 'conditions' && $conditionsCreated);
                                            if ($completed) {
                                                // إذا كانت الخطوة مكتملة، نجعلها غير قابلة للنقر
                                                $disabled = true;
                                            } else {
                                                // شروط تعطيل الخطوات بناءً على الترتيب
                                                $disabled =
                                                    ($step == 'product' && !$categoryCreated) ||
                                                    ($step == 'support' && !$productCreated) ||
                                                    ($step == 'conditions' && !$supportCreated);
                                            }
                                        }
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center {{ $disabled ? 'text-muted' : '' }}"
                                        data-step="{{ $step }}"
                                        style="cursor: {{ $disabled ? 'not-allowed' : 'pointer' }}">
                                        <span>
                                            <i class="fas {{ $completed ? 'fa-check-circle' : 'fa-circle' }} mr-2"
                                            style="background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%); -webkit-background-clip: text; color: transparent;"></i>
                                         
                                            {{ $label }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- نسبة الإنجاز والبطاقات -->
                <div class="col-md-6 mb-4">
                    <div class="progress mb-3" style="height: 50px; border-radius: 25px;">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ ($completedSteps / $totalSteps) * 100 }}%; " id="sj"
                            aria-valuenow="{{ $completedSteps }}" aria-valuemin="0" aria-valuemax="{{ $totalSteps }}">
                            <h5> {{ $completedSteps }}/{{ $totalSteps }} مكتمل</h5>
                        </div>
                    </div>
                    
                    <div id="cards-container">
                        @foreach ([
            'category' => [
                'icon' => 'layer-group',
                'title' => 'إنشاء القسم الأول',
                'text' => 'قم بإنشاء أول قسم لمتجرك.',
                'route' => route('category.create.view', $store->id),
            ],
            'product' => [
                'icon' => 'box-open',
                'title' => 'إضافة منتج',
                'text' => 'قم بإنشاء أول منتج لمتجرك.',
                'route' => route('product.create.view', $store->id),
            ],
            'support' => [
                'icon' => 'headset',
                'title' => 'الدعم الفني ونبذة عن المتجر',
                'text' => 'قم بإعداد صفحة الدعم الفني وإضافة نبذة عن متجرك لتعزيز ثقة عملائك و لتوفير المعلومات والدعم لعملائك.',
                'route' => route('support.create.view', $store->id),
            ],
            'conditions' => [
                'icon' => 'file-contract',
                'title' => 'سياسات و شروط واحكام متجرك',
                'text' => 'قم بإنشاء صفحات الشروط والأحكام لتعزيز الثقة والشفافية.',
                'route' => route('conditions.create.view',$store->id), 
            ],
        ] as $step => $data)
                            <div id="card-{{ $step }}"
                                class="step-card card shadow-sm border-0 rounded-lg text-center p-4" style="display: none;">
                               <i class="fas fa-{{ $data['icon'] }}" id="icons"></i>


                                <h5 class="mt-3 font-weight-bold">{{ $data['title'] }}</h5>
                                <p class="text-muted">{{ $data['text'] }}</p>
                                <a href="{{ $data['route'] }}"  class="btn rounded-pill menuu">متابعة</a>
                            </div>
                        @endforeach
                        {{-- <div class="card shadow-sm border-0 rounded-lg text-center p-4" style="background-color: #ffffff;">
                            <!-- أيقونة الصاروخ -->
                            <div class="mb-3">
                                <!-- استبدل مسار الصورة أدناه بمسار أيقونة الصاروخ لديك -->
                                <img src="path/to/rocket-icon.png" alt="Rocket Icon" style="width: 60px;">
                            </div>
                        
                            <!-- عنوان فرعي -->
                            <h5 class="font-weight-bold mb-2" style="color: #444444;">متجرك لم يتم إطلاقه بعد</h5>
                        
                            <!-- نص توضيحي -->
                            <p class="text-muted mb-4" style="line-height: 1.7;">
                                قم بترقية المتجر، وضاعف أرباحك ومبيعاتك الآن
                            </p>
                        
                            <!-- زر الإطلاق -->
                            <a href="{{ route('subscribe') }}"
                               class="btn btn-warning btn-lg rounded-pill font-weight-bold px-4">
                               إطلاق المتجر
                            </a>
                        </div>
                         --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        window.nextStep = "{{ $nextStep }}";
    </script>
@endsection
