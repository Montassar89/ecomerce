$(function(){

'use strict';

	//palceholder show page login
	$('[placeholder]').focus(function (){

	$(this).attr('data-text',$(this).attr('placeholder'));
	$(this).attr('placeholder','');

	}).blur(function(){

		$(this).attr('placeholder',$(this).attr('data-text'));
	});

	// insert span * requierd page add 

	$('input').each(function (){

      if($(this).attr('required') === 'required'){

      	$(this).after('<span class="sterisk">*</span>');
      }

	});

	// show password
    $('.show-pass').hover(function (){

    	$('.password').attr('type','text');


    },function () {
         
         $('.password').attr('type','password');

    });

    //confirm delete

    $('.confirme').click(function (){

       return confirm('	Are You Sure?');
    });


    //full view animation page gategory

    $('.cat h3').click(function (){

    $(this).next('.full-view').fadeToggle(800);

    });


    $('.option span').click(function (){

     $(this).addClass('active').siblings('span').removeClass('active');

     if($(this).data('view') == 'full'){

      $('.cat .full-view').fadeIn(600);

     }else{

        $('.cat .full-view').fadeOut(600);
     }

    });

    //trigger select box page item

    $("select").selectBoxIt({

      autoWidth :false
    });

    //button + page dashboards

    $('.toggle-info').click(function (){


      $(this).toggleClass('selected').parent().next('.panel').fadeToggle(100);

      if($(this).hasClass('selected')){

        $(this).html('<i class="fa fa-minus fa-lg"></i>');

      }else{

        $(this).html('<i class="fa fa-plus fa-lg"></i>');

      }


    });

});