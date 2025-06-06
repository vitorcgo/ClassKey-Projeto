const input = document.getElementById('imagemInput');
const preview = document.getElementById('preview');

input.addEventListener('change', function() {
  const file = this.files[0];

  if (file) {
    const reader = new FileReader();

    reader.addEventListener('load', function() {
      preview.innerHTML = `<img src="${this.result}" alt="Preview da imagem">`;
    });

    reader.readAsDataURL(file);
  } else {
    preview.innerHTML = '<span>Nenhuma imagem selecionada</span>';
  }
});