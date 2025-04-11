<!-- filepath: c:\homeessence\resources\views\layouts\footer.blade.php -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="footer-heading">About HomeEssence</h4>
                <p>Discover elegant home furnishings and décor that transform your living spaces. Our curated collection brings style and comfort to every home.</p>
            </div>
            
            <div class="col-md-3 mb-4">
                <h4 class="footer-heading">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            
            <div class="col-md-3 mb-4">
                <h4 class="footer-heading">Customer Service</h4>
                <ul class="footer-links">
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Return Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            
            <div class="col-md-2 mb-4">
                <h4 class="footer-heading">Connect</h4>
                <div class="d-flex gap-3">
                    <a href="#" class="text-dark fs-4"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-dark fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-dark fs-4"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p class="mb-0">&copy; {{ date('Y') }} HomeEssence. All rights reserved.</p>
        </div>
    </div>
</footer>