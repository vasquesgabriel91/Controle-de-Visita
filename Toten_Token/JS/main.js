//TECLADO VIRTUAL FUNCTION TELA PORTARIA 
const Keyboard = window.SimpleKeyboard.default;

const input = document.getElementById('pesquisar');
const keyboardDiv = document.querySelector('.simple-keyboard');

input.addEventListener('click', function() {
  keyboardDiv.classList.toggle('simple-keyboard-flex');
});

const myKeyboard = new Keyboard({
  onChange: input => onChange(input),
  onKeyPress: button => onKeyPress(button)
});

function onChange(input) {
  document.querySelector(".input").value = input;
  console.log("Input changed", input);
}

function onKeyPress(button) {
  console.log("Button pressed", button);
}

