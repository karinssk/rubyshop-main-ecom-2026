

  document.addEventListener('DOMContentLoaded', function() {
    new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      loop: true,
      centeredSlides: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      breakpoints: {
        640: {
          slidesPerView: 1.5,
        },
        1024: {
          slidesPerView: 2.5,
        },
      },
    });
  });





  // Scroll animations
  function revealOnScroll() {
    const elements = document.querySelectorAll('.faq-item');
    elements.forEach(element => {
      const elementTop = element.getBoundingClientRect().top;
      const windowHeight = window.innerHeight;
      if (elementTop < windowHeight - 100) {
        element.classList.add('visible');
      }
    });
  }

  // Add CSS for scroll animations
  const style = document.createElement('style');
  style.textContent = `
    .faq-item {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .faq-item.visible {
      opacity: 1;
      transform: translateY(0);
    }
  `;
  document.head.appendChild(style);

  // Initial check and add scroll event listener
  document.addEventListener('DOMContentLoaded', function() {
    revealOnScroll();
    window.addEventListener('scroll', revealOnScroll);
  });






  // Back to top button functionality
  document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('backToTop');
    
    // Show/hide button based on scroll position
    window.addEventListener('scroll', function() {
      if (window.pageYOffset > 300) {
        backToTopButton.style.display = 'block';
      } else {
        backToTopButton.style.display = 'none';
      }
    });
    
    // Scroll to top when button is clicked
    backToTopButton.addEventListener('click', function() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  });




  


  // Google Form integration
  document.addEventListener('DOMContentLoaded', function() {
      // Google Form integration
      const contactForm = document.getElementById('contactForm');
      
      if (contactForm) {
          // Your Google Form submission URL
          const googleFormURL = 'https://docs.google.com/forms/d/e/1FAIpQLScQ3LjJBELRFViTGhNwJ4YnekoT063jlEwa0gvIlVUfe_lQLQ/formResponse';
          
          // Replace these with your actual entry IDs from the Google Form
          const fieldMapping = {
              'name': 'entry.1303366296',
              'email': 'entry.680103493',
              'phone': 'entry.1516457013',
              'product': 'entry.1804196759',
              'message': 'entry.1925420914'
          };
          
          contactForm.addEventListener('submit', function(e) {
              e.preventDefault();
              
              // Simple validation
              let isValid = true;
              const requiredFields = contactForm.querySelectorAll('[required]');
              
              requiredFields.forEach(field => {
                  if (!field.value.trim()) {
                      isValid = false;
                      field.style.borderColor = 'red';
                  } else {
                      field.style.borderColor = '#e5e7eb';
                  }
              });
              
              if (!isValid) {
                  alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                  return;
              }
              
              // Show loading state
              const submitButton = contactForm.querySelector('button[type="submit"]');
              const originalButtonText = submitButton.innerHTML;
              submitButton.innerHTML = 'กำลังส่ง...';
              submitButton.disabled = true;
              
              // Create a hidden iframe
              const iframe = document.createElement('iframe');
              iframe.name = 'hidden_iframe';
              iframe.style.display = 'none';
              document.body.appendChild(iframe);
              
              // Create a form element
              const hiddenForm = document.createElement('form');
              hiddenForm.method = 'POST';
              hiddenForm.action = googleFormURL;
              hiddenForm.target = 'hidden_iframe';
              
              // Add form fields
              Object.keys(fieldMapping).forEach(fieldId => {
                  const input = document.createElement('input');
                  input.type = 'text';
                  input.name = fieldMapping[fieldId];
                  input.value = document.getElementById(fieldId).value;
                  hiddenForm.appendChild(input);
              });
              
              // Add the form to the document
              document.body.appendChild(hiddenForm);
              
              // Submit the form
              hiddenForm.submit();
              
              // Show success message
              contactForm.innerHTML = `
                  <div class="text-center p-8">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                      </svg>
                      <h3 class="text-2xl font-bold text-gray-800 mb-2">ขอบคุณสำหรับข้อความ!</h3>
                      <p class="text-gray-600">เราได้รับข้อความของคุณเรียบร้อยแล้ว เจ้าหน้าที่จะติดต่อกลับโดยเร็วที่สุด</p>
                  </div>
              `;
              
              // Clean up
              setTimeout(() => {
                  document.body.removeChild(hiddenForm);
                  document.body.removeChild(iframe);
              }, 1000);
          });
      }
  });
  
          














    document.addEventListener('DOMContentLoaded', function() {
      // Set the countdown target date (7 days from now)
      const countdownDate = new Date();
      countdownDate.setDate(countdownDate.getDate() + 7);
      countdownDate.setHours(0, 0, 0, 0); // Set to midnight
      
      // Get all countdown elements
      const daysEl = document.getElementById('days');
      const hoursEl = document.getElementById('hours');
      const minutesEl = document.getElementById('minutes');
      const secondsEl = document.getElementById('seconds');
      
      // Only proceed if elements exist
      if (daysEl && hoursEl && minutesEl && secondsEl) {
        function updateCountdown() {
          // Get current time
          const now = new Date().getTime();
          
          // Find the distance between now and the countdown date
          const distance = countdownDate.getTime() - now;
          
          // Time calculations for days, hours, minutes, and seconds
          const days = Math.floor(distance / (1000 * 60 * 60 * 24));
          const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          const seconds = Math.floor((distance % (1000 * 60)) / 1000);
          
          // Display the result with leading zeros
          daysEl.textContent = days.toString().padStart(2, '0');
          hoursEl.textContent = hours.toString().padStart(2, '0');
          minutesEl.textContent = minutes.toString().padStart(2, '0');
          secondsEl.textContent = seconds.toString().padStart(2, '0');
          
          // Stop countdown when time runs out
          if (distance < 0) {
            clearInterval(countdownInterval);
            daysEl.textContent = '00';
            hoursEl.textContent = '00';
            minutesEl.textContent = '00';
            secondsEl.textContent = '00';
          }
        }
        
        // Initial update
        updateCountdown();
        
        // Update every second
        const countdownInterval = setInterval(updateCountdown, 1000);
      }
    });
  