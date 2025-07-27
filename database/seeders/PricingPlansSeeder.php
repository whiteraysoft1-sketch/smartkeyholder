<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PricingPlan;

class PricingPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free Trial',
                'slug' => 'free-trial',
                'price' => 0.00,
                'billing_cycle' => 'month',
                'description' => 'Perfect for trying out our service with no commitment',
                'features' => [
                    'Custom QR Profile',
                    'Up to 3 Social Links',
                    'Photo Gallery (5 images)',
                    'Basic Analytics',
                    'Mobile Responsive',
                    '30-Day Free Access'
                ],
                'is_active' => true,
                'is_popular' => false,
                'is_free_trial' => true,
                'trial_days' => 30,
                'sort_order' => 1,
                'button_text' => 'Start Free Trial',
                'badge_text' => 'Free',
                'max_social_links' => 3,
                'max_gallery_images' => 5,
                'has_analytics' => true,
                'has_custom_themes' => false,
                'has_priority_support' => false,
                'has_qr_customization' => false,
                'has_whatsapp_store' => true,
            ],
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'price' => 9.99,
                'billing_cycle' => 'month',
                'description' => 'Great for individuals and small businesses',
                'features' => [
                    'Custom QR Profile',
                    'Unlimited Social Links',
                    'Photo Gallery (15 images)',
                    'Basic Analytics',
                    'Mobile Responsive',
                    'Email Support'
                ],
                'is_active' => true,
                'is_popular' => false,
                'is_free_trial' => false,
                'trial_days' => 0,
                'sort_order' => 2,
                'button_text' => 'Choose Basic',
                'badge_text' => null,
                'max_social_links' => -1,
                'max_gallery_images' => 15,
                'has_analytics' => true,
                'has_custom_themes' => false,
                'has_priority_support' => false,
                'has_qr_customization' => false,
                'has_whatsapp_store' => false,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'price' => 19.99,
                'billing_cycle' => 'month',
                'description' => 'Perfect for growing businesses and professionals',
                'features' => [
                    'Everything in Basic',
                    'Unlimited Gallery Images',
                    'Advanced Analytics',
                    'Custom Themes',
                    'Priority Support',
                    'QR Code Customization',
                    'WhatsApp Store Integration'
                ],
                'is_active' => true,
                'is_popular' => true,
                'is_free_trial' => false,
                'trial_days' => 0,
                'sort_order' => 3,
                'button_text' => 'Choose Premium',
                'badge_text' => 'Most Popular',
                'max_social_links' => -1,
                'max_gallery_images' => -1,
                'has_analytics' => true,
                'has_custom_themes' => true,
                'has_priority_support' => true,
                'has_qr_customization' => true,
                'has_whatsapp_store' => true,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'price' => 49.99,
                'billing_cycle' => 'month',
                'description' => 'For large organizations with advanced needs',
                'features' => [
                    'Everything in Premium',
                    'White-label Solution',
                    'API Access',
                    'Custom Integrations',
                    'Dedicated Support',
                    'Advanced Security',
                    'Bulk QR Management',
                    'Team Collaboration'
                ],
                'is_active' => true,
                'is_popular' => false,
                'is_free_trial' => false,
                'trial_days' => 0,
                'sort_order' => 4,
                'button_text' => 'Contact Sales',
                'badge_text' => 'Enterprise',
                'max_social_links' => -1,
                'max_gallery_images' => -1,
                'has_analytics' => true,
                'has_custom_themes' => true,
                'has_priority_support' => true,
                'has_qr_customization' => true,
                'has_whatsapp_store' => true,
            ]
        ];

        foreach ($plans as $planData) {
            PricingPlan::updateOrCreate(
                ['slug' => $planData['slug']],
                $planData
            );
        }

        $this->command->info('Pricing plans seeded successfully!');
    }
}