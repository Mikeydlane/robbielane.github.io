// JavaScript Document
jQuery(document).ready(function($) {
      
	$(document).on('keyup',function(evt) {
    if (evt.keyCode == 27) {
       window.location.replace('/phlog/admin');
    }	
	}); 
});
