    {!! dynamic_sidebar('top_footer_sidebar') !!}
    <!-- <footer class="main"> -->
      






    
    <!-- </footer> -->

    <!-- Quick view -->
    <div class="modal fade custom-modal" id="quick-view-modal" tabindex="-1" aria-labelledby="quick-view-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="half-circle-spinner loading-spinner">
                        <div class="circle circle-1"></div>
                        <div class="circle circle-2"></div>
                    </div>
                    <div class="quick-view-content"></div>
                </div>
            </div>
        </div>
    </div>

    @if (is_plugin_active('ecommerce'))
        <script>
            window.currencies = {!! json_encode(get_currencies_json()) !!};
        </script>
    @endif

    {!! Theme::footer() !!}

    <script>
        window.trans = {
            "Views": "{{ __('Views') }}",
            "Read more": "{{ __('Read more') }}",
            "days": "{{ __('days') }}",
            "hours": "{{ __('hours') }}",
            "mins": "{{ __('mins') }}",
            "sec": "{{ __('sec') }}",
            "No reviews!": "{{ __('No reviews!') }}"
        };
    </script>

    {!! Theme::place('footer') !!}

    @if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
            <script type="text/javascript">
                window.onload = function () {
                    @if (session()->has('success_msg'))
                    window.showAlert('alert-success', '{{ session('success_msg') }}');
                    @endif

                    @if (session()->has('error_msg'))
                    window.showAlert('alert-danger', '{{ session('error_msg') }}');
                    @endif

                    @if (isset($error_msg))
                    window.showAlert('alert-danger', '{{ $error_msg }}');
                    @endif

                    @if (isset($errors))
                    @foreach ($errors->all() as $error)
                    window.showAlert('alert-danger', '{!! BaseHelper::clean($error) !!}');
                    @endforeach
                    @endif
                };
            </script>
        @endif

        <div id="scrollUp"><i class="fal fa-long-arrow-up"></i></div>




  <!-- Start Footer -->
  <section class="bg-white text-black font-sans mx-4 sm:mx-0">
    <div class="container mx-auto py-6 px-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8">
        <!-- Left Column -->
        <div>
          <div class="mb-6">
            <h2 class="font-bold text-lg mb-3">PRODUCTS</h2>
            <ul class="space-y-1 text-gray-700 text-sm">
              <a href="https://www.rubyshop.co.th/product-categories/airless-sprayer">
                <li class="hover:text-red-500 transition-colors">Airless Sprayer</li>
              </a>
              <a href="https://www.rubyshop.co.th/product-categories/cement-mortar-spraying-machine">
                <li class="hover:text-red-500 transition-colors">Mortar Sprayer</li>
              </a>
              <a href="https://www.rubyshop.co.th/product-categories/wallcheser">
                <li class="hover:text-red-500 transition-colors">Wallcheser</li>
              </a>
              <a href="https://www.rubyshop.co.th/product-categories/road-line-striper-machine">
                <li class="hover:text-red-500 transition-colors">Road line striper machine</li>
              </a>
            </ul>
          </div>
          <div class="mt-4">
            <h2 class="font-bold text-lg mb-3">SUPPORT</h2>
            <ul class="space-y-1 text-gray-700 text-sm">
              <a href="https://www.rubyshop.co.th/aboutcompany/about-us">
                <li class="hover:text-red-500 transition-colors">Support Information</li>
              </a>
              <a href="https://www.rubyshop.co.th/aboutcompany/about-us">
                <li class="hover:text-red-500 transition-colors">Contact Us</li>
              </a>
              <a href="https://www.rubyshop.co.th/aboutcompany/about-us">
                <li class="hover:text-red-500 transition-colors">Find a Retailer</li>
              </a>
              <a href="https://www.rubyshop.co.th/aboutcompany/about-us">
                <li class="hover:text-red-500 transition-colors">Service Centers</li>
              </a>
              
            </ul>
          </div>
        </div>
        <!-- Middle Column -->
        <div>
          <div class="mb-6">
            <h2 class="font-bold text-lg mb-3">SYSTEMS</h2>
            <ul class="space-y-1 text-gray-700 text-sm">
              <a href="https://www.rubyshop.co.th/login">
                <li class="hover:text-red-500 transition-colors">Cordless Platforms</li>
              </a>
              <a href="https://www.rubyshop.co.th/register">
                <li class="hover:text-red-500 transition-colors">Register</li>
              </a>
            </ul>
          </div>
          <div>
            <h2 class="font-bold text-lg mb-3">ABOUT</h2>
            <ul class="space-y-1 text-gray-700 text-sm">
              <a href="https://www.rubyshop.co.th/aboutcompany/about-us">
                <li class="hover:text-red-500 transition-colors">About US</li>
              </a>
              <a href="https://www.rubyshop.co.th/aboutcompany/about-us">
                <li class="hover:text-red-500 transition-colors">Contact</li>
              </a>
              <a href="https://www.rubyshop.co.th/blog">
                <li class="hover:text-red-500 transition-colors">Blog</li>
              </a>
            </ul>
          </div>
        </div>
        <!-- Right Column - Email Signup & Location -->
        <div>
  <!-- Location Map Section -->
  <div class="mb-4">
    <h2 class="font-bold text-lg mb-3 flex items-center">
      <i class="fas fa-map-marker-alt mr-2 text-gray-700"></i>OUR LOCATION
    </h2>
    <div class="mb-3">
      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3872.8052475266736!2d100.5745573!3d13.9105861!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e2838a1d8ed6f5%3A0x71b9b36c507a601e!2zUlVCWVNIT1AgV0FSRUhPVVNFICjguKvguIjguIEu4Lij4Li54Lia4Li14LmJ4LiK4LmK4Lit4LibKQ!5e0!3m2!1sen!2sth!4v1756979537888!5m2!1sen!2sth" 
              width="100%" 
              height="150" 
              style="border:0; border-radius: 6px;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade"
              class="shadow-sm">
      </iframe>
    </div>
    <div class="text-xs text-gray-600 space-y-1">
      <p><i class="fas fa-map-marker-alt mr-1 text-red-500"></i>9 ถนนประชาอุทิศ แขวงสีกัน เขตดอนเมือง</p>
      <p><i class="fas fa-phone mr-1 text-red-500"></i>+66-89-666-7802</p>
      <p><i class="fas fa-clock mr-1 text-red-500"></i>จันทร์-เสาร์ 08:30-17:30</p>
    </div>
  </div>
    
    <p class="mb-3 text-gray-700 text-sm">Sign up to receive the latest info on new rubyshop products, special offers and more.</p>
    
    <!-- Success Alert (hidden by default) -->
    <div id="successAlert" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
      <strong class="font-bold">Success!</strong>
      <span class="block sm:inline"> Your information has been submitted successfully.</span>
      <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg onclick="document.getElementById('successAlert').classList.add('hidden')" class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <title>Close</title>
          <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
        </svg>
      </span>
    </div>
    
    <form id="emailSignupForm">
      <div class="mb-2">
        <input type="text" placeholder="First Name" class="w-full p-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-red-400" required>
      </div>
      
      <div class="mb-2">
        <input type="text" placeholder="Last Name" class="w-full p-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-red-400" required>
      </div>
      
      <div class="mb-2">
        <input type="email" placeholder="Email Address" class="w-full p-2 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-red-400" required>
      </div>
      
      <div class="mb-3">
        <button type="submit" class="w-full bg-red-500 text-white p-2 text-sm rounded hover:bg-red-600 transition-all">SUBSCRIBE</button>
      </div>
    </form>
    
    <p class="text-xs text-gray-600">By signing up, you agree to receive emails from Rubyshop® with news, special offers, and more. You can unsubscribe anytime. See our
      <a href="https://www.rubyshop.co.th/privacy-policy" class="text-blue-500 hover:underline">Privacy Policy</a> or
      <a href="https://www.rubyshop.co.th/aboutcompany/about-us" class="text-blue-500 hover:underline">Contact Us</a>.
    </p>
  </div>
</div>

<script>
  document.getElementById('emailSignupForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    // Here you would typically send the form data to your server
    // For this example, we'll just show the success message
    
    // Show success alert
    document.getElementById('successAlert').classList.remove('hidden');
    
    // Clear form fields
    this.reset();
    
    // Optionally hide the alert after a few seconds
    setTimeout(function() {
      document.getElementById('successAlert').classList.add('hidden');
    }, 5000);
  });
</script>

      </div>
    </div>
  </section>
  <!-- End Footer -->
  <section class="flex flex-col">
    <div class="bg-gray-100 py-4">
      <footer class="bg-white text-center py-4">
        <p class="text-gray-800 font-bold text-sm">COPYRIGHT © RUBYSHOP 2025</p>
        <p class="text-gray-700 mt-2 text-xs px-4">เครื่องหมายการค้าต่อไปนี้เป็นของ เครื่องพ่นสีแรงดันสูง เครื่องผสมสี เครื่องพ่นสีกันไฟ เครื่องพ่นปูนฉาบ เครื่องตีเส้นถนน เครื่องกรีดผนัง เครื่องปั่นหน้าปูนและอื่นๆ ของ RUBYSHOP: โทนสีแดง-เทา และลวดลายบนพื้นผิวของเครื่องมือ หจก. รูบี้ช๊อป</p>
        <div class="flex justify-center items-center mt-4 space-x-4">
            <!-- Social Media Links -->
        <div class="flex justify-center items-center mt-4 space-x-4">
          <a href="https://www.facebook.com/rubyshopcoth" class="text-black hover:text-red-500 transition-colors" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
            </svg>
          </a>
          <a href="https://www.instagram.com/rubyshop_168" class="text-black hover:text-red-500 transition-colors" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
          </a>
          <a href="https://www.youtube.com/channel/UCxiaZiIC8qs2C228jwIjcHg" class="text-black hover:text-red-500 transition-colors" aria-label="YouTube">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
            </svg>
          </a>
          <a href="https://x.com/RUBYSHOP168" class="text-black hover:text-red-500 transition-colors" aria-label="Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
            </svg>
          </a>
        </div>
        </div>
        <div class="bg-black text-red-400 mt-4 py-2">
          <div class="flex justify-center space-x-4 text-sm">
            <a href="https://www.rubyshop.co.th/aboutcompany/about-us" class="hover:underline">Accessibility Statement</a>
            <span>|</span>
            <a href=" https://www.rubyshop.co.th/privacy-policy" class="hover:underline">Privacy Policy</a>
            <span>|</span>
            <a href="https://www.rubyshop.co.th/cookie-policy" class="hover:underline">Cookies</a>
            <span>|</span>
            <a href="https://www.rubyshop.co.th/products" class="hover:underline">Power Tools Institute</a>
            <span>|</span>
            <a href="https://www.rubyshop.co.th/products" class="hover:underline">Shop </a>
          </div>
        </div>
  </section>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WSR5H4YBF2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-WSR5H4YBF2');
</script>
</footer>
      <h1 id="test101">test console.log header</h1>
    
</body>
</html>
