<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('fulfillment_type')->default('pickup'); // 'pickup' / 'delivery'
            $table->string('pickup_location')->nullable();
            $table->string('pickup_date_time')->nullable();
            $table->text('delivery_address')->nullable();
            $table->string('delivery_courier')->nullable();
            $table->decimal('shipping_fee', 12, 2)->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);
            $table->string('payment_method')->default('Transfer Bank BCA');
            $table->string('payment_status')->default('Belum Lunas'); // 'Belum Lunas', 'Menunggu Verifikasi', 'Lunas'
            $table->string('order_status')->default('Pending'); // 'Pending', 'Diproses', 'Sedang Dikirim', 'Selesai', 'Dibatalkan'
            $table->text('payment_proof')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
