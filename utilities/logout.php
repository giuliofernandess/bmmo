<?php
// Página de Logout

session_start();

session_unset();

session_destroy();

echo "<script type ='text/javascript'>
    alert('Logout efetuado com sucesso!');
    </script>";

echo "<meta http-equiv='refresh' content='0; url=../pages/Index/index.php'>";

?>