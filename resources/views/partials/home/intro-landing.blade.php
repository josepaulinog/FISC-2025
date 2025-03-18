

<x-content-section
  bgClass=""
  imageUrl="https://fisc.freebalance.com/wp-content/uploads/2025/03/pic2.svg"
  imageAlt="Illustration of FreeBalance Partner Portal"
  imagePosition="vectorRight"
  title="Welcome to the FISC 2025 Event Portal"
  paragraph1="This portal is designed exclusively for event participants attending FISC 2025. Here, you can:"
  :items="[
    'Access the event agenda and session details.',
    'Watch recorded sessions after the event.',
    'Download presentations, reports, and materials.',
    'Connect with fellow attendees and speakers.'
  ]">
</x-content-section>

<x-content-section
  bgClass="bg-base-200"
  imageUrl="https://freebalance.com/wp-content/uploads/2021/06/FISC-2019_Day-02_A013.jpg"
  imageAlt="Illustration of FreeBalance Partner Portal"
  imagePosition="left"
  title="About FISC"
  paragraph1="The FreeBalance International Steering Committee (FISC) is an annual interactive forum where government leaders, finance professionals, and technology innovators collaborate on Public Financial Management (PFM) best practices. The event includes:"
  :items="[
    'Expert keynotes & panel discussions.',
    'Workshops on digital finance transformation.',
    'Case studies from FISC member governments.',
    'Hands-on training sessions.'
  ]">
</x-content-section>


<!-- FAQs Section -->
@php
$faqItems = [
[
'question' => 'What is FISC 2025?',
'answer' => 'FISC is a premier global forum where government leaders, policymakers, and public financial management (PFM) experts collaborate to shape the future of public finance, governance, and digital transformation. Since its inception in 2007, FISC has provided FreeBalance customers with an exclusive opportunity to exchange knowledge, explore good practices, and directly influence the FreeBalance product and services roadmap through discussion with FreeBalance decision-makers.'
],
[
'question' => 'Who can attend FISC 2025?',
'answer' => 'FISC 2025 is an exclusive, invitation-only event for FreeBalance customers and official guests, including government officials, finance professionals, and technology innovators.'
],
[
'question' => 'Where will FISC 2025 be held?',
'answer' => 'FISC 2025 will be held at the Palm Springs Hotel in Dili, Timor-Leste.'
],
[
'question' => 'How does FISC contribute to global PFM practices?',
'answer' => 'FISC is a customer-driven steering committee that plays a direct role in shaping the future of FreeBalance. No other software vendor conference provides this level of engagement and influence. And there is no selling at FISC: just focused, strategic engagement on what matters most to customers.'
],
[
'question' => 'What is the agenda for FISC 2025?',
'answer' => 'The agenda includes keynote speeches, panel discussions, workshops, and networking sessions focused on public financial management, digital transformation, and governance transparency. A detailed schedule will be shared closer to the event.'
],
];
@endphp

<x-faqs
  title="Frequently Asked Questions"
  subtitle="Find answers to common questions about FISC 2025."
  bgClass="bg-base-100"
  :faqs="$faqItems" />