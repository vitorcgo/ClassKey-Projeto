// Inicialização do Flickity
const carousel = document.querySelector('.carousel');
const flickity = new Flickity(carousel, {
  groupCells: 5, // Exibe 5 cards por vez
  wrapAround: true, // Faz o looping dos cards
  prevNextButtons: false, // Desativa os botões de navegação automáticos
});

// Controlar o avanço dos cards ao clicar na seta à direita
document.querySelector('.next-btn').addEventListener('click', function () {
  flickity.next();
});

// Controlar o retroceder dos cards ao clicar na seta à esquerda
document.querySelector('.prev-btn').addEventListener('click', function () {
  flickity.previous();
});