<!doctype html>
<html>
	<head> 

		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

		<title>WWF:LEP PROJETO <?php print $_GET['id']; ?></title> 
		
		<meta name="title" content="WWF :: LEP PSC" />
		<meta name="description" content="WWF LEP :: LABORATÓRIO DE ECOLOGIA DA PAISAGEM - PLANEJAMENTO SISTEMÁTICO DE CONSERVAÇÃO" />
		<meta name="Author" lang="pt" content="Thomaz Rezende" />
		<meta name="Date-Creation-yyyymmdd" content="2014-11-10" lang="pt" />
		<meta name="Keywords" lang="pt" content="wwf lep psc laboratório ecologia paisagem planejamento sistematico conservação preservação brasil recursos naturais" />
		<meta name="revisit-after" content="7 Days" />
		<meta name="copyright" content="WWF BRASIL" />
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">

		<meta property="og:title" content="WWF : LEP PSC">
		<meta property="og:url" content="http://paisagem.wwf.org.br/projeto.php?id=<?php print $_GET['id']; ?>"> 	
		<meta property="og:description" content="WWF LEP :: LABORATÓRIO DE ECOLOGIA DA PAISAGEM - PLANEJAMENTO SISTEMÁTICO DE CONSERVAÇÃO">
		<meta property="og:image" content="http://paisagem.wwf.org.br/_layout/wwf_lep1.jpg"/>
		<meta property="og:image" content="http://paisagem.wwf.org.br/_layout/wwf_lep2.jpg"/>
		<meta property="og:image" content="http://paisagem.wwf.org.br/_layout/wwf_lep3.jpg"/>
		<meta property="og:image" content="http://paisagem.wwf.org.br/_layout/wwf_lep4.jpg"/>
		<meta property="og:image" content="http://paisagem.wwf.org.br/_layout/wwf_lep5.jpg"/> 
		<meta property="og:image:type" content="image/jpg">
		<meta property="og:image:width" content="200">
		<meta property="og:image:height" content="200">

		<link rel="shortcut icon" href="_layout/fav_icon.png" type="ico" />
		<link rel="image_src" href="http://paisagem.wwf.org.br/_layout/wwf_lep1.jpg" />  

		<script type="text/javascript" src="_tools/jquery-2.0.2.min.js"></script>
		<script type="text/javascript" src="_tools/jquery.easing.js"></script>
		<script type="text/javascript" src="_tools/jquery.form.js"></script>
		<script type="text/javascript" src="_tools/jquery.scrollTo-min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.3&sensor=false"></script>
		<script type="text/javascript" src="wwf_lep_projeto.js" charset="UTF-8"></script> 

		<link rel="stylesheet" type="text/css" href="_tools/reset.css"> 
		<link rel="stylesheet" type="text/css" href="wwf_lep.css"> 
		
	</head>
	<body>

		<div id="registro_user">
			<div class="bt_item" id="registro_x"></div>
			<div id="registro_tx">Ol&aacute;&period; Gostar&iacute;amos de saber mais sobre voc&ecirc;&period; Por favor&comma; preencha os campos abaixo para que possamos aprimorar nosso trabalho&period;</div>
			<form id="registro_form" method="post" action="registro_user.php">
				<input type="text" class="input_tx" name="nome" id="registro_nome" placeholder="NOME"/>
				<input type="text" class="input_tx" name="profissao" id="registro_profissao" placeholder="PROFISSÃO/GRAU DE ESCOLARIDADE"/>
				<input type="text" class="input_tx" name="email" id="registro_email" placeholder="E-MAIL"/>
				<div id="news">	
					<input type="checkbox" name="news" id="news_cb" value="1"/>
					<label for="news_cb">Desejo receber notifica&ccedil;&otilde;es sobre atualiza&ccedil;&otilde;es deste portal</label>
				</div>
				<input id="enviar" type="submit" value="ENVIAR"/>
			</form>
			<div id="registro_cancel">N&Atilde;O TENHO INTERESSE</div>
		</div>
		
		<div id="projeto"></div>
		
		<!-- GOOGLE ANALYTICS -->
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); 
		  ga('create', 'UA-61927662-1', 'auto');
		  ga('send', 'pageview'); 
		</script>
		
	</body>
</html>
