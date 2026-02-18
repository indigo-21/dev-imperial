const BASE_URL = $("body").attr("base_url");
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function currencyFormat(num){
    let currency = 0.00;
    if(num){
        currency = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(num);
    }
    return currency;
}
function formatPO(num) {
    return num ? "PO-" + String(num).padStart(5, '0') : "-";
}