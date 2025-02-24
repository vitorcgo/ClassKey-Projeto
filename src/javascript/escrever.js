const textElement = document.getElementById("escrever");
const texts = [
  "UM CLIQUE DE DISTANCIA!.",
  "UM CODIGO DE ATIVAÇÃO!.",
  "A SEGUNDOS DA SUA TELA!.",
  "UMA KEY DE VOCÊ!.",
  "UM CLIQUE DE JOGAR!.",
];
let textIndex = 0;
let charIndex = 0;
let isDeleting = false;
function typeWriter() {
  const currentText = texts[textIndex];
  if (isDeleting) {
    textElement.innerHTML = currentText.substring(0, charIndex--);
  } else {
    textElement.innerHTML = currentText.substring(0, charIndex++);
  }
  let speed = isDeleting ? 50 : 100; // Velocidade ao apagar/digitar - Vitor
  if (!isDeleting && charIndex === currentText.length) {
    speed = 1500; // Pausa antes de apagar - Vitor
    isDeleting = true;
  } else if (isDeleting && charIndex === 0) {
    isDeleting = false;
    textIndex = (textIndex + 1) % texts.length; // Alterna frases em loop - Vitor
  }
  setTimeout(typeWriter, speed);
}
typeWriter();
