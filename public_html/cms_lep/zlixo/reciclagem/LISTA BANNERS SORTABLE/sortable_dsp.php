	
	<script type="text/javascript" language="javascript" src="../_tools/jquery-ui.js" charset="utf-8"></script>
   	<script>
		
		$(document).ready(function() {
			
			$(function() {
				$( ".sortable_dsp" ).sortable({
					  connectWith: "ul" 
					});
				$( ".sortable_dsp" ).disableSelection(); 
			 });
			
			var destinos = document.getElementById("destinos");
			var display = document.getElementById("display");		
			var destino; 
			
			var mapa_tela = display.value.split("-");
			var mapa_linha = [];
			
			var mais = document.getElementById("mais");
		
			mais.onclick = function (){
				var prox = destinos.length+1;
				destino = cria_destino(prox);	
			}  
			
			function cria_destino(n){
				var dest = document.createElement("ul");
				dest.className = "sortable_dsp destino";
				dest.id = "destino"+m;	
				destinos.appendChild(dest);
				
				$( dest ).sortable({
					connectWith: "ul",  
					update: function( event, ui ) {  
						
						if( $(this).children().length > 4){ 
							$( ".sortable_dsp" ).sortable( "cancel" ); 
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
						
						saida = saida.substring(0,saida.length-1); // remove o ultimo "-"
						 
						$( "#display" ).val(saida); 
						 
					}
				});
				
				$( dest ).disableSelection();
				
				return dest;
			}
			
			for(var m=0; m<mapa_tela.length; m++){ 
				 
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