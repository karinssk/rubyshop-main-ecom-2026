import { PlaywrightCrawler } from 'crawlee';
import fs from 'fs';

// Arrays to store URLs with errors
const notFoundUrls = [];
const errorUrls = [];

const crawler = new PlaywrightCrawler({
    async requestHandler({ request, page, enqueueLinks, log }) {
        const response = page.url() ? await page.goto(request.url) : null;
        
        if (response) {
            const statusCode = response.status();
            
            if (statusCode === 404) {
                log.error(`❌ 404 NOT FOUND: ${request.url}`);
                console.log(`\n🚨 404 ERROR: ${request.url}`);
                notFoundUrls.push(request.url);
            } else if (statusCode >= 400) {
                log.warning(`⚠️  HTTP ${statusCode}: ${request.url}`);
                console.log(`\n⚠️  HTTP ${statusCode} ERROR: ${request.url}`);
                errorUrls.push({ url: request.url, status: statusCode });
            } else {
                log.info(` OK ${statusCode}: ${request.url}`);
            }
        } else {
            log.info(`📄 ${request.url}`);
        }
        
        // Only enqueue links if the page loaded successfully
        if (response && response.status() < 400) {
            await enqueueLinks();
        }
    },
    
    // Handle failed requests (network errors, timeouts, etc.)
    async failedRequestHandler({ request, log }) {
        log.error(`💥 FAILED REQUEST: ${request.url} - ${request.errorMessages?.join(', ') || 'Unknown error'}`);
        console.log(`\n💥 FAILED: ${request.url}`);
        errorUrls.push({ url: request.url, status: 'FAILED', error: request.errorMessages?.join(', ') || 'Unknown error' });
    },
    
    // Limitation for only 10 requests (do not use if you want to crawl all links)
    maxRequestsPerCrawl: 100, // Set a reasonable limit for testing
});

// Run the crawler with initial request
await crawler.run(['https://www.rubyshop.co.th']);

// Save results to files after crawling is complete
console.log('\n📊 CRAWLING COMPLETED!');
console.log(`\n📈 Summary:`);
console.log(`   • 404 Not Found URLs: ${notFoundUrls.length}`);
console.log(`   • Other Error URLs: ${errorUrls.length}`);

if (notFoundUrls.length > 0) {
    const report404 = notFoundUrls.join('\n');
    fs.writeFileSync('404-urls.txt', report404);
    console.log('\n💾 Saved 404 URLs to: 404-urls.txt');
    console.log('\n🚨 404 NOT FOUND URLs:');
    notFoundUrls.forEach(url => console.log(`   • ${url}`));
}

if (errorUrls.length > 0) {
    const errorReport = errorUrls.map(item => 
        typeof item.status === 'number' 
            ? `${item.status}: ${item.url}` 
            : `${item.status} (${item.error}): ${item.url}`
    ).join('\n');
    fs.writeFileSync('error-urls.txt', errorReport);
    console.log('\n💾 Saved error URLs to: error-urls.txt');
    console.log('\n⚠️  ERROR URLs:');
    errorUrls.forEach(item => console.log(`   • ${item.status}: ${item.url}`));
}