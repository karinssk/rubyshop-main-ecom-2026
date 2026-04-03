




  
  

  
  
  
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
   