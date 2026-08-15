<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title_en' => 'Accounting Service',
                'title_np' => 'लेखापढि सेवा',
                'description_en' => 'Professional bookkeeping and accounting support for property transactions and land-related documentation.',
                'description_np' => 'घर जग्गा कारोबार र कागजातसँग सम्बन्धित लेखा सेवा।',
                'icon' => 'calculator',
                'sort_order' => 1,
            ],
            [
                'title_en' => 'Land Survey',
                'title_np' => 'जग्गा नापजाँच',
                'description_en' => 'Accurate land measurement and boundary verification carried out by experienced surveyors.',
                'description_np' => 'अनुभवी सर्भेयरहरूद्वारा शुद्ध जग्गा नापजाँच तथा सीमाना छुट्याइने सेवा।',
                'icon' => 'ruler',
                'sort_order' => 2,
            ],
            [
                'title_en' => 'Land Plotting Service',
                'title_np' => 'जग्गा प्लटिङ्ग सेवा',
                'description_en' => 'Planning and subdividing land into organized plots, ready for development or resale.',
                'description_np' => 'जग्गालाई व्यवस्थित प्लटमा विभाजन गरी विकास वा पुन: बिक्रीको लागि तयार पार्ने सेवा।',
                'icon' => 'map',
                'sort_order' => 3,
            ],
            [
                'title_en' => 'Loan Service',
                'title_np' => 'ऋण सेवा',
                'description_en' => 'Guidance and coordination with banks and financial institutions to help you secure a home or land loan.',
                'description_np' => 'घर जग्गा कर्जाको लागि बैंक तथा वित्तीय संस्थासँग समन्वय र सहजीकरण।',
                'icon' => 'bank',
                'sort_order' => 4,
            ],
            [
                'title_en' => 'Map Design',
                'title_np' => 'नक्सा डिजाइन',
                'description_en' => 'Building and site map design services for approvals, construction, and municipal submissions.',
                'description_np' => 'नक्सापास, निर्माण र नगरपालिका पेश गर्नको लागि नक्सा डिजाइन सेवा।',
                'icon' => 'draft',
                'sort_order' => 5,
            ],
            [
                'title_en' => 'Buy / Sell House & Land',
                'title_np' => 'घर जग्गा किनबेच',
                'description_en' => 'End-to-end support to buy or sell houses, apartments, and land across the Kathmandu Valley.',
                'description_np' => 'काठमाडौं उपत्यकाभर घर, अपार्टमेन्ट र जग्गा किनबेचमा पूर्ण सहयोग।',
                'icon' => 'home',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['title_en' => $service['title_en']], $service);
        }
    }
}
