	
     
	<script type="text/javascript" language="javascript" src="../_tools/jquery-ui.js" charset="utf-8"></script>
   	<script>
		
		$(document).ready(function() { 
			
			$(function() {  
				$( ".sortable_arq" ).sortable({ handle: ".handle", 
					update: function( event, ui ) { 
					
						var sortedIDs = $( "#arquivos" ).sortable( "toArray" );
						var itemIDs = [];
						
						for(var i=0; i<sortedIDs.length; i++){
							itemIDs.push(sortedIDs[i].split("item")[1]);				
						}
						
						var loc = window.location.href.split("?"); 
						window.location.replace("php/proj_layout_altera.php?ids=" + itemIDs); 
				
					} });
					
				$( ".sortable_arq" ).disableSelection();
			  }); 
		});
	
    </script>