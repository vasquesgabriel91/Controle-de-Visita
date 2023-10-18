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

  fabrica.addEventListener('change', () => {

      const isChecked = fabrica.checked;
      area_visita.classList.toggle("display-flex", isChecked);
      area_da_Visita.classList.toggle("display-flex", isChecked);
      area_da_Visita.value = '';

  });

  });



