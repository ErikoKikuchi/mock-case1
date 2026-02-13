import '../css/profile-edit.css';
//画像の差し替え
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('image');
    const selectButton = document.getElementById('selectImageButton');
    const previewImg = document.getElementById('profilePreview');

    if (!fileInput || !selectButton || !previewImg) return;

    const allowedTypes = ['image/jpeg', 'image/png'];
    const maxSize = 10 * 1024 * 1024;

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        if (!allowedTypes.includes(file.type)) {
            alert('JPEG, PNG形式の画像を選択してください');
        fileInput.value = '';
        return;
        }
        if (file.size > maxSize) {
            alert('10MB以下の画像を選択してください');
            fileInput.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImg.src = e.target.result; // 左側画像差し替え
        };
        reader.readAsDataURL(file);
    });
});