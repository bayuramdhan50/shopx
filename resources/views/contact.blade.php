<x-layouts.main>
    <x-slot name="title">Contact Us</x-slot>

    <div class="bg-white">
        <!-- Hero Section -->
        <div class="relative bg-indigo-800">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80" alt="Customer service">
                <div class="absolute inset-0 bg-indigo-800 mix-blend-multiply" aria-hidden="true"></div>
            </div>
            <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">Contact Us</h1>
                <p class="mt-6 text-xl text-indigo-100 max-w-3xl">
                    We're here to help. Reach out to our team for support, feedback, or inquiries.
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16">
                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900">Get in Touch</h2>
                    <p class="mt-4 text-lg text-gray-500">
                        Have questions about our products, your order, or need technical support? 
                        Our team is ready to assist you with any inquiries you may have.
                    </p>
                    
                    <div class="mt-8 space-y-6">
                        <!-- Email -->
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3 text-base text-gray-500">
                                <p>support@shopx.com</p>
                                <p class="mt-1">For order inquiries, product questions, and support issues.</p>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="ml-3 text-base text-gray-500">
                                <p>+62 (21) 5678 9012</p>
                                <p class="mt-1">Available Monday-Friday, 9AM-6PM WIB</p>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-3 text-base text-gray-500">
                                <p>Jl. Sudirman No. 123</p>
                                <p>Jakarta Selatan, 12190</p>
                                <p>Indonesia</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media -->
                    <div class="mt-12">
                        <h3 class="text-xl font-bold text-gray-900">Connect With Us</h3>
                        <div class="mt-4 flex space-x-6">
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-gray-500">
                                <span class="sr-only">YouTube</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Business Hours -->
                    <div class="mt-12">
                        <h3 class="text-xl font-bold text-gray-900">Business Hours</h3>
                        <div class="mt-4 space-y-2">
                            <p class="text-base text-gray-500">
                                <span class="font-medium text-gray-900">Monday-Friday:</span> 9:00 AM - 6:00 PM WIB
                            </p>
                            <p class="text-base text-gray-500">
                                <span class="font-medium text-gray-900">Saturday:</span> 10:00 AM - 4:00 PM WIB
                            </p>
                            <p class="text-base text-gray-500">
                                <span class="font-medium text-gray-900">Sunday:</span> Closed
                            </p>
                        </div>
                        <p class="mt-4 text-sm text-gray-500">
                            *Customer service response times may vary during public holidays.
                        </p>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="mt-12 lg:mt-0 bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Send Us a Message</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Use the form below to send us a message and we'll get back to you as soon as possible.
                        </p>
                        
                        <form action="#" method="POST" class="mt-6 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                            <div class="sm:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <div class="mt-1">
                                    <input type="text" name="name" id="name" autocomplete="name" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Your full name">
                                </div>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <input id="email" name="email" type="email" autocomplete="email" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="you@example.com">
                                </div>
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <div class="mt-1">
                                    <input type="text" name="phone" id="phone" autocomplete="tel" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="Your phone number">
                                </div>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <div class="mt-1">
                                    <input type="text" name="subject" id="subject" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" placeholder="What is your message about?">
                                </div>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <div class="mt-1">
                                    <textarea id="message" name="message" rows="6" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border border-gray-300 rounded-md" placeholder="How can we help you?"></textarea>
                                </div>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <input id="privacy" name="privacy" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-500">
                                            By selecting this, you agree to our 
                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                                            and consent to us contacting you regarding your inquiry.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="sm:col-span-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- FAQ Section -->
            <div class="mt-16 sm:mt-20">
                <h2 class="text-3xl font-extrabold text-gray-900">Frequently Asked Questions</h2>
                <div class="mt-8 max-w-3xl">
                    <dl class="space-y-8">
                        <div>
                            <dt class="text-lg font-medium text-gray-900">
                                How can I track my order?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                You can track your order by logging into your account and visiting the Orders section. There, you'll find real-time updates on your order status.
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-lg font-medium text-gray-900">
                                What is your return policy?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                We offer a 14-day return policy for most products. Items must be in their original condition with all packaging and accessories. Please contact our customer service team to initiate a return.
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-lg font-medium text-gray-900">
                                Do you ship internationally?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                Currently, we only ship within Indonesia. We're working on expanding our shipping options to other countries in the future.
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-lg font-medium text-gray-900">
                                How long does shipping take?
                            </dt>
                            <dd class="mt-2 text-base text-gray-500">
                                Shipping times vary by location. Typically, orders within Jakarta are delivered within 1-2 business days, while orders to other regions in Indonesia may take 3-5 business days.
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Our Location</h2>
                <div class="h-96 w-full rounded-lg overflow-hidden shadow-lg">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2896401573697!2d106.8200438760837!3d-6.224838194961542!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3f193a942d7%3A0xbcf30cf3b0248c63!2sJl.%20Jend.%20Sudirman%2C%20Daerah%20Khusus%20Ibukota%20Jakarta!5e0!3m2!1sen!2sid!4v1654789123456!5m2!1sen!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
