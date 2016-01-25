<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("LEP - visitantes"); 
?>
<body>   
	
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 6, true); ?>
	 
    <div id="cont">
        <div id="dados">
        
            <?php

			mensagem();
			navega(array("VISITANTES REGISTRADOS"));
			
			$visitantes = sql_select( "visitantes","*","nome","",true );  
			
			titulo("","",false);

			form1("visitantes", "", "", "post");  
				
				ul1("itens",false);

				for($i=0; $i<count($visitantes); $i++){ 

					$nome = $visitantes[$i]["nome"]; 
					$email = $visitantes[$i]["email"]; 
					$profissao = $visitantes[$i]["profissao"]; 
					$ativo = $visitantes[$i]["ativo"]; 

					$checked = '';
					if($ativo==1) $checked = "checked='checked'";

					$id = $visitantes[$i]["id"];
					$tb = '_layout/ico_visitante.png';
					$lb = '';
					$lb_ext = "<label class='pointer' for='ativo".$id."'>".$id.". ".$nome." &lt;".$email."&gt; _ ".$profissao."</label>";
					$cb = "<input name='ativo".$id."' value='0' type='hidden' />";
					$cb .= "<input class='user_ativo' type='checkbox' name='ativo".$id."' id='ativo".$id."' value='1' ".$checked."/> ";
					$link = false; 
					
					$bts = array( array( "del", "php/visitante_remove.php?id=".$id ) ); 

					item('item'.$id, $tb, $lb, $lb_ext.$cb, $link, $bts, false);
						
				}

				ul2(); 
 			
			div1("visitantes_bts","","",false);
			
			btg("gravar_visitantes","btm","GRAVAR","");
			btg("exportar_csv","btm","GERAR CSV","");

			div2(); 

			form2(); 
			
			?>  
			
			<script type="text/javascript">
			
				var visitantes = document.getElementById('visitantes');
				var gravar_visitantes = document.getElementById('gravar_visitantes');
				var exportar_csv = document.getElementById('exportar_csv');
				
				gravar_visitantes.onclick = function(){
					visitantes.action = "php/visitantes_altera.php";
					visitantes.submit();
				} 
				
				exportar_csv.onclick = function(){ 
					visitantes.action = "php/visitantes_csv.php";
					visitantes.submit();
				}
			
			</script>
			
			
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
