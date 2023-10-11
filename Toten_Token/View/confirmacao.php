<?php 
session_start();
require_once 'Side_Bar_Toten.php';
// require_once '../DB_Query_Portaria_Toten/portaria.php';

 echo $mensagemAprovada = $_SESSION['MensagemPortaria'];

?>


<div class="d-flex flex-row justify-content-center align-items-center bg-danger col">
    <div class="progresso ">
        <div class="progress-bar <?php echo (!empty($mensagemAprovada)) ? 'width' : ''; ?> "></div>
    </div>
    <p>swdergfhjk</p>
</div> 