	
	<script type="text/javascript" language="javascript" src="../_tools/jquery-ui.js" charset="utf-8"></script>
   	<script>
		
		$(document).ready(function() {
			
			$(function() {
				$( ".sortable_lay" ).sortable({
					  connectWith: "ul" 
					});
				$( ".sortable_lay" ).disableSelection(); 
			 });
			
			var destinos = document.getElementById("destinos");
			var layout = document.getElementById("layout");		
			var destino; 
			
			var mapa_tela = layout.value.split("-");
			var mapa_linha = [];
			
			var mais = document.getElementById("mais");
		
			mais.onclick = function (){
				var prox = destinos.length+1;
				destino = cria_destino(prox);	
			} 
			
			function cria_destino(n){
				var dest = document.createElement("ul");
				dest.className = "sortable_lay destino";
				dest.id = "destino"+m;	
				destinos.appendChild(dest);
				
				$( dest ).sortable({
					connectWith: "ul",  
					update: function( event, ui ) {  
						
						if( $(this).children().length > 4){ 
							$( ".sortable_lay" ).sortable( "cancel" ); 
						}
						
						var saida = "";
						var arr;
										
						$( ".destino" ).each(function() {					
							arr = $( this ).sortable( "toArray" );
							if(arr.length > 0){
								saida += arr.join(",");
								saida += "-";
							}
						}); 
						 
						$( "#layout" ).val(saida);  
						 
					}
				});
				
				$( dest ).disableSelection();
				
				return dest;
			}
			
			for(var m=0; m<mapa_tela.length-1; m++){ // -1 para evitar que ultimo "-" gere uma linha fantasma
				 
				destino = cria_destino(m);
				
				mapa_linha = mapa_tela[m].split(",");
				
				for(var i=0; i<mapa_linha.length; i++){
					if(mapa_linha[i].length > 0 && document.getElementById(mapa_linha[i])){ // && verifica se o arquivo ainda existe
						var itm = document.getElementById(mapa_linha[i]);
						destino.appendChild(itm);
					}	
				}
			}  
			
	
		});
	
    </script>