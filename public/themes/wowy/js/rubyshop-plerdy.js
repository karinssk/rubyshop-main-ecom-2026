var _protocol = document.location.protocol === 'https:' ? 'https://' : 'http://';
_site_hash_code = 'ee0d40fa038e694125ac92628dfd5c8e';
_suid = 77295;
var plerdyScript = document.createElement('script');
plerdyScript.setAttribute('defer', '');
plerdyScript.dataset.plerdymainscript = 'plerdymainscript';
plerdyScript.src = 'https://a.plerdy.com/public/js/click/main.js?v=' + Math.random();
var plerdymainscript = document.querySelector("[data-plerdymainscript='plerdymainscript']");
plerdymainscript && plerdymainscript.parentNode.removeChild(plerdymainscript);
try {
    document.head.appendChild(plerdyScript);
} catch (t) {
    console.log(t, 'unable add script tag');
}
