<footer id="contact" class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h3 class="footer-heading">Quick links</h3>
                <ul class="footer-links">
                    <li><a href="#" data-search-open>Search</a></li>
                    <li><a href="#">Shipping and Delivery</a></li>
                    <li><a href="{{ route('contact.show') }}">Contact Us</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Return &amp; Refund policy</a></li>
                    <li><a href="#">Privacy policy</a></li>
                    <li><a href="{{ route('home') }}#bulk">Bulk Orders</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </div>

            <div class="footer-col footer-brand">
                <a href="{{ route('home') }}" class="footer-logo">
                    <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="footer-logo-mark" width="48" height="48">
                    <span class="footer-logo-text">XPERCIAINC</span>
                </a>
                <h3 class="footer-heading">XPERCIAINC</h3>
                <p class="footer-about">
                    R.P. Trading Company " are Wholesaler of Disposable Plate, Plastic Box, Disposable Bowl, Disposable Tray, Pasta Tray, and much more.
                </p>
            </div>

            <div class="footer-col">
                <h3 class="footer-heading">XPERCIAINC</h3>
                <ul class="footer-contact">
                    <li>By Rp Trading Company</li>
                    <li>Mobile - 9211997415</li>
                    <li>Email - Info@Xperciainc.com</li>
                    <li>
                        Add-
                        <a href="https://maps.google.com/?q=Basement,+Vidhata+Complex,+Vasundhara+Enclave,+Delhi,+India+110096" target="_blank" rel="noopener noreferrer" class="footer-address">
                            Basement, Vidhata Complex, Vasundhara Enclave, Delhi, India 110096
                        </a>
                    </li>
                    <li>GSTIN - 07AJCPA7351H1ZI</li>
                </ul>
            </div>
        </div>

        <div class="footer-social">
            <a href="#" class="footer-social-link" aria-label="Facebook">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06c0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89 1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02z"/>
                </svg>
            </a>
            <a href="#" class="footer-social-link" aria-label="Instagram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                    <rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/>
                    <circle cx="12" cy="12" r="4"/>
                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                </svg>
            </a>
            <a href="#" class="footer-social-link" aria-label="YouTube">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.8zM9.75 15.5v-7l6.5 3.5-6.5 3.5z"/>
                </svg>
            </a>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p class="footer-copyright">
                &copy;{{ date('Y') }}
                <a href="https://muktodharaltd.com/" target="_blank" rel="noopener noreferrer" class="footer-copyright-link">Muktodhara Technology Limited</a>.
                All right reserved.
            </p>
        </div>
    </div>
</footer>
