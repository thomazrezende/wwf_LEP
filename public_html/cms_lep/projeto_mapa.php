<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("PROJETO - MAPA");    
?>

<body>
    
	<style type="text/css">
		
		#mapa_painel{
			width:100%;
			padding-top: 20px;
			background:#eee;
			border:#eee 1px solid;
			margin-top:30px;
		}
		
		.mapa_lb{
			width:10%;
			text-align:right;
			float:left;
			color:#999;
			margin-top:7px;
			text-align:center;
			overflow:hidden;
		}	
		
		.input3{ 
			width:20%;
			padding:5px;
			border:#ddd 1px solid;
			font-size:12px;
			float: left;
		}
		
		.mapa{
			background:#ccc;
			width:100%;
			height:300px;
			margin-top:20px;
		}
		
		.mr0{margin-right:0;}
	
	</style>
	
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php
 
			//dados 
			$id = $_SESSION["id"];
			$titulo = $_SESSION["titulo"];
			
			//SQL
			$dados = sql_select("projetos","*","","id=".$id,false);   
			
			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] )); 

			submenu( $submenu_projeto, 2 );
			
			form1("altera", "", "php/projeto_mapa_altera.php", "post");
				
				div1("mapa_painel","","", false);

					div1( "lat_lb", "mapa_lb", "LAT:", true );
					input("centro_lat", "input3", "centro_lat", $dados["centro_lat"] , "text"); 

					div1( "lat_lb", "mapa_lb", "LNG:", true );
					input("centro_lng", "input3", "centro_lng", $dados["centro_lng"] , "text"); 

					div1( "lat_lb", "mapa_lb", "ZOOM:", true );
					input("centro_lng", "input3 mr0", "centro_lng", $dados["centro_lng"] , "text"); 	

					clear();

					div1( "map_canvas", "mapa", "" , true );

				div2();
					
				submit("GRAVAR"); 
						
			form2();
			

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
