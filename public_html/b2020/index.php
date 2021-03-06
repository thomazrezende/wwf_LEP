<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("../cms/_tr/mysql.php");
require_once("../cms/_tr/html.php");

conectar();
sessao();

verif_log();

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>PLATAFORMA B2020</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="pt-br" />
	<meta name="robots" content="noindex, nofollow">
	<link rel="shortcut icon" href="layout/fav_icon.png" type="ico" />

	<script type="text/javascript" src="tools/d3.min.js"></script>
	<script type="text/javascript" src="tools/c3.min.js"></script>
	<script type="text/javascript" src="tools/jquery-2.0.2.min.js"></script>
	<script type="text/javascript" src="tools/jquery-ui.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

  	<link rel="stylesheet" type="text/css" href="b2020.css">
	<link href="tools/c3.css" rel="stylesheet" type="css">
	<script type="text/javascript" src="b2020.js" charset="UTF-8"></script>

</head>
<body>

	<div id="preloader"></div>
	<div id="alerta">
		<div id="alerta_tx"></div>
		<div id="alerta_ok">OK</div>
	</div>

	<div class="barra" id="topo">
		<img src="layout/logo.jpg" id="logo"/>
		<div class="bt" id="logout"></div>
		<div id="user">
			<div id="user_lb"><?php print strtoupper($_SESSION["user_name"]); ?></div>
		</div>
	</div>

	<div class="painel" id="lista">
		<div class="bt" id="bt_lista"></div>
		<div class="bt" id="bt_camadas"></div>
		<div class="painel_topo" id="painel_select" style="color:#D89D28">BACIAS HIDROGR&Aacute;FICAS</div>

		<ul id="lista_itens">
			<li id="lista_item1" cod="bh" class="lista_item selected" >BACIAS HIDROGR&Aacute;FICAS</li>
			<li id="lista_item2" cod="ap" class="lista_item" >&Aacute;REAS PRIORITÁRIAS</li>
			<li id="lista_item3" cod="uc" class="lista_item" >UNIDADES DE CONSERVA&Ccedil;&Atilde;O</li>
			<li id="lista_item4" cod="ti" class="lista_item" >TERRAS IND&Iacute;GENAS</li>
			<li id="lista_item5" cod="no" class="lista_item" >CAMADAS EXTRA</li>
		</ul>

		<div id="camadas_cont">
			<div class="painel_topo lock">CAMADAS</div>
			<div class="cont">
				<ul id="lista_camadas"></ul>
			</div>
		</div>

		<div class="cont" id="lista_cont">

			<div class="painel_cont selected" id="painel_cont1">
				<ul id="lista_bh"></ul>
			</div>

			<div class="painel_cont" id="painel_cont2">
				<ul id="lista_ap"></ul>
			</div>

			<div class="painel_cont" id="painel_cont3">
				<ul id="lista_uc"></ul>
			</div>

			<div class="painel_cont" id="painel_cont4">
				<ul id="lista_ti"></ul>
			</div>

			<div class="painel_cont" id="painel_cont5">
				<ul id="lista_no"></ul>
			</div>

		</div>
	</div>

	<div class="painel" id="dash">

		<ul id="tipo">
			<li class="bt_tipo selected" id="tipo_satelite">SAT&Eacute;LITE</li>
			<li class="bt_tipo " id="tipo_satelite">H&Iacute;BRIDO</li>
			<li class="bt_tipo " id="tipo_terreno">TERRENO</li>
			<li class="bt_tipo " id="tipo_mapa">MAPA</li>
		</ul>

		<div id="zoom">
			<div class="bt" id="zoom_in"></div>
			<div class="bt" id="zoom_out"></div>
		</div>

		<div id="dash_voltar"></div>

		<div class="painel_topo" id="dash_topo">
			<div id="dash_titulo"></div>
		</div>

		<div class="cont" id="dash_cont"></div>

	</div>

	<div class="barra" id="base">
		<div id="base_lb">N&Iacute;VEL DE SELE&Ccedil;&Atilde;O:</div>
		<ul id="nivel">
			<li id="nivel1" class="nivel_item selected" >BACIAS<br>HIDROGR&Aacute;FICAS</li>
			<li class="nivel_div"></li>
			<li id="nivel2" class="nivel_item " >&Aacute;REAS<br>PRIORITÁRIAS</li>
			<li class="nivel_div"></li>
			<li id="nivel3" class="nivel_item" >UNIDADES DE CONSERVA&Ccedil;&Atilde;O</li>
			<li class="nivel_div"></li>
			<li id="nivel4" class="nivel_item " >TERRAS<br>IND&Iacute;GENAS</li>
			<li class="nivel_div"></li>
			<li id="nivel5" class="nivel_item " >CAMADAS<br>EXTRA</li>
		</ul>
	</div>

	<div id="mapa"></div>

</body>
</html>
