import '../css/exhibition.css';


document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('image');
    const previewImg = document.getElementById('productPreview');

    if (!fileInput || !previewImg) return;
    const allowedTypes = ['image/jpeg', 'image/png'];
    const maxSize = 10 * 1024 * 1024;

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files?.[0];
        if (!file) return;

        if (!allowedTypes.includes(file.type)) {
            alert('JPEG, PNG形式の画像を選択してください');
        fileInput.value = '';
        previewImg.src = '';
        previewImg.classList.add('is-hidden');
        return;
        }
        if (file.size > maxSize) {
            alert('10MB以下の画像を選択してください');
            fileInput.value = '';
            previewImg.src = '';
            previewImg.classList.add('is-hidden');
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result;
            previewImg.classList.remove('is-hidden');
        };
        reader.readAsDataURL(file);
    });
});
