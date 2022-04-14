<?php
if(!isset($_SESSION) || !isset($_SESSION['codigo_empresa'])){
	echo "<script>location.href = '../index.php';</script>";
}
?>
<h3>Relatório de XMLs</h3>
<div id="relatorios">
	<div id="display-menu">

    </div>
    <div>
   		<div class='table-responsive'><table class='table table-hover'><tr><th>#</th><th>ARQUIVO</th><th>CANCELADO</th></tr>
            <tbody>
                <tr><td></td><td></td><td></td></tr>
            </tbody></table>
        </div>

    </div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
