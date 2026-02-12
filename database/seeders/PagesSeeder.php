<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siteName = 'InsuranceSell';
        $siteUrl = 'https://insurancesell.com';
        $contactEmail = 'contact@insurancesell.com';

        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'meta_title' => 'About Us - ' . $siteName,
                'meta_description' => 'Learn more about ' . $siteName . ', your trusted source for insurance information and financial guidance.',
                'content' => $this->getAboutContent($siteName, $siteUrl),
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'meta_title' => 'Contact Us - ' . $siteName,
                'meta_description' => 'Get in touch with ' . $siteName . '. We\'d love to hear from you.',
                'content' => $this->getContactContent($siteName, $contactEmail),
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'meta_title' => 'Privacy Policy - ' . $siteName,
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your personal information.',
                'content' => $this->getPrivacyContent($siteName, $siteUrl, $contactEmail),
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms',
                'meta_title' => 'Terms & Conditions - ' . $siteName,
                'meta_description' => 'Please read our terms and conditions carefully before using our website.',
                'content' => $this->getTermsContent($siteName, $siteUrl),
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'meta_title' => 'Disclaimer - ' . $siteName,
                'meta_description' => 'Important disclaimer about the information provided on ' . $siteName . '.',
                'content' => $this->getDisclaimerContent($siteName),
            ],
            [
                'title' => 'DMCA',
                'slug' => 'dmca',
                'meta_title' => 'DMCA Policy - ' . $siteName,
                'meta_description' => 'DMCA takedown policy for ' . $siteName . '. Report copyright infringement.',
                'content' => $this->getDmcaContent($siteName, $contactEmail),
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                array_merge($page, ['is_active' => true])
            );
        }
    }

    private function getAboutContent($siteName, $siteUrl): string
    {
        return <<<HTML
<h2>Welcome to {$siteName}</h2>
<p>At {$siteName}, we are dedicated to providing you with comprehensive, accurate, and up-to-date information about insurance products and financial planning. Our mission is to empower individuals and families to make informed decisions about their financial future.</p>

<h3>Our Mission</h3>
<p>We believe that everyone deserves access to quality insurance information. Our team of experienced writers and financial experts work tirelessly to break down complex insurance concepts into easy-to-understand articles. Whether you're looking for information about life insurance, health insurance, auto insurance, or any other type of coverage, we've got you covered.</p>

<h3>What We Offer</h3>
<p>Our platform provides a wealth of resources designed to help you navigate the often confusing world of insurance. From detailed guides on different types of coverage to tips on how to save money on your premiums, we cover it all. Our content is regularly updated to reflect the latest industry trends, regulatory changes, and consumer insights.</p>

<h3>Our Commitment</h3>
<p>We are committed to maintaining the highest standards of journalistic integrity. All our articles are thoroughly researched and fact-checked before publication. We do not accept payments or incentives from insurance companies to promote their products, ensuring that our recommendations remain unbiased and trustworthy.</p>

<h3>The Team Behind {$siteName}</h3>
<p>Our team consists of passionate individuals with diverse backgrounds in finance, insurance, and content creation. Together, we bring decades of combined experience to help you understand your insurance options better. We're not just writers – we're consumers too, and we understand the challenges you face when shopping for insurance.</p>

<h3>Your Trusted Resource</h3>
<p>Since our founding, we have helped thousands of readers make smarter insurance decisions. We take pride in being a trusted resource for families, individuals, and businesses looking to protect what matters most. Thank you for choosing {$siteName} as your go-to source for insurance information.</p>

<h3>Connect With Us</h3>
<p>We love hearing from our readers! If you have questions, suggestions, or feedback, please don't hesitate to reach out through our contact page. Your input helps us improve and provide even better content for our community.</p>
HTML;
    }

    private function getContactContent($siteName, $contactEmail): string
    {
        return <<<HTML
<h2>Get in Touch</h2>
<p>We'd love to hear from you! Whether you have a question about our content, need assistance finding specific information, or want to share your feedback, our team is here to help.</p>

<h3>How to Reach Us</h3>
<p>The best way to contact us is through the contact form below. We typically respond to all inquiries within 24-48 business hours. Please provide as much detail as possible so we can assist you effectively.</p>

<h3>Contact Information</h3>
<p><strong>Email:</strong> {$contactEmail}</p>
<p><strong>Response Time:</strong> 24-48 business hours</p>

<h3>Before You Contact Us</h3>
<p>Please check our FAQ section and existing articles, as you may find the answer to your question there. Our content library covers a wide range of insurance topics and is regularly updated with new information.</p>

<h3>Advertising & Partnerships</h3>
<p>For advertising inquiries, partnership opportunities, or press requests, please use the contact form and mention the nature of your inquiry in the subject line. Our team will direct your message to the appropriate department.</p>

<h3>Feedback Welcome</h3>
<p>Your feedback helps us improve! If you've found our content helpful or have suggestions for new topics we should cover, please let us know. We value input from our readers and use it to guide our content strategy.</p>

<h3>Report an Issue</h3>
<p>If you notice any errors in our content, broken links, or technical issues with our website, please report them using the contact form. We appreciate your help in maintaining the quality of our platform.</p>
HTML;
    }

    private function getPrivacyContent($siteName, $siteUrl, $contactEmail): string
    {
        return <<<HTML
<h2>Privacy Policy</h2>
<p><strong>Last Updated:</strong> January 2024</p>

<p>At {$siteName} ("{$siteUrl}"), we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website. Please read this privacy policy carefully.</p>

<h3>Information We Collect</h3>
<p>We may collect information about you in a variety of ways. The information we may collect on the Site includes:</p>

<h4>Personal Data</h4>
<p>Personally identifiable information, such as your name and email address, that you voluntarily give to us when you choose to participate in various activities related to the Site, such as subscribing to our newsletter or filling out a contact form.</p>

<h4>Derivative Data</h4>
<p>Information our servers automatically collect when you access the Site, such as your IP address, browser type, operating system, access times, and the pages you have viewed directly before and after accessing the Site.</p>

<h3>Use of Your Information</h3>
<p>Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you to:</p>
<ul>
<li>Create and manage your subscription or contact request</li>
<li>Email you regarding your inquiry or request</li>
<li>Deliver targeted advertising, newsletters, and other information regarding our website</li>
<li>Improve our website and services</li>
<li>Monitor and analyze usage and trends to improve your experience</li>
</ul>

<h3>Third-Party Advertising</h3>
<p>We may use third-party advertising companies to serve ads when you visit the Site. These companies may use information about your visits to this and other websites in order to provide advertisements about goods and services of interest to you. If you would like more information about this practice and to know your choices about not having this information used by these companies, please visit the Network Advertising Initiative.</p>

<h3>Google AdSense</h3>
<p>We use Google AdSense to publish ads on this site. When you view or click on an ad, a cookie may be set to help better provide advertisements that may be of interest to you on this and other websites. You may opt-out of the use of this cookie by visiting Google's Advertising and Privacy page.</p>

<h3>Cookies and Web Beacons</h3>
<p>We may use cookies, web beacons, tracking pixels, and other tracking technologies on the Site to help customize the Site and improve your experience. For more information on how we use cookies, please refer to our Cookie Policy.</p>

<h3>Security of Your Information</h3>
<p>We use administrative, technical, and physical security measures to help protect your personal information. While we have taken reasonable steps to secure the personal information you provide to us, please be aware that no security measures are perfect or impenetrable.</p>

<h3>Contact Us</h3>
<p>If you have questions or comments about this Privacy Policy, please contact us at: {$contactEmail}</p>
HTML;
    }

    private function getTermsContent($siteName, $siteUrl): string
    {
        return <<<HTML
<h2>Terms and Conditions</h2>
<p><strong>Last Updated:</strong> January 2024</p>

<h3>Agreement to Terms</h3>
<p>These Terms and Conditions constitute a legally binding agreement made between you and {$siteName}, concerning your access to and use of the {$siteUrl} website as well as any other media form connected to it.</p>

<p>You agree that by accessing the Site, you have read, understood, and agree to be bound by all of these Terms and Conditions. If you do not agree with all of these Terms and Conditions, then you are expressly prohibited from using the Site and must discontinue use immediately.</p>

<h3>Intellectual Property Rights</h3>
<p>Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site and their selection and arrangement are owned or controlled by us or licensed to us.</p>

<p>The content is provided on the Site "AS IS" for your information and personal use only. Except as expressly provided in these Terms and Conditions, no part of the Site and no content may be copied, reproduced, aggregated, republished, uploaded, posted, publicly displayed, encoded, translated, transmitted, distributed, sold, licensed, or otherwise exploited without our express prior written permission.</p>

<h3>User Representations</h3>
<p>By using the Site, you represent and warrant that:</p>
<ul>
<li>All information you submit will be true, accurate, current, and complete</li>
<li>You have the legal capacity to agree to and comply with these Terms and Conditions</li>
<li>You will not use the Site for any illegal or unauthorized purpose</li>
<li>Your use of the Site will not violate any applicable law or regulation</li>
</ul>

<h3>Prohibited Activities</h3>
<p>You may not access or use the Site for any purpose other than that for which we make the Site available. The Site may not be used in connection with any commercial endeavors except those specifically endorsed or approved by us.</p>

<h3>Limitation of Liability</h3>
<p>In no event will we or our directors, employees, or agents be liable to you or any third party for any direct, indirect, consequential, exemplary, incidental, special, or punitive damages arising from your use of the Site.</p>

<h3>Governing Law</h3>
<p>These Terms shall be governed by and defined following the laws applicable in your jurisdiction. {$siteName} and yourself irrevocably consent that the courts shall have exclusive jurisdiction to resolve any dispute which may arise in connection with these Terms.</p>

<h3>Changes to Terms</h3>
<p>We reserve the right, in our sole discretion, to make changes or modifications to these Terms and Conditions at any time and for any reason. We will alert you about any changes by updating the "Last Updated" date of these Terms and Conditions.</p>
HTML;
    }

    private function getDisclaimerContent($siteName): string
    {
        return <<<HTML
<h2>Disclaimer</h2>
<p><strong>Last Updated:</strong> January 2024</p>

<h3>General Information</h3>
<p>The information provided on {$siteName} is for general informational and educational purposes only. All information on the Site is provided in good faith; however, we make no representation or warranty of any kind, express or implied, regarding the accuracy, adequacy, validity, reliability, availability, or completeness of any information on the Site.</p>

<h3>Not Professional Advice</h3>
<p><strong>IMPORTANT:</strong> The content on this website does not constitute professional financial, insurance, legal, or tax advice. You should consult with a qualified professional before making any financial decisions.</p>

<p>The information we provide is meant to help you understand insurance concepts and options better, but it should not replace personalized advice from licensed professionals who understand your specific situation, needs, and goals.</p>

<h3>No Insurance Agent Relationship</h3>
<p>{$siteName} is not an insurance company, broker, or agent. We do not sell insurance policies or provide insurance quotes. Any links to insurance companies or products are provided for informational purposes only and do not constitute an endorsement.</p>

<h3>Accuracy of Information</h3>
<p>While we strive to keep the information on this Site accurate and up-to-date, insurance products, regulations, and market conditions change frequently. We make no guarantees that the information presented is current or applicable to your specific circumstances.</p>

<h3>Third-Party Links</h3>
<p>The Site may contain links to third-party websites or content. These links are provided solely as a convenience to you. We do not endorse and are not responsible for the content of third-party websites.</p>

<h3>Limitation of Liability</h3>
<p>Under no circumstances shall {$siteName} or its owners, operators, employees, or affiliates be liable for any direct, indirect, incidental, consequential, special, or exemplary damages arising out of or in connection with your access to or use of the Site or any information contained herein.</p>

<h3>Investment and Financial Decisions</h3>
<p>Any financial decisions you make based on information found on this Site are made at your own risk. Past performance of any insurance product or investment is not indicative of future results.</p>

<h3>Updates to This Disclaimer</h3>
<p>We reserve the right to modify this disclaimer at any time. Changes will be effective immediately upon posting to the Site.</p>

<h3>Contact</h3>
<p>If you have any questions about this Disclaimer, please contact us through our Contact page.</p>
HTML;
    }

    private function getDmcaContent($siteName, $contactEmail): string
    {
        return <<<HTML
<h2>DMCA Policy</h2>
<p><strong>Last Updated:</strong> January 2024</p>

<h3>Digital Millennium Copyright Act Notice</h3>
<p>{$siteName} respects the intellectual property rights of others and expects its users to do the same. In accordance with the Digital Millennium Copyright Act of 1998 ("DMCA"), we will respond expeditiously to claims of copyright infringement committed using our website.</p>

<h3>Notification of Claimed Infringement</h3>
<p>If you believe that your copyrighted work has been copied in a way that constitutes copyright infringement and is accessible via our website, please notify our copyright agent as set forth in the DMCA. For your complaint to be valid under the DMCA, you must provide the following information in writing:</p>

<ol>
<li>An electronic or physical signature of a person authorized to act on behalf of the copyright owner</li>
<li>Identification of the copyrighted work that you claim has been infringed</li>
<li>Identification of the material that is claimed to be infringing and where it is located on the Service</li>
<li>Information reasonably sufficient to permit us to contact you, such as your address, telephone number, and email address</li>
<li>A statement that you have a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or law</li>
<li>A statement made under penalty of perjury that the above information is accurate, and that you are the copyright owner or are authorized to act on behalf of the owner</li>
</ol>

<h3>Contact Information</h3>
<p>To submit a DMCA notice or counter-notification, please contact us at:</p>
<p><strong>Email:</strong> {$contactEmail}<br>
<strong>Subject Line:</strong> DMCA Notice</p>

<h3>Counter-Notification</h3>
<p>If you believe that your content that was removed (or to which access was disabled) is not infringing, or that you have authorization from the copyright owner, the copyright owner's agent, or pursuant to the law, to post and use the content, you may send a counter-notification.</p>

<h3>Repeat Infringer Policy</h3>
<p>In accordance with the DMCA and other applicable law, we have adopted a policy of terminating, in appropriate circumstances, users who are deemed to be repeat infringers. We may also, at our sole discretion, limit access to our website and/or terminate the accounts of any users who infringe any intellectual property rights of others.</p>

<h3>Good Faith</h3>
<p>We handle all DMCA notices in good faith and aim to resolve issues promptly. If you believe your content was wrongly removed, please follow the counter-notification process described above.</p>
HTML;
    }
}
