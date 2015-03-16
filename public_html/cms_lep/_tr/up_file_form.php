		<style> 
		.up_file_form{margin-bottom:10px;}
        .progress { position:relative; width:100%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; margin-top:10px }
        .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:5px; width:100%; text-align:center; font-size:10px;}
		.drop_area{
			padding:10px;
			width:100%;
			height:130px;
			background-repeat:no-repeat;
			background-position:center;
			background-color:#f0f0f0;
		} 
		.multiple{		
			background-image:url(_layout/drop_area_m.png);
		} 
		.single{			
			background-image:url(_layout/drop_area_s.png);	
		}
		
        </style> 
      
        <script>  
		
       $( document ).ready (function() {  
	    	
		function location(msg){
			
			var loc = window.location.href.split("?");  
			
			var gets_out = "";
			
			if(loc.length > 1){
				var gets = loc[1].split("&");
				
				for(var g=0; g<gets.length; g++){ 
					if(gets[g].substring(0,3) != "msg"){ 
						gets_out += gets[g] + "&";
					}
				}
			}
			
			window.location.replace(loc[0] + "?" + gets_out + msg); 
			 
		}
			
		$('.drop_area').change( function(){
			
			var lista = this.getAttribute("lista").split(","); 
			var files = this.files;
			var pass = true;
			 
			if(lista[0] != "all"){
				for(var f=0; f<files.length; f++){
					if( lista.indexOf(getExtension(files[f]["name"])) == -1 ){
						pass = false;
					}
				}	
			}
			
			if(pass) {
				$('.up_file_form').submit();
			}else{
				location("msg_erro=FORMATO DE ARQUIVO INVÁLIDO");
			}
			
		});
		
		function getExtension(filename) {
			var parts = filename.split('.');
			return parts[parts.length - 1].toLowerCase();
		} 
		
        var bar = $('.bar');
        var percent = $('.percent');
           
        $('.up_file_form').ajaxForm({
            beforeSend: function() {
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
                //console.log(percentVal, position, total);
            },
				success: function() {
					var percentVal = '100%';
					bar.width(percentVal)
					percent.html(percentVal);
				},
				complete: function() { 
					location("msg_ok=UPLOAD REALIZADO COM SUCESSO");
				}
		  }); 
		
		});    
		
		</script>