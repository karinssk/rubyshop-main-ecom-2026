<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ใบเสนอราคา - Quotation</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="https://www.rubyshop.co.th/storage/logo/icon-rubyshop-ico.png">
  
  
  
  <script src="https://analytics.ahrefs.com/analytics.js" data-key="+yln8X9wf8523X4GDZmCqA" async></script>
  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NHBT4DYH7D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NHBT4DYH7D');
</script>
  
  
  
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3b82f6',
            secondary: '#10b981',
            accent: '#f59e0b',
            dark: '#1f2937',
          },
          fontFamily: {
            sans: ['Sarabun', 'sans-serif'],
          },
        }
      }
    }
  </script>
  <style>
    body {
      font-family: 'Sarabun', sans-serif;
      background-color: #f9fafb;
    }
    
    input, textarea, select {
      transition: border-color 0.2s ease-in-out;
    }
    
    input:focus, textarea:focus, select:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    
    .print-container {
      display: none;
      background: white;
      padding: 30px;
      font-family: 'Sarabun', sans-serif;
    }
    
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body class="bg-gray-50">
  <div class="max-w-5xl mx-auto p-4 md:p-6 my-8">
    <!-- Form Container -->
    <div id="quotationForm" class="bg-white rounded-lg shadow-lg p-6 mb-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">ใบเสนอราคา / Quotation</h1>
      </div>
      
      <!-- Customer Information -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <div class="mb-4">
            <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">ชื่อผู้ติดต่อ</label>
            <input type="text" id="contact" value="คุณ Seejan kongram" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
          </div>
          
          <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">ที่อยู่</label>
            <textarea id="address" rows="3" 
                     class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">22 หมู่บ้าน/อาคาร - ชั้นที่ 36 ห้องที่ 36</textarea>
          </div>
        </div>
        
        <div>
          <div class="mb-4">
            <label for="quoteDate" class="block text-sm font-medium text-gray-700 mb-1">วันเสนอราคา</label>
            <input type="date" id="quoteDate" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
          </div>
          
          <div class="mb-4">
            <label for="company" class="block text-sm font-medium text-gray-700 mb-1">บริษัท</label>
            <input type="text" id="company" value="Rubyshop" 
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
          </div>
        </div>
      </div>
      
      <!-- Product Table -->
      <div class="mb-6 overflow-x-auto">
        <div class="flex justify-end mb-2">
          <button id="addRowBtn" class="bg-primary hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            เพิ่มรายการสินค้า
          </button>
        </div>
        
        <table id="productTable" class="min-w-full divide-y divide-gray-200 border">
          <thead>
            <tr class="bg-gray-50">
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-12">ลำดับ</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">รหัสสินค้า</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">รายการ</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-20">จำนวน</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-20">หน่วย</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">ราคาขาย</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">จำนวนเงิน</th>
              <th class="px-3 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-16">ลบ</th>
            </tr>
          </thead>
          <tbody id="tableBody" class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-3 py-2 text-center">1</td>
              <td class="px-3 py-2"><input type="text" class="product-code w-full px-2 py-1 border border-gray-300 rounded-md" value="6013127"></td>
              <td class="px-3 py-2"><input type="text" class="product-name w-full px-2 py-1 border border-gray-300 rounded-md" value="เครื่องพ่นปูนฉาบ รุ่น RB-M30L เครื่องบรรจุปูน 30 ลิตร"></td>
              <td class="px-3 py-2"><input type="number" class="quantity w-full px-2 py-1 border border-gray-300 rounded-md text-center" value="1" min="1"></td>
              <td class="px-3 py-2"><input type="text" class="unit w-full px-2 py-1 border border-gray-300 rounded-md text-center" value="EA"></td>
              <td class="px-3 py-2"><input type="number" class="price w-full px-2 py-1 border border-gray-300 rounded-md text-right" value="90000" min="0" step="0.01"></td>
              <td class="px-3 py-2"><input type="number" class="total w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-gray-50" value="90000" readonly></td>
              <td class="px-3 py-2 text-center">
                <button class="deleteRow text-red-500 hover:text-red-700">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                  </svg>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <!-- Calculate Button -->
      <div class="flex justify-center mb-6">
        <button id="calculateBtn" class="bg-accent hover:bg-amber-600 text-white px-6 py-2 rounded-md font-medium smooth-scroll-btn" onclick="highlightTotal()">
          คำนวณยอดรวม
        </button>
      </div>
      
      <!-- Total Section -->
      <div class="bg-gray-50 p-4 rounded-md mb-6 scroll-highlight" id="totalSection">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="md:col-start-2">
            <div class="flex justify-between items-center mb-2">
              <span class="text-gray-700">จำนวนเงินหลังหักส่วนลด (Exclude VAT):</span>
              <div class="w-32">
                <input type="number" id="excludeVat" value="210.28" readonly 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md text-right bg-gray-50">
              </div>
            </div>
            
            <div class="flex justify-between items-center mb-2">
              <span class="text-gray-700">ภาษีมูลค่าเพิ่ม 7%:</span>
              <div class="w-32">
                <input type="number" id="vat" value="14.72" readonly 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md text-right bg-gray-50">
              </div>
            </div>
            
            <div class="flex justify-between items-center font-bold">
              <span class="text-gray-800">จำนวนเงินรวมทั้งหมด (Include VAT):</span>
              <div class="w-32">
                <input type="number" id="totalAmount" value="225" readonly 
                      class="w-full px-3 py-2 border border-gray-300 rounded-md text-right bg-gray-50 font-bold">
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Terms and Conditions -->
      <div class="bg-gray-50 p-4 rounded-md mb-6">
        <h4 class="font-bold mb-2 text-gray-800">เงื่อนไขการเสนอราคา</h4>
        <p class="text-sm text-gray-600 mb-2">ใบเสนอราคานี้มีผลเฉพาะการชำระเงินภายในวันที่ <span id="termsDate"></span> และจัดส่งสินค้าจากสาขาที่ระบุในใบเสนอราคานี้เท่านั้น</p>
        <p class="text-sm text-gray-600">ราคาดังกล่าวเป็นราคาเฉพาะค่าสินค้า ตามสาขาที่ระบุในใบเสนอราคา โดยไม่รวมค่าขนส่งสินค้า ส่วนลดบัตรเครดิต และคูปองส่งเสริมการขาย</p>
      </div>
      
      <!-- Download Button -->
      <div class="flex justify-center">
        <button id="generatePdfBtn" class="bg-secondary hover:bg-green-600 text-white px-6 py-3 rounded-md font-medium flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
          ดาวน์โหลด PDF
        </button>
      </div>
    </div>
  </div>
  
  <!-- Printable Container (Hidden) -->
  <div id="printable" class="print-container"></div>
  
  <script>
document.addEventListener('DOMContentLoaded', function() {
  // Set default date to today
  const today = new Date().toISOString().split('T')[0];
  document.getElementById('quoteDate').value = today;
  document.getElementById('termsDate').textContent = formatDate(today);
  
  // Setup event listeners
  document.getElementById('addRowBtn').addEventListener('click', addRow);
  document.getElementById('calculateBtn').addEventListener('click', calculateTotals);
  document.getElementById('generatePdfBtn').addEventListener('click', generatePDF);
  document.getElementById('quoteDate').addEventListener('change', function() {
    document.getElementById('termsDate').textContent = formatDate(this.value);
  });
  
  setupRowListeners();
  calculateTotals();
});

function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString('th-TH', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });
}

function setupRowListeners() {
  document.querySelectorAll('.quantity, .price').forEach(input => {
    input.addEventListener('input', function() {
      calculateRowTotal(this.closest('tr'));
    });
  });
  
  document.querySelectorAll('.deleteRow').forEach(button => {
    button.addEventListener('click', function() {
      deleteRow(this.closest('tr'));
    });
  });
}

function addRow() {
  const tableBody = document.getElementById('tableBody');
  const rowCount = tableBody.rows.length;
  const newRow = document.createElement('tr');
  
  newRow.innerHTML = `
    <td class="px-3 py-2 text-center">${rowCount + 1}</td>
    <td class="px-3 py-2"><input type="text" class="product-code w-full px-2 py-1 border border-gray-300 rounded-md"></td>
    <td class="px-3 py-2"><input type="text" class="product-name w-full px-2 py-1 border border-gray-300 rounded-md"></td>
    <td class="px-3 py-2"><input type="number" class="quantity w-full px-2 py-1 border border-gray-300 rounded-md text-center" value="1" min="1"></td>
    <td class="px-3 py-2"><input type="text" class="unit w-full px-2 py-1 border border-gray-300 rounded-md text-center" value="EA"></td>
    <td class="px-3 py-2"><input type="number" class="price w-full px-2 py-1 border border-gray-300 rounded-md text-right" value="0" min="0" step="0.01"></td>
    <td class="px-3 py-2"><input type="number" class="total w-full px-2 py-1 border border-gray-300 rounded-md text-right bg-gray-50" value="0" readonly></td>
    <td class="px-3 py-2 text-center">
      <button class="deleteRow text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
      </button>
    </td>
  `;
  
  tableBody.appendChild(newRow);
  setupRowListeners();
  updateRowNumbers();
}

function deleteRow(row) {
  row.remove();
  updateRowNumbers();
  calculateTotals();
}

function updateRowNumbers() {
  document.querySelectorAll('#tableBody tr').forEach((row, index) => {
    row.cells[0].innerText = index + 1;
  });
}

function calculateRowTotal(row) {
  const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
  const price = parseFloat(row.querySelector('.price').value) || 0;
  row.querySelector('.total').value = (quantity * price).toFixed(2);
  calculateTotals();
}

function calculateTotals() {
  const totals = Array.from(document.querySelectorAll('.total')).map(input => parseFloat(input.value) || 0);
  const subtotal = totals.reduce((sum, total) => sum + total, 0);
  
  // Changed calculation logic as requested
  const excludeVat = subtotal; // Now this is the full amount before VAT
  const vat = excludeVat * 0.07; // Calculate 7% of the full amount
  const totalWithVat = excludeVat + vat; // Total is now full amount + VAT
  
  document.getElementById('excludeVat').value = excludeVat.toFixed(2);
  document.getElementById('vat').value = vat.toFixed(2);
  document.getElementById('totalAmount').value = totalWithVat.toFixed(2);
}

function preparePrintable() {
  const printable = document.getElementById('printable');
  const contact = document.getElementById('contact').value;
  const address = document.getElementById('address').value;
  const quoteDate = document.getElementById('quoteDate').value;
  const company = document.getElementById('company').value;
  const excludeVat = document.getElementById('excludeVat').value;
  const vat = document.getElementById('vat').value;
  const totalAmount = document.getElementById('totalAmount').value;
  const formattedDate = formatDate(quoteDate);
  
  let tableRows = '';
  document.querySelectorAll('#tableBody tr').forEach((row, index) => {
    tableRows += `
      <tr class="border-b border-gray-200">
        <td class="px-4 py-3 text-center">${index + 1}</td>
        <td class="px-4 py-3">${row.querySelector('.product-code').value}</td>
        <td class="px-4 py-3">${row.querySelector('.product-name').value}</td>
        <td class="px-4 py-3 text-center">${row.querySelector('.quantity').value}</td>
        <td class="px-4 py-3 text-center">${row.querySelector('.unit').value}</td>
        <td class="px-4 py-3 text-right">${parseFloat(row.querySelector('.price').value).toLocaleString('th-TH', {minimumFractionDigits: 2})}</td>
        <td class="px-4 py-3 text-right">${parseFloat(row.querySelector('.total').value).toLocaleString('th-TH', {minimumFractionDigits: 2})}</td>
      </tr>
    `;
  });
  
  printable.innerHTML = `
    <div class="max-w-4xl mx-auto">
      <div class="flex justify-between items-start mb-8">
        <div>
          <h1 class="text-2xl font-bold text-gray-800 mb-1">ใบเสนอราคา / Quotation</h1>
          <p class="text-gray-500">วันที่: ${formattedDate}</p>
        </div>
        <div class="text-right">
          <h2 class="text-xl font-bold text-gray-800 mb-1">${company}</h2>
          <p class="text-gray-600">เลขที่ใบเสนอราคา: QT-${new Date().getFullYear()}${String(new Date().getMonth() + 1).padStart(2, '0')}${String(Math.floor(Math.random() * 1000)).padStart(3, '0')}</p>
        </div>
      </div>
      
      <div class="bg-gray-50 p-4 rounded-md mb-6">
        <h3 class="font-bold text-gray-700 mb-2">ข้อมูลลูกค้า</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <p><span class="font-medium">ชื่อผู้ติดต่อ:</span> ${contact}</p>
            <p><span class="font-medium">ที่อยู่:</span> ${address}</p>
          </div>
        </div>
      </div>
      
      <table class="min-w-full mb-6">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">ลำดับ</th>
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">รหัสสินค้า</th>
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">รายการ</th>
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">จำนวน</th>
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">หน่วย</th>
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">ราคาขาย</th>
            <th class="px-4 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">จำนวนเงิน</th>
          </tr>
        </thead>
        <tbody>
          ${tableRows}
        </tbody>
      </table>
      
      <div class="flex justify-end mb-8">
        <div class="w-64">
          <div class="flex justify-between py-2 border-b">
            <span class="font-medium">จำนวนเงินหลังหักส่วนลด (Exclude VAT):</span>
            <span>${parseFloat(excludeVat).toLocaleString('th-TH', {minimumFractionDigits: 2})} บาท</span>
          </div>
          <div class="flex justify-between py-2 border-b">
            <span class="font-medium">ภาษีมูลค่าเพิ่ม 7%:</span>
            <span>${parseFloat(vat).toLocaleString('th-TH', {minimumFractionDigits: 2})} บาท</span>
          </div>
          <div class="flex justify-between py-2 font-bold">
            <span>จำนวนเงินรวมทั้งหมด (Include VAT):</span>
            <span>${parseFloat(totalAmount).toLocaleString('th-TH', {minimumFractionDigits: 2})} บาท</span>
          </div>
        </div>
      </div>
      
      <div class="border-t pt-4 mb-8">
        <h4 class="font-bold mb-2">เงื่อนไขการเสนอราคา</h4>
        <p class="text-sm mb-2">ใบเสนอราคานี้มีผลเฉพาะการชำระเงินภายในวันที่ ${formattedDate} และจัดส่งสินค้าจากสาขาที่ระบุในใบเสนอราคานี้เท่านั้น</p>
        <p class="text-sm">ราคาดังกล่าวเป็นราคาเฉพาะค่าสินค้า ตามสาขาที่ระบุในใบเสนอราคา โดยไม่รวมค่าขนส่งสินค้า ส่วนลดบัตรเครดิต และคูปองส่งเสริมการขาย</p>
      </div>
      
      <div class="flex justify-between items-center mt-12">
        <div class="text-center">
          <div class="border-t border-gray-400 w-48 mx-auto pt-1">
            <p class="font-medium">ผู้เสนอราคา</p>
          </div>
        </div>
        <div class="text-center">
          <div class="border-t border-gray-400 w-48 mx-auto pt-1">
            <p class="font-medium">ผู้อนุมัติ</p>
          </div>
        </div>
      </div>
    </div>
  `;
  
  printable.style.display = 'block';
  return printable;
}

function generatePDF() {
  const btn = document.getElementById('generatePdfBtn');
  const originalText = btn.innerHTML;
  
  btn.innerHTML = `
    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    กำลังสร้าง PDF...
  `;
  btn.disabled = true;
  
  const element = preparePrintable();
  
  html2canvas(element, {
    scale: 2, // Higher scale for better quality
    useCORS: true,
    logging: false,
    windowWidth: 1200, // Set a consistent width for rendering
    windowHeight: 1697 // A4 proportions (approximately)
  }).then(canvas => {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF({
      orientation: 'portrait',
      unit: 'mm',
      format: 'a4'
    });
    
    // Use full A4 page size (210mm x 297mm)
    const imgWidth = 210;
    const pageHeight = 297;
    const imgHeight = canvas.height * imgWidth / canvas.width;
    const imgData = canvas.toDataURL('image/png', 1.0); // Use maximum quality
    
    // Handle multi-page if content is longer than A4
    let heightLeft = imgHeight;
    let position = 0;
    
    // Add first page
    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
    heightLeft -= pageHeight;
    
    // Add additional pages if needed
    while (heightLeft > 0) {
      position = heightLeft - imgHeight;
      pdf.addPage();
      pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
      heightLeft -= pageHeight;
    }
    
    pdf.save("quotation.pdf");
    
    element.style.display = 'none';
    btn.innerHTML = originalText;
    btn.disabled = false;
  }).catch(error => {
    console.error("Error generating PDF:", error);
    alert("เกิดข้อผิดพลาดในการสร้าง PDF กรุณาลองใหม่อีกครั้ง");
    btn.innerHTML = originalText;
    btn.disabled = false;
    element.style.display = 'none';
  });
}

  </script>









<!-- Smooth Scrolling Script -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Get all smooth scroll buttons
    const smoothScrollButtons = document.querySelectorAll('.smooth-scroll-btn');
    
    // Add click event listener to each button
    smoothScrollButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Get the target section ID
        const targetId = this.getAttribute('data-target');
        const targetElement = document.getElementById(targetId);
        
        if (targetElement) {
          // Get the navbar height for offset (if you have a fixed navbar)
          const navbarHeight = document.querySelector('.navbar')?.offsetHeight || 0;
          
          // Calculate the target position with offset
          const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
          
          // Add a class to highlight the target section (optional)
          const highlightClass = 'scroll-highlight';
          document.querySelectorAll('.' + highlightClass).forEach(el => {
            el.classList.remove(highlightClass);
          });
          
          // Smooth scroll to the target
          window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
          });
          
          // Highlight the target section briefly
          setTimeout(() => {
            targetElement.classList.add(highlightClass);
            setTimeout(() => {
              targetElement.classList.remove(highlightClass);
            }, 2000);
          }, 500);
        }
      });
    });
  });
  

  // Get all smooth scroll buttons highlightTotal()
  

  function highlightTotal() { 
    const total = document.getElementById('totalSection');
    total.classList.add('scroll-highlightgreen');
    setTimeout(() => { 
      total.classList.remove('scroll-highlightgreen');
    },2000);
  }
</script>

<style>
  .scroll-highlightgreen{
    background-color: #22c55e;
  }
  /* Optional: Add a highlight effect for the target section */
  @keyframes highlightPulse {
    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
  }
  
  .scroll-highlight {
    animation: highlightPulse 1.5s ease-out;
  }
  
  <style>
  /* Optional: Add a highlight effect for the target section */
  @keyframes highlightPulse {
    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
  }
  
  .scroll-highlight {
    animation: highlightPulse 1.5s ease-out;
  }
  
  /* Ensure smooth scrolling for the entire page */
  html {
    scroll-behavior: smooth;
  }
  
  /* For browsers that don't support smooth scrolling natively */
  @media (prefers-reduced-motion: reduce) {
    html {
      scroll-behavior: auto;
    }
  }
</style>

















<!-- Messenger Float Button -->
<a href="https://m.me/816184855086392" target="_blank" rel="noopener noreferrer" id="messenger-float-btn" title="Chat with us on Messenger" style="position:fixed;bottom:24px;right:24px;width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#0695FF,#A334FA,#FF6968);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.25);z-index:9998;text-decoration:none;transition:transform 0.3s,box-shadow 0.3s;">
    <svg width="32" height="32" viewBox="0 0 36 36" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="M18 3C9.716 3 3 9.146 3 16.5c0 4.243 2.117 8.025 5.42 10.504V33l5.783-3.175c1.217.338 2.508.525 3.797.525 8.284 0 15-6.146 15-13.5S26.284 3 18 3zm1.488 18.182l-3.822-4.08-7.46 4.08 8.2-8.707 3.915 4.08 7.367-4.08-8.2 8.707z"/></svg>
</a>
</body>
</html>
