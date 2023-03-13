const inputImage = document.getElementById('image');
const preview = document.getElementById('preview');

const placeholder = 'https://marcolanci.it/utils/placeholder.jpg';
inputImage.addEventListener('change', () => {
    if (inputImage.files && inputImage.files[0]) {
        let reader = new FileReader();
        reader.readAsDataURL(inputImage.files[0]);
        reader.onload = e => {
            preview.src = e.target.result;
        }
    } else preview.src = placeholder;
});