window.onload = function (){ 
	
	
	var page_y;
	var win_w;
	var win_h;
	
	var root = location.origin;
	var path = location.pathname.split('/');
	
	for(i=0; i<path.length-1; i++){
		root +=  path[i] + '/';
	} 
	
	console.log("_root: " + root);
	
	// window funcs //
	
	window.onresize = resize;
	
	function resize(){
		
		win_w = $( window ).width();
		win_h = $( window ).height(); 
		
		
		
	}  
	
	function verifica_scroll(){
		
		page_y = $(window).scrollTop();
		
		
		 
		
	}  
	
	window.onscroll = verifica_scroll; 
	  
	
	
	
	resize();
	
	var rand = Math.random() * 1000; 
	myRequest1.open("GET", "xml/projetos.xml?rand="+rand, true);
	myRequest1.send(null);  
	
}