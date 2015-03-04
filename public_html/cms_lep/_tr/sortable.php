	
     
	<script type="text/javascript" language="javascript" src="../_tools/jquery-ui.js" charset="utf-8"></script>
   	<script>
		
		$(document).ready(function() {  
		
			var layout = document.getElementById("layout");
			var itens = document.getElementById("itens");
			var layout_altera = document.getElementById("layout_altera");
			var lixo = document.getElementById("lixo");
			var itm; 
			
			function layout_att(){ 
				var sortedIDs = [];
				
				$("#itens").children().each( function(){
					sortedIDs.push(this.id);
				});
				
				layout.setAttribute("value", sortedIDs); 
			}
			
			if(layout.value != ""){
				var layout_arr = layout.value.split(","); 
				console.log(layout_arr);
				
				for(var i=0; i<layout_arr.length; i++){ 
					
					if(layout_arr[i] != ""){ // elimina eventuais "," vazios 
						
                        if(document.getElementById(layout_arr[i])){ // caso um banner seja removido, não trava nesse ponto
                           
							itm = document.getElementById(layout_arr[i]);	
							console.log(itm);
                            itens.appendChild(itm);
                        }
                   
                    }
					 
				}
				
				//caso haja algum banner faltando, o att remove do input layout
				layout_att();
				
			} 
				
			$( "#itens" ).sortable({ 
				handle: ".handle", 
				connectWith: ".sortable",
				update: function( event, ui ) {  
					layout_att(); 
					layout_altera.submit();
				} 
		  
			}).disableSelection();   
			 
			// page Y
		 
			window.onload = function(){  

				$('#mensagem').delay(2000).fadeOut(1000);   

				var get = document.location.href.split('pagey=');  
				if(get[1] > 0){  
					window.scrollTo(0, get[1]);
				}
			}

			var pagey = 0;
			var pagey_out = document.getElementById('pagey_out');
			console.log(pagey_out);

			window.onscroll = function(){
				pagey = document.body.scrollTop || document.documentElement.scrollTop;
				pagey_out.value = pagey;	
			}  

			
		  
		});  
		
		
		

	
    </script>