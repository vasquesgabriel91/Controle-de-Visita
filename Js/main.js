function addInput_e_RemoverIput() {

  const nome = document.getElementById("nome").value;
  const celular = document.getElementById("celular").value;
  const email = document.getElementById("email").value;
  const periodo_visita_de = document.getElementById("periodo_visita_de").value;

  const enviar = document.getElementById("btn-enviar");
  enviar.disabled = true;

  if (!nome || !periodo_visita_de) {
    alert("Preencha o nome e a data da entrevista antes de adicionar.");

    return; // Não continue se algum campo estiver vazio
    
  }else{

    const labelName = document.createElement("label");
    labelName.className = "label-css";
    labelName.innerHTML = "Nome:";

    const labelCelular = document.createElement("label");
    labelCelular.className = "label-css";
    labelCelular.innerHTML = "Celular:";

    const labelEmail = document.createElement("label");
    labelEmail.className = "label-css";
    labelEmail.innerHTML = "Email:";

    const labelPeriodoVisita = document.createElement("label");
    labelPeriodoVisita.className = "label-css";
    labelPeriodoVisita.innerHTML = "Data da entrevista:";

    const inputNome = document.createElement("input");
    inputNome.type = "text";
    inputNome.name = "nome[]";
    inputNome.value = nome;
    inputNome.className = "input-css m-2";

    const inputCelular = document.createElement("input");
    inputCelular.type = "text";
    inputCelular.name = "celular[]";
    inputCelular.value = celular;
    inputCelular.className = "input-css mb-4";

    const inputEmail = document.createElement("input");
    inputEmail.type = "text";
    inputEmail.name = "email[]";
    inputEmail.value = email;
    inputEmail.className = "input-css m-2";

    const inputPeriodoVisita = document.createElement("input");
    inputPeriodoVisita.type = "datetime-local";
    inputPeriodoVisita.name = "periodo_visita_de[]";
    inputPeriodoVisita.value = periodo_visita_de;
    inputPeriodoVisita.className = "input-css mb-4";

    enviar.disabled = false;

    myForm.appendChild(labelName);
    myForm.appendChild(inputNome);
    myForm.appendChild(labelCelular);
    myForm.appendChild(inputCelular);

    myForm2.appendChild(labelEmail);
    myForm2.appendChild(inputEmail);
    myForm2.appendChild(labelPeriodoVisita);
    myForm2.appendChild(inputPeriodoVisita);
    

    // btn remover
    const removeButton = document.createElement("div");
    removeButton.className = "btn btn-danger d-flex align-items-center";
    removeButton.innerHTML = '<i class="fa-solid fa-minus" style="color: #ffffff;"></i>';

    const removeBtnContainer = document.getElementById("remove-btn");
    removeBtnContainer.appendChild(removeButton);

    removeButton.addEventListener("click", function () {

      myForm.removeChild(labelName);
      myForm.removeChild(labelCelular);
      myForm2.removeChild(labelEmail);
      myForm2.removeChild(labelPeriodoVisita);

      myForm.removeChild(inputNome);
      myForm.removeChild(inputCelular);
      myForm2.removeChild(inputEmail);
      myForm2.removeChild(inputPeriodoVisita);
      removeBtnContainer.removeChild(removeButton);

      // Verificar se há elementos no formulário
    const formElements = myForm.querySelectorAll("input, label");
    const form2Elements = myForm2.querySelectorAll("input, label");

    //Desabilitar o botão de envio
    if (formElements.length === 0 && form2Elements.length === 0) {
      enviar.disabled = true;
    }

    });
  }
}
document.getElementById("btnAdd").addEventListener("click", addInput_e_RemoverIput);





