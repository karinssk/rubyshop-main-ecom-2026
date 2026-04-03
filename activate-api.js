const express = require('express');
const bodyParser = require('body-parser');
const app = express();
const PORT = 4019;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Log all requests
app.use((req, res, next) => {
    console.log(`\n[${new Date().toISOString()}] ${req.method} ${req.path}`);
    console.log('Headers:', JSON.stringify(req.headers, null, 2));
    if (Object.keys(req.body).length > 0) {
        console.log('Body:', JSON.stringify(req.body, null, 2));
    }
    next();
});

// Health check / Connection test
app.post('/api/check_connection_ext', (req, res) => {
    console.log('OK! Connection check - Responding OK');
    res.json({ status: true, message: 'Connection successful' });
});

app.get('/api/check_connection_ext', (req, res) => {
    console.log('OK! Connection check (GET) - Responding OK');
    res.json({ status: true, message: 'Connection successful' });
});

// Activate License
app.post('/api/activate_license', (req, res) => {
    const { product_id, license_code, client_name, verify_type } = req.body;
    
    console.log('🔐 ACTIVATE LICENSE REQUEST:');
    console.log('  Product ID:', product_id);
    console.log('  License Code:', license_code);
    console.log('  Client Name:', client_name);
    console.log('  Verify Type:', verify_type);
    
    // Generate license response content
    const licenseData = {
        license_code: license_code,
        client_name: client_name,
        product_id: product_id,
        domain: req.headers['lb-url'] || 'http://localhost',
        ip: req.headers['lb-ip'] || '127.0.0.1',
        activated_at: new Date().toISOString(),
        expires_at: new Date(Date.now() + 365 * 24 * 60 * 60 * 1000).toISOString(), // 1 year
        signature: Buffer.from(`${license_code}:${client_name}:${product_id}`).toString('base64')
    };
    
    const licenseResponse = Buffer.from(JSON.stringify(licenseData)).toString('base64');
    
    const response = {
        status: true,
        message: 'License activated successfully',
        lic_response: licenseResponse,
        status_code: 'SUCCESS'
    };
    
    console.log('OK! ACTIVATION SUCCESS - Sending response');
    console.log('License Response (base64):', licenseResponse);
    
    res.json(response);
});

// Verify License
app.post('/api/verify_license', (req, res) => {
    const { product_id, license_file } = req.body;
    
    console.log('🔍 VERIFY LICENSE REQUEST:');
    console.log('  Product ID:', product_id);
    console.log('  License File:', license_file ? license_file.substring(0, 50) + '...' : 'N/A');
    
    // Always return valid for testing
    const response = {
        status: true,
        message: 'License is valid',
        licensed_to: req.body.client_name || 'Test User'
    };
    
    console.log('OK! VERIFICATION SUCCESS');
    
    res.json(response);
});

// Deactivate License
app.post('/api/deactivate_license', (req, res) => {
    const { product_id, license_file, license_code, client_name } = req.body;
    
    console.log(' DEACTIVATE LICENSE REQUEST:');
    console.log('  Product ID:', product_id);
    
    const response = {
        status: true,
        message: 'License deactivated successfully'
    };
    
    console.log('OK! DEACTIVATION SUCCESS');
    
    res.json(response);
});

// Check for updates
app.post('/api/check_update', (req, res) => {
    const { product_id, current_version } = req.body;
    
    console.log(' CHECK UPDATE REQUEST:');
    console.log('  Product ID:', product_id);
    console.log('  Current Version:', current_version);
    
    // Return no update available
    const response = {
        status: false,
        message: 'No update available',
        update_id: null,
        version: current_version,
        has_sql: false
    };
    
    console.log('  No updates available');
    
    res.json(response);
});

// Download update
app.post('/api/download_update/main/:updateId', (req, res) => {
    console.log(' DOWNLOAD UPDATE REQUEST:', req.params.updateId);
    res.status(404).json({ status: false, message: 'Update not available' });
});

// Get update size
app.head('/api/get_update_size/:updateId', (req, res) => {
    console.log(' GET UPDATE SIZE:', req.params.updateId);
    res.set('Content-Length', '1048576'); // 1MB dummy
    res.status(200).send();
});

// Catch all other API routes
app.all('/api/*', (req, res) => {
    console.log('  Unknown API endpoint:', req.path);
    res.status(404).json({ 
        status: false, 
        message: 'Endpoint not found',
        path: req.path
    });
});

// Start server
app.listen(PORT, () => {
    console.log('='.repeat(70));
    console.log(' LICENSE SERVER STARTED');
    console.log('='.repeat(70));
    console.log(` Listening on: http://localhost:${PORT}`);
    console.log(` API Base URL: http://localhost:${PORT}/api`);
    console.log('');
    console.log('Available Endpoints:');
    console.log('  POST /api/check_connection_ext    - Connection test');
    console.log('  POST /api/activate_license        - Activate license');
    console.log('  POST /api/verify_license          - Verify license');
    console.log('  POST /api/deactivate_license      - Deactivate license');
    console.log('  POST /api/check_update            - Check for updates');
    console.log('');
    console.log('  WARNING: This is for TESTING ONLY - No real validation!');
    console.log('='.repeat(70));
    console.log('\nWaiting for requests...\n');
});

// Handle errors
app.use((err, req, res, next) => {
    console.error(' ERROR:', err.message);
    res.status(500).json({ 
        status: false, 
        message: 'Internal server error',
        error: err.message 
    });
});
