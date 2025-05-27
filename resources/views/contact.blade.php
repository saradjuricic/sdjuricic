@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1>Contact Us</h1>
            <p class="lead">Get in touch with Blossom Boutique</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Contact Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3><i class="fas fa-store text-primary"></i> Store Information</h3>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-map-marker-alt text-danger"></i> Address</h5>
                            <p>
                                123 Flower Street<br>
                                Garden District<br>
                                Belgrade, Serbia 11000
                            </p>

                            <h5><i class="fas fa-phone text-success"></i> Phone</h5>
                            <p><a href="tel:+381112345678">+381 11 234-5678</a></p>

                            <h5><i class="fas fa-envelope text-info"></i> Email</h5>
                            <p><a href="mailto:info@blossomboutique.rs">info@blossomboutique.rs</a></p>
                        </div>
                        
                        <div class="col-md-6">
                            <h5><i class="fas fa-clock text-warning"></i> Business Hours</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Monday - Friday:</strong></td>
                                    <td>9:00 AM - 7:00 PM</td>
                                </tr>
                                <tr>
                                    <td><strong>Saturday:</strong></td>
                                    <td>9:00 AM - 6:00 PM</td>
                                </tr>
                                <tr>
                                    <td><strong>Sunday:</strong></td>
                                    <td>10:00 AM - 5:00 PM</td>
                                </tr>
                                <tr>
                                    <td><strong>Holidays:</strong></td>
                                    <td>Closed</td>
                                </tr>
                            </table>

                            <div class="alert alert-info mt-3">
                                <small>
                                    <i class="fas fa-info-circle"></i>
                                    <strong>Special Services:</strong><br>
                                    • Same-day delivery available<br>
                                    • Wedding consultation by appointment<br>
                                    • Custom arrangements available
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3><i class="fas fa-envelope text-primary"></i> Send us a Message</h3>
                    <hr>
                    
                    <form action="#" method="POST" id="contactForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Your Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Your Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject <span class="text-danger">*</span></label>
                            <select class="form-control" id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="order">Order Question</option>
                                <option value="wedding">Wedding Consultation</option>
                                <option value="delivery">Delivery Information</option>
                                <option value="complaint">Complaint</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="message" name="message" rows="5" 
                                      placeholder="Tell us how we can help you..." required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Map and Quick Info -->
        <div class="col-lg-4">
            <!-- Google Map -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5><i class="fas fa-map text-primary"></i> Find Us</h5>
                    <div class="embed-responsive embed-responsive-4by3">
                        <iframe class="embed-responsive-item" 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2830.0745763649054!2d20.4608516!3d44.8125449!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x475a7aa3d7b3a1a1%3A0x6898ac70e041c2b9!2sBelgrade%2C%20Serbia!5e0!3m2!1sen!2sus!4v1634567890123!5m2!1sen!2sus"
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="fas fa-parking"></i> Free parking available behind the store
                    </small>
                </div>
            </div>

            <!-- Quick Contact -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5><i class="fas fa-phone-alt text-primary"></i> Quick Contact</h5>
                    <p class="mb-1">Need immediate assistance?</p>
                    <a href="tel:+381112345678" class="btn btn-success btn-block">
                        <i class="fas fa-phone"></i> Call Now
                    </a>
                    <a href="mailto:info@blossomboutique.rs" class="btn btn-outline-primary btn-block">
                        <i class="fas fa-envelope"></i> Email Us
                    </a>
                </div>
            </div>

            <!-- Social Media -->
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5><i class="fas fa-share-alt text-primary"></i> Follow Us</h5>
                    <div class="row">
                        <div class="col-4">
                            <a href="#" class="btn btn-outline-primary btn-sm btn-block">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="#" class="btn btn-outline-info btn-sm btn-block">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="#" class="btn btn-outline-success btn-sm btn-block">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Simple form handling 
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Thank you for your message! We\'ll get back to you within 24 hours.\n\n');
    this.reset();
});
</script>
@endsection