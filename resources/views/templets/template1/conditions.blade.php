@extends('layouts.template.master')
@section('content')
    <div class="policy-page mt-150 mb-150" dir="rtl" style="text-align: right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="policy-container shadow-lg p-4 p-md-5 rounded-4">
                        <!-- العنوان الرئيسي -->
                        <div class="text-center mb-5">
                            <h1 class="title-gradient d-inline-block px-4 py-2 rounded-pill mb-4">
                                @isset($store)
                                    سياسة وشروط متجر {{ $store->name }}
                                @else
                                    سياسة وشروط المتجر
                                @endisset
                            </h1>
                            <div class="section-divider"></div>
                        </div>

                        <div class="policy-grid">
                            @if (isset($store))
                                {{-- سياسة الاسترجاع --}}
                                @if ($store->return__policy)
                                    <div class="policy-card full-width">
                                        <div class="policy-card h-100">
                                            <div class="card-header">
                                                <i class="fas fa-exchange-alt"></i>
                                                <h4>سياسة الاسترجاع</h4>
                                            </div>
                                            <ul class="policy-list">
                                                {!! nl2br(e($store->return__policy)) !!}
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                {{-- سياسة الخصوصية --}}
                                @if ($store->privacy_policy)
                                    <div class="policy-card full-width">
                                        <div class="card-header">
                                            <i class="fas fa-lock"></i>
                                            <h4>سياسة الخصوصية</h4>
                                        </div>
                                        <div class="policy-content">
                                            <ul class="policy-list">
                                                {!! nl2br(e($store->privacy_policy)) !!}
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                {{-- الشروط والأحكام --}}
                                @if ($store->terms_and_conditions)
                                    <div class="policy-card full-width">
                                        <div class="card-header">
                                            <i class="fas fa-file-contract"></i>
                                            <h4>الشروط والأحكام</h4>
                                        </div>
                                        <ul class="policy-list">
                                            {!! nl2br(e($store->terms_and_conditions)) !!}
                                        </ul>
                                    </div>
                                @endif
                            @else
                                {{-- المحتوى الافتراضي --}}

                                {{-- سياسة الاسترجاع الافتراضية --}}
                                <div class="policy-card h-100">
                                    <div class="card-header">
                                        <i class="fas fa-exchange-alt"></i>
                                        <h4>الاسترجاع</h4>
                                    </div>
                                    <ul class="policy-list">
                                        <li>يمكن للعميل إرجاع المنتج خلال 7 أيام من الاستلام، بشرط أن يكون بحالته الأصلية وغير مستخدم.</li>
                                        <li>يتحمل العميل رسوم الشحن عند الإرجاع، إلا في حال كان المنتج تالفًا أو مختلفًا عن المطلوب.</li>
                                        <li>تتم معالجة عمليات الاسترداد خلال 5-10 أيام عمل بعد استلام المنتج المرتجع.</li>
                                    </ul>
                                </div>

                                {{-- سياسة الخصوصية الافتراضية --}}
                                <div class="policy-card full-width">
                                    <div class="card-header">
                                        <i class="fas fa-lock"></i>
                                        <h4>الخصوصية وحماية البيانات</h4>
                                    </div>
                                    <div class="policy-content">
                                        <p>نحمي بياناتك الشخصية وفق أعلى المعايير الأمنية:</p>
                                        <ul class="policy-list">
                                            <li>عدم مشاركة البيانات مع أطراف ثالثة</li>
                                            <li>جمع البيانات لأغراض تحسين الخدمة</li>
                                            <li>حق طلب الحذف في أي وقت</li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- الشروط والأحكام الافتراضية --}}
                                <div class="policy-card full-width">
                                    <div class="card-header">
                                        <i class="fas fa-file-contract"></i>
                                        <h4>الشروط والأحكام</h4>
                                    </div>
                                    <div class="policy-content">
                                        <ul class="policy-list">
                                            <li>باستخدامك خدماتنا فإنك توافق على الشروط التالية:</li>
                                            <li>1. جميع المنتجات المعروضة ملكية فكرية حصرية للمتجر.</li>
                                            <li>2. يتحمل العميل مسؤولية توفير معلومات دقيقة أثناء الشراء.</li>
                                            <li>3. يحق للمتجر تعديل الأسعار أو الخدمات مع إشعار مسبق قبل 7 أيام.</li>
                                            <li>4. يتم حساب تواريخ التسليم وفقًا لأيام العمل الرسمية.</li>
                                            <li>5. يحق للمتجر تعليق الحسابات المخالفة دون إشعار مسبق.</li>
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <div class="policy-footer text-center">
                                <div class="acceptance-box p-4 rounded-3">
                                    <i class="fas fa-check-circle"></i>
                                    <ul class="policy-list">باستخدامك الموقع، فإنك توافق على جميع الشروط والأحكام المذكورة أعلاه</ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection