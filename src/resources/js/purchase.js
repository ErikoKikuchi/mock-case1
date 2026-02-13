import '../css/purchase.css';

//選択した支払方法を即時表示のためのjavascript
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('payment_method_select');
    const display = document.getElementById('selected_payment_display');

    if (!select || !display) return;

    select.addEventListener('change', function() {
        const selectedOption = select.options[select.selectedIndex];
        const labelHtml = '<p class="label">支払方法</p>';
        display.innerHTML = labelHtml + '<p>' + selectedOption.text + '</p>';
    });
});