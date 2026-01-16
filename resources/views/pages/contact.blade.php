<x-public-layout>
    @section('title', 'Contact Us')

    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <h1 class="fw-bold mb-4">Get in Touch</h1>
                    <p class="text-secondary mb-5">Have questions or need assistance? Our team is here to help you get the most out of our platform.</p>
                    
                    <div class="d-flex mb-4">
                        <div class="bg-primary text-white p-3 rounded-circle me-3 flex-shrink-0" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                <path d="M12.166 8.94c-.524 1.062-1.235 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z"/>
                                <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Office Address</h5>
                            <p class="text-secondary small">123 Business Way, Suite 456, New York, NY 10001</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="bg-primary text-white p-3 rounded-circle me-3 flex-shrink-0" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.105V5.383zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">Email Support</h5>
                            <p class="text-secondary small">support@example.com</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    {{-- Alert Messages --}}
                    @if(session('success'))
                        <div class="alert alert-success shadow-sm border-0 mb-4 animate__animated animate__fadeIn">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm p-4">
                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label small fw-bold">First Name</label>
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="John" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label small fw-bold">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Doe" required>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label small fw-bold">Email Address</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" required>
                                </div>
                                <div class="col-12">
                                    <label for="subject" class="form-label small fw-bold">Subject</label>
                                    <input type="text" id="subject" name="subject" class="form-control" placeholder="How can we help?" required>
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label small fw-bold">Message</label>
                                    <textarea id="message" name="message" class="form-control" rows="5" placeholder="Tell us more about your inquiry..." required></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary w-100 py-2">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
