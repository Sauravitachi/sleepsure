@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Privacy Policy</h1>
            <p class="page-subtitle">Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.</p>
        </div>

        <!-- Last Updated -->
        <div class="last-updated">
            Last updated: October 15, 2023
        </div>

        <!-- Privacy Container -->
        <div class="privacy-container">
            <!-- Summary Box -->
            <div class="summary-box">
                <h3>Policy Summary</h3>
                <ul class="summary-list">
                    <li>We collect information to provide and improve our services</li>
                    <li>We do not sell your personal data to third parties</li>
                    <li>You have rights to access, correct, or delete your information</li>
                    <li>We implement security measures to protect your data</li>
                    <li>We use cookies to enhance your browsing experience</li>
                </ul>
            </div>

            <!-- Privacy Content -->
            <div class="privacy-section">
                <h2 class="privacy-section-title">1. Information We Collect</h2>
                <div class="privacy-section-content">
                    <p>We collect several types of information from and about users of our website, including:</p>
                    
                    <h4>Personal Information</h4>
                    <p>When you create an account, place an order, or contact us, we may collect personal information such as:</p>
                    <ul class="privacy-list">
                        <li>Name, email address, and phone number</li>
                        <li>Billing and shipping addresses</li>
                        <li>Payment information (processed securely by our payment partners)</li>
                        <li>Purchase history and preferences</li>
                    </ul>
                    
                    <h4>Automatically Collected Information</h4>
                    <p>When you visit our website, we automatically collect certain information about your device and browsing activities:</p>
                    <ul class="privacy-list">
                        <li>IP address and location data</li>
                        <li>Browser type and version</li>
                        <li>Pages you view and links you click</li>
                        <li>Date and time of your visit</li>
                    </ul>
                    
                    <div class="highlight">
                        <p><strong>Note:</strong> We do not knowingly collect personal information from children under 16 without parental consent. If you believe we have collected information from a child under 16, please contact us immediately.</p>
                    </div>
                </div>
            </div>

            <div class="privacy-section">
                <h2 class="privacy-section-title">2. How We Use Your Information</h2>
                <div class="privacy-section-content">
                    <p>We use the information we collect for various purposes, including:</p>
                    
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Purpose</th>
                                <th>Description</th>
                                <th>Legal Basis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Order Processing</td>
                                <td>To process and fulfill your purchases, including payment processing and shipping</td>
                                <td>Contractual necessity</td>
                            </tr>
                            <tr>
                                <td>Customer Service</td>
                                <td>To respond to your inquiries and provide support</td>
                                <td>Legitimate interest</td>
                            </tr>
                            <tr>
                                <td>Personalization</td>
                                <td>To customize your experience and show relevant products</td>
                                <td>Legitimate interest</td>
                            </tr>
                            <tr>
                                <td>Marketing</td>
                                <td>To send promotional communications (with your consent)</td>
                                <td>Consent</td>
                            </tr>
                            <tr>
                                <td>Analytics</td>
                                <td>To analyze and improve our website and services</td>
                                <td>Legitimate interest</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <p>We will only use your personal information for the purposes for which we collected it, unless we reasonably consider that we need to use it for another reason that is compatible with the original purpose.</p>
                </div>
            </div>

            <div class="privacy-section">
                <h2 class="privacy-section-title">3. Information Sharing and Disclosure</h2>
                <div class="privacy-section-content">
                    <p>We may share your personal information in the following situations:</p>
                    
                    <h4>Service Providers</h4>
                    <p>We share information with third-party vendors who perform services on our behalf, such as:</p>
                    <ul class="privacy-list">
                        <li>Payment processors (Stripe, PayPal)</li>
                        <li>Shipping carriers (UPS, FedEx, USPS)</li>
                        <li>Email marketing platforms</li>
                        <li>Analytics providers</li>
                    </ul>
                    
                    <h4>Legal Requirements</h4>
                    <p>We may disclose your information where required to do so by law or in response to valid requests by public authorities (e.g., a court or government agency).</p>
                    
                    <h4>Business Transfers</h4>
                    <p>If SleepSure is involved in a merger, acquisition, or asset sale, your personal information may be transferred. We will provide notice before your personal information is transferred and becomes subject to a different privacy policy.</p>
                    
                    <div class="highlight">
                        <p><strong>Important:</strong> We do not sell, trade, or otherwise transfer your personally identifiable information to outside parties for their marketing purposes without your explicit consent.</p>
                    </div>
                </div>
            </div>

            <div class="privacy-section">
                <h2 class="privacy-section-title">4. Cookies and Tracking Technologies</h2>
                <div class="privacy-section-content">
                    <p>We use cookies and similar tracking technologies to track activity on our website and hold certain information. Cookies are files with a small amount of data which may include an anonymous unique identifier.</p>
                    
                    <p>We use the following types of cookies:</p>
                    <ul class="privacy-list">
                        <li><strong>Essential Cookies:</strong> Necessary for the website to function properly</li>
                        <li><strong>Performance Cookies:</strong> Help us understand how visitors interact with our website</li>
                        <li><strong>Functionality Cookies:</strong> Allow the website to remember choices you make</li>
                        <li><strong>Targeting Cookies:</strong> Used to deliver ads relevant to you</li>
                    </ul>
                    
                    <p>You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent. However, if you do not accept cookies, you may not be able to use some portions of our website.</p>
                </div>
            </div>

            <div class="privacy-section">
                <h2 class="privacy-section-title">5. Data Security</h2>
                <div class="privacy-section-content">
                    <p>The security of your personal information is important to us. We implement appropriate technical and organizational security measures designed to protect your personal information from accidental or unlawful destruction, loss, alteration, unauthorized disclosure, or access.</p>
                    
                    <p>Some of the security measures we use include:</p>
                    <ul class="privacy-list">
                        <li>SSL encryption for data transmission</li>
                        <li>Regular security assessments and monitoring</li>
                        <li>Access controls and authentication procedures</li>
                        <li>Secure data storage with encryption at rest</li>
                    </ul>
                    
                    <p>While we strive to use commercially acceptable means to protect your personal information, no method of transmission over the Internet or method of electronic storage is 100% secure. Therefore, we cannot guarantee its absolute security.</p>
                </div>
            </div>

            <div class="privacy-section">
                <h2 class="privacy-section-title">6. Your Rights and Choices</h2>
                <div class="privacy-section-content">
                    <p>Depending on your location, you may have the following rights regarding your personal information:</p>
                    
                    <ul class="privacy-list">
                        <li><strong>Access:</strong> Request copies of your personal information</li>
                        <li><strong>Correction:</strong> Request correction of inaccurate or incomplete information</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                        <li><strong>Restriction:</strong> Request restriction of processing of your personal information</li>
                        <li><strong>Portability:</strong> Request transfer of your data to another organization</li>
                        <li><strong>Objection:</strong> Object to processing of your personal information</li>
                    </ul>
                    
                    <p>To exercise any of these rights, please contact us using the information provided in the "Contact Us" privacy-section. We will respond to your request within 30 days.</p>
                    
                    <p>You can also manage your communication preferences by:</p>
                    <ul class="privacy-list">
                        <li>Updating your account settings</li>
                        <li>Using the unsubscribe link in our marketing emails</li>
                        <li>Contacting our customer service team</li>
                    </ul>
                </div>
            </div>

            <div class="privacy-section">
                <h2 class="privacy-section-title">7. Data Retention</h2>
                <div class="privacy-section-content">
                    <p>We will retain your personal information only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use your information to the extent necessary to comply with our legal obligations, resolve disputes, and enforce our policies.</p>
                    
                    <p>Our retention periods are based on business needs and legal requirements. We typically retain personal information related to:</p>
                    <ul class="privacy-list">
                        <li>Active accounts: Until account deletion is requested</li>
                        <li>Purchase records: 7 years for tax and accounting purposes</li>
                        <li>Customer service inquiries: 3 years after resolution</li>
                        <li>Marketing preferences: Until consent is withdrawn</li>
                    </ul>
                </div>
            </div>
          
        </div>
    </div>

@endsection