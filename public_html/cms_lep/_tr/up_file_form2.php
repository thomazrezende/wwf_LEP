		<style> 
		.up_file_form{ width:100%; clear:both; height:40px; background:#f0f0f0; padding:12px; margin-bottom:2px; border-radius:3px; position:relative; }
		.up_file_form input{ width:35%; float:left}
        .progress { position:absolute;  top:8px; right:10px; width:60%; border: 1px solid #ddd; padding: 1px; border-radius: 3px; background:#fff;    }
        .bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
        .percent { position:absolute;  top:5px; width:100%; text-align:center; font-size:10px;} 
		
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
			
			 // verifica arquivo existente / repetitdo
			
		});
		
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
				location("msg_ok=ENVIANDO ARQUIVO " + pos + ": " + percentVal );
            },
			success: function() {
				var percentVal = '100%';
				bar.width(percentVal)
				percent.html(percentVal);
			},
			complete: function() { 
				location("msg_ok=UPLOAD " + pos + " REALIZADO COM SUCESSO");
				setTimeout(function(){
					next_upload();
					}
				},2000);
			}
		  });  
		});   
			
		// sequential upload
		
		function next_upload(){ 
			if(pos<10){
				pos++;

				prox_arquivo = document.getElementById('arquivo'+pos);
				prox_form = document.getElementById('form'+pos);

				if(prox_arquivo.val){
					prox_form.submit();
				}else{
					next_upload();
				}	
			}else{
				location("msg_ok=UPLOAD COMPLETO");
			}	
		}
			
		var pos = 0; // campo inicial
		var prox_arquivo;
		var prox_form; 
			
			
		</script>