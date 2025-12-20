<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing CMS pages first
        CmsPage::truncate();

        $pages = [
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => '## Privacy Policy

**Last Updated:** ' . date('F d, Y') . '

### Introduction

Welcome to Rubista. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.

### Information We Collect

We collect information that you provide directly to us, including:
- Name and contact information
- Payment information
- Shipping address
- Account credentials
- Product preferences and purchase history

### How We Use Your Information

We use the information we collect to:
- Process and fulfill your orders
- Communicate with you about your orders and our services
- Improve our website and customer experience
- Send you promotional communications (with your consent)
- Comply with legal obligations

### Data Security

We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.

### Your Rights

You have the right to:
- Access your personal information
- Correct inaccurate information
- Request deletion of your information
- Object to processing of your information
- Data portability

### Contact Us

If you have questions about this Privacy Policy, please contact us at info@rubista.com.',
                'status' => true,
                'meta_title' => 'Privacy Policy - Rubista',
                'meta_description' => 'Read our Privacy Policy to understand how Rubista collects, uses, and protects your personal information.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => '## Terms & Conditions

**Last Updated:** ' . date('F d, Y') . '

### Agreement to Terms

By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.

### Use License

Permission is granted to temporarily download one copy of the materials on Rubista\'s website for personal, non-commercial transitory viewing only.

### Disclaimer

The materials on Rubista\'s website are provided on an \'as is\' basis. Rubista makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties.

### Limitations

In no event shall Rubista or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on Rubista\'s website.

### Accuracy of Materials

The materials appearing on Rubista\'s website could include technical, typographical, or photographic errors. Rubista does not warrant that any of the materials on its website are accurate, complete, or current.

### Links

Rubista has not reviewed all of the sites linked to its website and is not responsible for the contents of any such linked site.

### Modifications

Rubista may revise these terms of service for its website at any time without notice. By using this website you are agreeing to be bound by the then current version of these terms of service.

### Contact Information

For questions regarding these Terms & Conditions, please contact us at info@rubista.com.',
                'status' => true,
                'meta_title' => 'Terms & Conditions - Rubista',
                'meta_description' => 'Read Rubista\'s Terms & Conditions to understand the rules and regulations for using our website and services.',
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'content' => '## Shipping Policy

**Last Updated:** ' . date('F d, Y') . '

### Shipping Methods

We offer various shipping methods to ensure your order reaches you safely and on time:
- Standard Shipping (5-7 business days)
- Express Shipping (2-3 business days)
- Overnight Shipping (Next business day)

### Shipping Costs

Shipping costs are calculated based on:
- Weight and dimensions of the package
- Shipping destination
- Selected shipping method

Shipping costs will be displayed at checkout before you complete your purchase.

### Processing Time

Orders are typically processed within 1-2 business days. During peak seasons, processing may take up to 3-4 business days.

### Shipping Destinations

We currently ship to locations within India. International shipping may be available for select products.

### Order Tracking

Once your order ships, you will receive a tracking number via email. You can use this number to track your package on our website or the carrier\'s website.

### Delivery Issues

If you experience any issues with delivery, please contact our customer service team immediately. We will work with the shipping carrier to resolve the issue.

### Contact Us

For questions about shipping, please contact us at info@rubista.com or call +91 90518 88500.',
                'status' => true,
                'meta_title' => 'Shipping Policy - Rubista',
                'meta_description' => 'Learn about Rubista\'s shipping methods, costs, processing times, and delivery information.',
            ],
            [
                'title' => 'Return Policy',
                'slug' => 'return-policy',
                'content' => '## Return Policy

**Last Updated:** ' . date('F d, Y') . '

### Return Eligibility

Items can be returned within 7 days of delivery, provided they are:
- Unused and in original condition
- In original packaging with all tags attached
- Accompanied by proof of purchase

### Non-Returnable Items

The following items cannot be returned:
- Perishable goods
- Customized or personalized items
- Items damaged by misuse
- Items without original packaging

### Return Process

1. Contact our customer service team to initiate a return
2. Receive a Return Authorization (RA) number
3. Package the item securely with the RA number
4. Ship the item back to our return address
5. Once received and inspected, we will process your refund

### Refund Processing

Refunds will be processed within 5-7 business days after we receive and inspect the returned item. The refund will be issued to the original payment method.

### Return Shipping

Return shipping costs are the responsibility of the customer unless the item is defective or incorrect.

### Exchanges

We currently do not offer direct exchanges. Please return the item and place a new order for the desired item.

### Contact Us

For return requests or questions, please contact us at info@rubista.com or call +91 90518 88500.',
                'status' => true,
                'meta_title' => 'Return Policy - Rubista',
                'meta_description' => 'Learn about Rubista\'s return policy, eligibility, process, and refund information.',
            ],
            [
                'title' => 'Cancellation Policy',
                'slug' => 'cancellation-policy',
                'content' => '## Cancellation Policy

**Last Updated:** ' . date('F d, Y') . '

### Order Cancellation

You can cancel your order at any time before it ships. Once an order has been shipped, it cannot be cancelled but can be returned according to our Return Policy.

### How to Cancel

To cancel an order:
1. Log into your account and go to "My Orders"
2. Select the order you wish to cancel
3. Click "Cancel Order"
4. Or contact our customer service team

### Cancellation Timeframe

- Orders can be cancelled within 24 hours of placement for immediate cancellation
- Orders that have entered processing may take 1-2 business days to cancel
- Once shipped, orders cannot be cancelled

### Refund for Cancelled Orders

If your order is successfully cancelled:
- Full refund will be processed within 5-7 business days
- Refund will be issued to the original payment method
- You will receive email confirmation once the refund is processed

### Partial Cancellation

If you wish to cancel only part of your order, please contact our customer service team. Partial cancellations are subject to approval.

### Contact Us

For cancellation requests or questions, please contact us at info@rubista.com or call +91 90518 88500.',
                'status' => true,
                'meta_title' => 'Cancellation Policy - Rubista',
                'meta_description' => 'Learn about Rubista\'s order cancellation policy, process, and refund information.',
            ],
            [
                'title' => 'Exchange Policy',
                'slug' => 'exchange-policy',
                'content' => '## Exchange Policy

**Last Updated:** ' . date('F d, Y') . '

### Exchange Eligibility

Items can be exchanged within 7 days of delivery, provided they are:
- Unused and in original condition
- In original packaging with all tags attached
- Accompanied by proof of purchase

### Exchange Process

1. Contact our customer service team to initiate an exchange
2. Receive an Exchange Authorization (EA) number
3. Package the item securely with the EA number
4. Ship the item back to our return address
5. Once received and inspected, we will ship the replacement item

### Exchange Options

You can exchange for:
- Different size (if available)
- Different color (if available)
- Different product (price difference will be adjusted)

### Exchange Shipping

- Return shipping for exchanges is the customer\'s responsibility
- We will ship the replacement item at no additional cost (standard shipping)
- Express shipping for replacement items can be arranged for an additional fee

### Price Difference

If the exchanged item has a different price:
- If higher: You will be charged the difference
- If lower: You will receive a refund for the difference

### Non-Exchangeable Items

The following items cannot be exchanged:
- Perishable goods
- Customized or personalized items
- Items damaged by misuse
- Items without original packaging

### Contact Us

For exchange requests or questions, please contact us at info@rubista.com or call +91 90518 88500.',
                'status' => true,
                'meta_title' => 'Exchange Policy - Rubista',
                'meta_description' => 'Learn about Rubista\'s exchange policy, eligibility, process, and options for exchanging products.',
            ],
        ];

        foreach ($pages as $pageData) {
            CmsPage::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
