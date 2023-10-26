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


// Faz a pesquisa na Tabela
// $(document).ready(function() {
//   $("#searchInput").on("input", function() {
//     var searchTerm = $(this).val().toLowerCase();
//     var $tableRows = $("tbody tr"); 
//     $tableRows.hide(); // Oculta todas as linhas inicialmente

//     $tableRows.filter(function() {
//       // Verifique se o texto na coluna "Nome" da linha corresponde ao termo de pesquisa
//       return $(this).find("span[data-column='nome']").text().toLowerCase().indexOf(searchTerm) > -1;
//     }).show(); // Mostra as linhas que correspondem ao termo de pesquisa
//   });
let table = new DataTable('#myTable',{
  responsive: true,
  searching: true,
  responsive: true,
  lengthChange: false,
  autoWidth: true,
  bPaginate: true,
});