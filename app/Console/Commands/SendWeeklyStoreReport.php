<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;
use App\Models\User;
use Twilio\Rest\Client;
use Barryvdh\DomPDF\Facade\Pdf; // إضافة لاستخدام DomPDF لتوليد PDF

class SendWeeklyStoreReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:weekly-store-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate weekly report for active and inactive stores and send to manager via WhatsApp';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $stores = Store::with('owner')->get();

        // توليد التقرير على شكل PDF
        $pdf = Pdf::loadView('reports.stores_weekly', ['stores' => $stores]);
        // مسار حفظ الملف
        $pdfPath = storage_path('app/public/store_report.pdf');

        // حفظ التقرير
        file_put_contents($pdfPath, $pdf->output());

        // إعدادات Twilio
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_WHATSAPP_FROM');
        $to = env('MANAGER_PHONE');

        // إنشاء عميل Twilio
        $client = new Client($sid, $token);

        // رابط الملف
        $publicUrl = "http://127.0.0.1:8000/report";

        // إرسال التقرير عبر واتساب
        try {
            $client->messages->create($to, [
                'from' => $from,
                'body' => "تم توليد تقرير المتاجر الأسبوعي. يمكنك عرضة من الرابط التالي:\n\n   " .
                    $publicUrl . "\n\n  اضغط على الرابط لعر التقرير التقرير.",
            ]);

            return "تم إرسال التقرير بنجاح";
        } catch (\Exception $e) {
            return "حدث خطأ: " . $e->getMessage();
        }
    }
}
