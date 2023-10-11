// DARK MODE FUNCTIONS
const mudarThema = document.querySelector("#mudar-thema") ;

function toggleDarkMode(){
  document.body.classList.toggle("dark"); 
}

function loadTheme(){

const darkMode = localStorage.getItem("dark");

  if(darkMode){
    toggleDarkMode();
  }
}

loadTheme();

mudarThema.addEventListener("change", function(){
  toggleDarkMode();

    // salva ou remove o dark mode
  localStorage.removeItem("dark");

  if(document.body.classList.contains("dark")){
    localStorage.setItem("dark", 1);
  }
});


// FUNCTION PARA TRATAMENTO DO INPUT RADIO DA TELA SOLICITACAO.PHP
document.addEventListener('DOMContentLoaded', () => {
  
  const fabrica = document.querySelector("#acesso_fabrica");
  const area_da_Visita = document.querySelector("#area_da_visita");
  const area_visita = document.querySelector("#area_visita");

  const estacionamento = document.querySelector("#acesso_estacionamento");
  const label_carro= document.querySelector("#label_carro");
  const placa = document.querySelector("#placa_carro");
  const label_modelo = document.querySelector("#label-modelo");
  const carro = document.querySelector("#modelo_carro");

  fabrica.addEventListener('change', () => {

      const isChecked = fabrica.checked;
      area_visita.classList.toggle("display-flex", isChecked);
      area_da_Visita.classList.toggle("display-flex", isChecked);
      area_da_Visita.value = '';

  });

  estacionamento.addEventListener('change', () => {

    const isChecked2 = estacionamento.checked;
    label_carro.classList.toggle("display-flex", isChecked2);
    placa.classList.toggle("display-flex", isChecked2);
    label_modelo.classList.toggle("display-flex", isChecked2);
    carro.classList.toggle("display-flex", isChecked2);
    placa.value = '';
    carro.value = '';
    
  });

});







