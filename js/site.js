

jQuery(document).ready(function($) {
    
    $('.navigate').on('click',function(e){
      e.preventDefault();
      $target = $($(this).attr('href'));      
      scrollTo($target);
    });
    
    $('.waypoint-nav').waypoint(function(){
      $('#primary-navigation').toggleClass('fixed');
    },{offset:'115px'});
	
    $('.waypoint-nav').waypoint(function(){
      $('#toggle-logo').toggleClass('visuallyhidden');
    },{offset:'115px'});

// mobile
    
    var $links = $('#links');
    
    $('#toggle-menu').on('click',function(e){
      e.preventDefault();

      $(this).toggleClass('x');
      
      $links.toggleClass('show');
      
    });
     
    preload();
    
    $('.rollover').on('mouseenter',function(){
        switchSrc($(this));
    })
    
    $('.rollover').on('mouseleave',function(){
        switchSrc($(this));
    })
  
            
    // helpers
    
    function scrollTo($element){
      $('html, body').animate({scrollTop: $element.offset().top-90}, 500);
    } 
    
    function switchSrc($object){
        
        var original = $object.attr('src');
        var replacement = $object.data('rollover');
        
        $object.attr('src',replacement).data('rollover',original);
        
    }
    
    function preload(){
        
        var images = [];
        
        $('.rollover').each(function(i) {
            images[i] = new Image();
            images[i].src = $(this).data('rollover');
        });
        
    }
    
});

jQuery(document).ready(function($) {
 
	$(".scroll").click(function(event){		
		event.preventDefault();
		$('html,body').animate({scrollTop:$(this.hash).offset().top}, 500);
	});
});

$(document).ready(function() {
  $('.image-link').magnificPopup({type:'image'});
});

$('.popupgal').magnificPopup({ 
	delegate: 'a',
  type: 'image',
gallery: {
	enabled: true
},
});
