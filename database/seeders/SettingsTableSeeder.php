<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'app_name',
                'value' => 'Tunturu Library',
                'group' => 'general',
                'type' => 'text',
                'description' => 'Application Name',
            ],
            [
                'key' => 'app_logo',
                'value' => null,
                'group' => 'general',
                'type' => 'file',
                'description' => 'Application Logo',
            ],

            // Rental Rules
            [
                'key' => 'rental_duration_days',
                'value' => '14',
                'group' => 'rental',
                'type' => 'number',
                'description' => 'Default rental duration in days',
            ],
            [
                'key' => 'max_books_per_user',
                'value' => '3',
                'group' => 'rental',
                'type' => 'number',
                'description' => 'Maximum books a user can rent simultaneously',
            ],
            [
                'key' => 'late_fee_per_day',
                'value' => '10',
                'group' => 'rental',
                'type' => 'number',
                'description' => 'Late fee per day (in currency)',
            ],

            // Payment Gateway (Razorpay)
            [
                'key' => 'razorpay_enabled',
                'value' => '0',
                'group' => 'payment',
                'type' => 'boolean',
                'description' => 'Enable Razorpay Payment Gateway',
            ],
            [
                'key' => 'razorpay_key_id',
                'value' => '',
                'group' => 'payment',
                'type' => 'text',
                'description' => 'Razorpay Key ID',
            ],
            [
                'key' => 'razorpay_key_secret',
                'value' => '',
                'group' => 'payment',
                'type' => 'text',
                'description' => 'Razorpay Key Secret',
            ],

            // SEO Settings
            [
                'key' => 'seo_meta_title',
                'value' => 'Tunturu Library - Your Digital Bookshelf',
                'group' => 'seo',
                'type' => 'text',
                'description' => 'Default Meta Title',
            ],
            [
                'key' => 'seo_meta_description',
                'value' => 'Discover a world of books with Tunturu Library. Rent, buy, and manage your reading collection online.',
                'group' => 'seo',
                'type' => 'textarea',
                'description' => 'Default Meta Description',
            ],
            [
                'key' => 'seo_meta_keywords',
                'value' => 'library, books, rental, reading, tunturu, digital library',
                'group' => 'seo',
                'type' => 'textarea',
                'description' => 'Default Meta Keywords',
            ],

            // Email Configuration
            [
                'key' => 'email_logo',
                'value' => null,
                'group' => 'email',
                'type' => 'file',
                'description' => 'Email Header Logo (Image)',
            ],
            [
                'key' => 'email_header_color',
                'value' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Email Header Background (CSS or Color hex)',
            ],
            [
                'key' => 'email_footer_text',
                'value' => 'This is an automated email. Please do not reply to this message.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Email Custom Footer Text',
            ],
            [
                'key' => 'email_footer_copyright',
                'value' => '© {year} Library Management System. All rights reserved.',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Email Footer Copyright Text',
            ],
            [
                'key' => 'email_otp_subject',
                'value' => 'Your Registration OTP',
                'group' => 'email',
                'type' => 'text',
                'description' => 'User Registration OTP Subject',
            ],
            [
                'key' => 'email_otp_content',
                'value' => 'Your One-Time Password for registration is: {otp}. It is valid for 10 minutes.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'User Registration OTP Content. Use {otp}.',
            ],
            // Sales Payment
            [
                'key' => 'email_sale_payment_completed_subject',
                'value' => 'Payment Completed - Your order has been placed!',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Payment Completed Subject',
            ],
            [
                'key' => 'email_sale_payment_completed_content',
                'value' => 'Thank you for your order! Your payment for order #{order_id} has been received successfully.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Payment Completed Content. Use {order_id}.',
            ],
            [
                'key' => 'email_sale_payment_refunded_subject',
                'value' => 'Payment Refunded - Order Update',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Payment Refunded Subject',
            ],
            [
                'key' => 'email_sale_payment_refunded_content',
                'value' => 'The payment for your order #{order_id} has been refunded to your wallet or original payment method.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Payment Refunded Content. Use {order_id}.',
            ],
            [
                'key' => 'email_sale_payment_pending_subject',
                'value' => 'Payment Pending - Action Required',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Payment Pending Subject',
            ],
            [
                'key' => 'email_sale_payment_pending_content',
                'value' => 'We are awaiting payment for your order #{order_id}. Please complete the payment to process your order.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Payment Pending Content. Use {order_id}.',
            ],
            // Sales Delivery
            [
                'key' => 'email_sale_delivery_pending_subject',
                'value' => 'Delivery Pending - Order Update',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Delivery Pending Subject',
            ],
            [
                'key' => 'email_sale_delivery_pending_content',
                'value' => 'We are processing your order #{order_id} for delivery.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Delivery Pending Content. Use {order_id}.',
            ],
            [
                'key' => 'email_sale_delivery_dispatched_subject',
                'value' => 'Order Dispatched - On its way!',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Delivery Dispatched Subject',
            ],
            [
                'key' => 'email_sale_delivery_dispatched_content',
                'value' => 'Great news! Your order #{order_id} has been dispatched and is on its way to you.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Delivery Dispatched Content. Use {order_id}.',
            ],
            [
                'key' => 'email_sale_delivery_on_the_way_subject',
                'value' => 'Order On the Way',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Delivery On the way Subject',
            ],
            [
                'key' => 'email_sale_delivery_on_the_way_content',
                'value' => 'Your order #{order_id} is currently on its way to your destination.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Delivery On the way Content. Use {order_id}.',
            ],
            [
                'key' => 'email_sale_delivery_delivered_subject',
                'value' => 'Order Delivered successfully!',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Delivery Delivered Subject',
            ],
            [
                'key' => 'email_sale_delivery_delivered_content',
                'value' => 'Success! Your order #{order_id} has been delivered. We hope you enjoy reading it.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Delivery Delivered Content. Use {order_id}.',
            ],
            [
                'key' => 'email_sale_delivery_cancelled_subject',
                'value' => 'Order Cancelled',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Sales: Delivery Cancelled Subject',
            ],
            [
                'key' => 'email_sale_delivery_cancelled_content',
                'value' => 'We are sorry to inform you that the delivery for your order #{order_id} has been cancelled.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Sales: Delivery Cancelled Content. Use {order_id}.',
            ],

            // Rental Payment
            [
                'key' => 'email_rental_payment_paid_subject',
                'value' => 'Rental Payment Successful',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Payment Paid Subject',
            ],
            [
                'key' => 'email_rental_payment_paid_content',
                'value' => 'Your payment for rental #{rental_id} was successful!',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Payment Paid Content. Use {rental_id}.',
            ],
            [
                'key' => 'email_rental_payment_pending_subject',
                'value' => 'Rental Payment Pending',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Payment Pending Subject',
            ],
            [
                'key' => 'email_rental_payment_pending_content',
                'value' => 'Your payment for rental #{rental_id} is currently pending.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Payment Pending Content. Use {rental_id}.',
            ],
            [
                'key' => 'email_rental_payment_failed_subject',
                'value' => 'Rental Payment Failed',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Payment Failed Subject',
            ],
            [
                'key' => 'email_rental_payment_failed_content',
                'value' => 'Unfortunately, your payment for rental #{rental_id} has failed. Please try again.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Payment Failed Content. Use {rental_id}.',
            ],

            // Rental Delivery
            [
                'key' => 'email_rental_delivery_pending_subject',
                'value' => 'Rental Pending Processing',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Delivery Pending Subject',
            ],
            [
                'key' => 'email_rental_delivery_pending_content',
                'value' => 'Your rental request #{rental_id} is pending and being processed.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Delivery Pending Content. Use {rental_id}.',
            ],
            [
                'key' => 'email_rental_delivery_dispatched_subject',
                'value' => 'Rental Dispatched',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Delivery Dispatched Subject',
            ],
            [
                'key' => 'email_rental_delivery_dispatched_content',
                'value' => 'Your rental book (ID: #{rental_id}) has been dispatched.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Delivery Dispatched Content. Use {rental_id}.',
            ],
            [
                'key' => 'email_rental_delivery_on_the_way_subject',
                'value' => 'Rental On the Way',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Delivery On the way Subject',
            ],
            [
                'key' => 'email_rental_delivery_on_the_way_content',
                'value' => 'The book for your rental #{rental_id} is on its way to you.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Delivery On the way Content. Use {rental_id}.',
            ],
            [
                'key' => 'email_rental_delivery_delivered_subject',
                'value' => 'Rental Delivered',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Delivery Delivered Subject',
            ],
            [
                'key' => 'email_rental_delivery_delivered_content',
                'value' => 'Hope you enjoy reading! Your rental #{rental_id} has been successfully delivered.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Delivery Delivered Content. Use {rental_id}.',
            ],
            [
                'key' => 'email_rental_delivery_cancelled_subject',
                'value' => 'Rental Cancelled',
                'group' => 'email',
                'type' => 'text',
                'description' => 'Rentals: Delivery Cancelled Subject',
            ],
            [
                'key' => 'email_rental_delivery_cancelled_content',
                'value' => 'Your rental request #{rental_id} has been cancelled.',
                'group' => 'email',
                'type' => 'textarea',
                'description' => 'Rentals: Delivery Cancelled Content. Use {rental_id}.',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
