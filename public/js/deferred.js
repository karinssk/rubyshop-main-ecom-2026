window.addEventListener("load", () => {
  setTimeout(() => {
   const [navEntry] = performance.getEntriesByType("navigation");

   if (navEntry) {
     console.log(`Page fully loaded in: ${navEntry.loadEventEnd} ms`);
     console.log(`DOM Content Loaded in: ${navEntry.domContentLoadedEventEnd} ms`);
   } else {
     console.warn("Navigation timing API not supported.");
   }
 }, 0);
});





 new PerformanceObserver((entryList) => {
 for (const entry of entryList.getEntries()) {
   console.log('LCP candidate:', entry.startTime, entry);
 }
}).observe({type: 'largest-contentful-paint', buffered: true});




