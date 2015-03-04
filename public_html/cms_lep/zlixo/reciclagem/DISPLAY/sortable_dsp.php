	
	<script type="text/javascript" language="javascript" src="../_tools/jquery-ui.js" charset="utf-8"></script>
   	<script>
		
		$(document).ready(function() {
			
			var m;
			var modulo_itens = []; 
			var modulo; 
			var saida = "";
						
			var layout = document.getElementById("layout");
			var modulos_in = layout.value.split("-");

			// modulos in
			
			for( m=0; m<=1; m++){  
			
				modulo = document.getElementById("modulo" + m);
				if(modulos_in[m]){ // se o segundo modulo existir
					modulo_itens = modulos_in[m].split(",");
					
					for(var i=0; i<modulo_itens.length; i++){
						if(modulo_itens[i].length > 0 && document.getElementById(modulo_itens[i])){ // && verifica se o arquivo ainda existe
							var itm = document.getElementById(modulo_itens[i]);
							modulo.appendChild(itm);
						}	
					}
				}
			}  

			// sortable / update
			
			$(function() {
				$( ".sortable_dsp" ).sortable({
					  	connectWith: "ul"  
				}); 
				
				$( ".sortable_dsp" ).disableSelection(); 
				
				$( ".destino" ).sortable({
					  
					 update: function( event, ui ) { 
					 
					 		console.log($(this).children().length);
						
							if( $(this).children().length > 4){ 
								$( ".sortable_dsp" ).sortable( "cancel" ); 
							}else{ 
								saida = "";
								for( m=0; m<=1; m++){   
									modulo_itens = $( "#modulo"+m ).sortable( "toArray" );  
									saida += modulo_itens.join(","); 
									if(m == 0) saida += "-"; 
								} 	 
								layout.value = saida;
							}  			
						} 
					});   
			 
			 }); 
	
		});
	
    </script>