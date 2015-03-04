	 
	<script type="text/javascript" language="javascript" src="../_tools/jquery-ui.js" charset="utf-8"></script>
   	<script>
		
		$(document).ready(function() {
			
			$(function() {  
				$( ".sortable_tag" ).sortable({ handle: ".handle", 
					update: function( event, ui ) { 
					
						var sortedIDs = $( ".sortable_tag" ).sortable( "toArray" );
						var itemIDs = [];
						
						for(var i=0; i<sortedIDs.length; i++){
							itemIDs.push(sortedIDs[i].split("tag")[1]);				
						}
						
						var loc = window.location.href.split("?"); 
						window.location.replace("php/tags_ordem_altera.php?ids=" + itemIDs); 
				
					} });
					
				$( ".sortable_tag" ).disableSelection();
			  }); 
		});
	
    </script>