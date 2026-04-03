

  // document.addEventListener('DOMContentLoaded', function() {
  //   // Get all smooth scroll buttons
  //   const smoothScrollButtons = document.querySelectorAll('.smooth-scroll-btn');
    
  //   // Add click event listener to each button
  //   smoothScrollButtons.forEach(button => {
  //     button.addEventListener('click', function(e) {
  //       e.preventDefault();
        
  //       // Get the target section ID
  //       const targetId = this.getAttribute('data-target');
  //       const targetElement = document.getElementById(targetId);
        
  //       if (targetElement) {
  //         // Get the navbar height for offset (if you have a fixed navbar)
  //         const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 0;
          
  //         // Calculate the target position with offset
  //         const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
          
  //         // Smooth scroll to the target
  //         window.scrollTo({
  //           top: targetPosition,
  //           behavior: 'smooth'
  //         });
          
  //         // Optional: Update URL hash without jumping
  //         history.pushState(null, null, `#${targetId}`);
          
  //         // Optional: Add focus to the target for accessibility
  //         targetElement.setAttribute('tabindex', '-1');
  //         targetElement.focus({ preventScroll: true });
  //       }
  //     });
  //   });
    
  //   // Handle hash links on page load for direct links
  //   if (window.location.hash) {
  //     const targetId = window.location.hash.substring(1);
  //     const targetElement = document.getElementById(targetId);
      
  //     if (targetElement) {
  //       // Delay scrolling slightly to ensure page is fully loaded
  //       setTimeout(() => {
  //         const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 0;
  //         const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
          
  //         window.scrollTo({
  //           top: targetPosition,
  //           behavior: 'smooth'
  //         });
          
  //         targetElement.setAttribute('tabindex', '-1');
  //         targetElement.focus({ preventScroll: true });
  //       }, 300);
  //     }
  //   }
  // });




  // <!-- Fallback script for browsers without Alpine.js -->

    // Only run if Alpine.js is not available
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof Alpine === 'undefined') {
        const contactBtn = document.getElementById('headerContactBtn');
        const dropdown = document.getElementById('socialIconsDropdown');
        
        if (contactBtn && dropdown) {
          let hideTimer;
          
          // Initially hide the dropdown
          dropdown.style.display = 'none';
          
          // Show dropdown on hover or click
          contactBtn.addEventListener('mouseenter', function() {
            clearTimeout(hideTimer);
            dropdown.style.display = 'flex';
            contactBtn.setAttribute('aria-expanded', 'true');
          });
          
          contactBtn.addEventListener('click', function() {
            if (dropdown.style.display === 'none') {
              dropdown.style.display = 'flex';
              contactBtn.setAttribute('aria-expanded', 'true');
            } else {
              dropdown.style.display = 'none';
              contactBtn.setAttribute('aria-expanded', 'false');
            }
          });
          
          // Hide dropdown when mouse leaves
          contactBtn.addEventListener('mouseleave', function() {
            hideTimer = setTimeout(function() {
              dropdown.style.display = 'none';
              contactBtn.setAttribute('aria-expanded', 'false');
            }, 300);
          });
          
          // Keep dropdown visible when hovering over it
          dropdown.addEventListener('mouseenter', function() {
            clearTimeout(hideTimer);
          });
          
          // Hide dropdown when mouse leaves it
          dropdown.addEventListener('mouseleave', function() {
            hideTimer = setTimeout(function() {
              dropdown.style.display = 'none';
              contactBtn.setAttribute('aria-expanded', 'false');
            }, 300);
          });
          
          // Close dropdown when clicking outside
          document.addEventListener('click', function(e) {
            if (!contactBtn.contains(e.target) && !dropdown.contains(e.target)) {
              dropdown.style.display = 'none';
              contactBtn.setAttribute('aria-expanded', 'false');
            }
          });
        }
      }
    });
  






//   <!-- Script for YouTube Video -->
document.addEventListener('DOMContentLoaded', function() {
    // YouTube video functionality
    const placeholder = document.getElementById('youtube-placeholder');
    const container = document.getElementById('youtube-iframe-container');
    
    if (placeholder && container) {
      placeholder.addEventListener('click', function() {
        container.innerHTML = `<iframe
          class="absolute top-0 left-0 w-full h-full rounded-lg"
          src="https://www.youtube.com/embed/Y6x1ZHgIhkI?autoplay=1"
          title="คุณจรินทร์ ที่มั่นใจ เลือกใช้เครื่องพ่นปูนฉาบ รุ่น RB-M30L"
          frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
          allowfullscreen>
        </iframe>`;
        
        container.classList.remove('hidden');
        placeholder.classList.add('hidden');
      });
    }
});




// <!-- Optimized Counter Animation Script -->

  document.addEventListener('DOMContentLoaded', () => {
    // Optimized counter animation function
    function animateCounter(elementId, targetValue, suffix = '', duration = 1500) {
      const element = document.getElementById(elementId);
      if (!element) return;
      
      let startTime;
      const startValue = 0;
      
      function updateCounter(timestamp) {
        if (!startTime) startTime = timestamp;
        
        const progress = Math.min((timestamp - startTime) / duration, 1);
        const currentValue = Math.floor(progress * (targetValue - startValue) + startValue);
        
        element.textContent = currentValue + suffix;
        
        if (progress < 1) {
          requestAnimationFrame(updateCounter);
        } else {
          element.textContent = targetValue + suffix;
        }
      }
      
      requestAnimationFrame(updateCounter);
    }
    
    // Use Intersection Observer for better performance
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.dataset.counted) {
          entry.target.dataset.counted = 'true';
          
          // Start animations based on element ID
          switch (entry.target.id) {
            case 'years-experience':
              animateCounter('years-experience', 10, '+');
              break;
            case 'clients':
              animateCounter('clients', 51, 'K');
              break;
            case 'Projects':
              animateCounter('Projects', 100, '+');
              break;
            case 'progress-bar-1':
              animateCounter('progress-bar-1', 20, '%');
              // Animate the progress bar width
              entry.target.nextElementSibling.querySelector('div').style.width = '20%';
              break;
            case 'progress-bar-2':
              animateCounter('progress-bar-2', 100, '%');
              // Animate the progress bar width
              entry.target.nextElementSibling.querySelector('div').style.width = '100%';
              break;
          }
        }
      });
    }, { threshold: 0.2, rootMargin: '0px 0px -100px 0px' });
    
    // Observe all counter elements
    ['years-experience', 'clients', 'Projects', 'progress-bar-1', 'progress-bar-2'].forEach(id => {
      const element = document.getElementById(id);
      if (element) observer.observe(element);
    });
  });




//   <!-- Lazy Loading Script -->
 
    document.addEventListener('DOMContentLoaded', function() {
      // Intersection Observer for lazy loading images
      const lazyImages = document.querySelectorAll('img[data-src]');
      
      if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const img = entry.target;
              img.src = img.dataset.src;
              img.onload = () => {
                img.removeAttribute('data-src');
                img.classList.add('opacity-100');
                img.classList.remove('opacity-0');
              };
              imageObserver.unobserve(img);
            }
          });
        }, {
          rootMargin: '50px 0px',
          threshold: 0.01
        });
        
        lazyImages.forEach(img => {
          img.classList.add('opacity-0', 'transition-opacity', 'duration-500');
          imageObserver.observe(img);
        });
      } else {
        // Fallback for browsers that don't support Intersection Observer
        lazyImages.forEach(img => {
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
        });
      }
    });





    // <!-- Lazy Loading Script for this step by step section -->
  
      document.addEventListener('DOMContentLoaded', function() {
        // Use Intersection Observer for lazy loading images
        if ('IntersectionObserver' in window) {
          const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.onload = () => {
                  img.classList.remove('opacity-0');
                  img.classList.add('opacity-100');
                };
                imageObserver.unobserve(img);
              }
            });
          }, {
            rootMargin: '100px 0px',
            threshold: 0.1
          });
  
          // Observe all images with data-src attribute in this section
          document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
            imageObserver.observe(img);
          });
        } else {
          // Fallback for browsers without Intersection Observer support
          document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
            img.src = img.dataset.src;
          });
        }
      });
 

    //   <!-- Lazy Loading Script for this เครื่องบรรจุปูน 30 ลิตร กำลังแรงสูง ฉาบได้ต่อเนื่อง ไม่สะดุด  หมดปัญหาปูนไม่เกาะผนัง! เทคโนโลยีพ่นปูนขั้นสูง ให้งานฉาบเรียบเนียนทุกพื้นผิว
    //   ใช้งานง่าย ทนทาน คุ้มค่า! ลงทุนครั้งเดียว จบงานฉาบได้ทุกรูปแบบsection -->

      document.addEventListener('DOMContentLoaded', function() {
        // Use Intersection Observer for lazy loading images
        if ('IntersectionObserver' in window) {
          const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                imageObserver.unobserve(img);
              }
            });
          }, {
            rootMargin: '100px 0px',
            threshold: 0.1
          });
  
          // Observe all images with data-src attribute in this section
          document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
            imageObserver.observe(img);
          });
        } else {
          // Fallback for browsers without Intersection Observer support
          document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
            img.src = img.dataset.src;
          });
        }
      });
 




    //   <!-- Lazy Loading Script for this thx cs section -->

      document.addEventListener('DOMContentLoaded', function() {
        // Use Intersection Observer for lazy loading images
        if ('IntersectionObserver' in window) {
          const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                imageObserver.unobserve(img);
              }
            });
          }, {
            rootMargin: '200px 0px',
            threshold: 0.01
          });
  
          // Observe all images with data-src attribute in this section
          document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
            imageObserver.observe(img);
          });
        } else {
          // Fallback for browsers without Intersection Observer support
          document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
            img.src = img.dataset.src;
          });
        }
      });





    //   <!-- Optimized Form Submission Script -->

        document.addEventListener('DOMContentLoaded', function() {
          const contactForm = document.getElementById('contactForm');
          
          if (contactForm) {
            // Google Form mapping
            const googleFormURL = 'https://docs.google.com/forms/d/e/1FAIpQLScQ3LjJBELRFViTGhNwJ4YnekoT063jlEwa0gvIlVUfe_lQLQ/formResponse';
            const fieldMapping = {
              'name': 'entry.1303366296',
              'email': 'entry.680103493',
              'phone': 'entry.1516457013',
              'product': 'entry.1804196759',
              'message': 'entry.1925420914'
            };
    
            contactForm.addEventListener('submit', function(e) {
              e.preventDefault();
              
              // Form validation
              let isValid = true;
              const requiredFields = contactForm.querySelectorAll('[required]');
              
              requiredFields.forEach(field => {
                if (!field.value.trim()) {
                  isValid = false;
                  field.classList.add('border-red-500');
                  field.classList.add('bg-red-50');
                } else {
                  field.classList.remove('border-red-500');
                  field.classList.remove('bg-red-50');
                }
              });
              
              if (!isValid) {
                // Show validation error
                alert('กรุณากรอกข้อมูลให้ครบถ้วน');
                return;
              }
              
              // Show loading state
              const submitButton = contactForm.querySelector('button[type="submit"]');
              const originalButtonText = submitButton.innerHTML;
              submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> กำลังส่ง...';
              submitButton.disabled = true;
              
              // Create hidden iframe for form submission
              const iframe = document.createElement('iframe');
              iframe.name = 'hidden_iframe';
              iframe.style.display = 'none';
              document.body.appendChild(iframe);
              
              // Create form for submission
              const hiddenForm = document.createElement('form');
              hiddenForm.method = 'POST';
              hiddenForm.action = googleFormURL;
              hiddenForm.target = 'hidden_iframe';
              
              // Add form fields
              Object.keys(fieldMapping).forEach(fieldId => {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = fieldMapping[fieldId];
                input.value = document.getElementById(fieldId)?.value || '';
                hiddenForm.appendChild(input);
              });
              
              // Submit the form
              document.body.appendChild(hiddenForm);
              hiddenForm.submit();
              
              // Show success message
              setTimeout(() => {
                // Reset form
                contactForm.reset();
                
                // Show success alert
                document.getElementById('contactSuccessAlert').classList.remove('hidden');
                
                // Reset button
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
                
                // Clean up
                document.body.removeChild(hiddenForm);
                document.body.removeChild(iframe);
                
                // Auto-hide success message after 5 seconds
                setTimeout(() => {
                  const alert = document.getElementById('contactSuccessAlert');
                  if (alert && !alert.classList.contains('hidden')) {
                    alert.classList.add('hidden');
                  }
                }, 5000);
              }, 1000);
            });
          }
        });
 


        document.addEventListener('DOMContentLoaded', function() {
          // Use Intersection Observer for lazy loading images
          if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
              entries.forEach(entry => {
                if (entry.isIntersecting) {
                  const img = entry.target;
                  img.src = img.dataset.src;
                  imageObserver.unobserve(img);
                }
              });
            }, {
              rootMargin: '200px 0px',
              threshold: 0.01
            });
    
            // Observe all images with data-src attribute in this section
            document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
              imageObserver.observe(img);
            });
          } else {
            // Fallback for browsers without Intersection Observer support
            document.querySelectorAll('section:last-of-type img[data-src]').forEach(img => {
              img.src = img.dataset.src;
            });
          }
        });
 