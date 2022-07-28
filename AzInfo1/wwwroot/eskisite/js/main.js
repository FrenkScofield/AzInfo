$(function(){

  /*

  1- Manuel slideshow add
  2- Slideshow text animation
  3- Search Open/Close
  4- Nav Hide

  */

  /* ========== 1 ========== */

  var slideshow = UIkit.slideshow($('#info-slider'), {

    autoplay : false,
    animation : 'scroll',
    duration : 500,
    autoplayInterval : 8000,
    height: 504

  });

  /* ========== 2 ========== */

  $('#info-slider .uk-slideshow li:nth-of-type(2)').find('.info-slider-text').css({display:'none'});

  $(document).on('show.uk.slideshow','#info-slider',function(e,a){

    a.prev().find('.info-slider-text').css({display:'none'});

    a.next().find('.info-slider-text').css({display:'none'});

    a.find('.info-slider-text').css({display:'block'});

  });

  /* ========== 3 ========== */

  $('.info-header-search i.akim-search').click(function(){

    $(this).fadeOut(300);

    $('.info-header-search i.akim-close').fadeIn(300);

    $('.info-header-search-form').slideDown(300);

    $('.info-search-fade').fadeIn(300);

  });

  $('.info-header-search i.akim-close').click(function(){

    $(this).fadeOut(300);

    $('.info-header-search i.akim-search').fadeIn(300);

    $('.info-header-search-form').slideUp(300);

    $('.info-search-fade').fadeOut(300);

  });

  /* ========== 4 ========== */

   ;(function($) {

     // Browser supports HTML5 multiple file?
     var multipleSupport = typeof $('<input/>')[0].multiple !== 'undefined',
         isIE = /msie/i.test( navigator.userAgent );

     $.fn.customFile = function() {

       return this.each(function() {

         var $file = $(this).addClass('custom-file-upload-hidden'), // the original file input
             $wrap = $('<div class="file-upload-wrapper">'),
             $input = $('<input type="text" class="file-upload-input" disabled placeholder="Dosya Se�iniz" />'),
             // Button that will be used in non-IE browsers
             $button = $('<button type="button" class="file-upload-button">DOSYA Y�KLE</button>'),
             // Hack for IE
             $label = $('<label class="file-upload-button" for="'+ $file[0].id +'">DOSYA Y�KLE</label>');

         // Hide by shifting to the left so we
         // can still trigger events
         $file.css({
           position: 'absolute',
           left: '-9999px'
         });

         $wrap.insertAfter( $file )
           .append( $file, $input, ( isIE ? $label : $button ) );

         // Prevent focus
         $file.attr('tabIndex', -1);
         $button.attr('tabIndex', -1);

         $button.click(function () {
           $file.focus().click(); // Open dialog
         });

         $file.change(function() {

           var files = [], fileArr, filename;

           // If multiple is supported then extract
           // all filenames from the file array
           if ( multipleSupport ) {
             fileArr = $file[0].files;
             for ( var i = 0, len = fileArr.length; i < len; i++ ) {
               files.push( fileArr[i].name );
             }
             filename = files.join(', ');

           // If not supported then just take the value
           // and remove the path to just show the filename
           } else {
             filename = $file.val().split('\\').pop();
           }

           $input.val( filename ) // Set the value
             .attr('title', filename) // Show filename in title tootlip
             .focus(); // Regain focus

         });

         $input.on({
           blur: function() { $file.trigger('blur'); },
           keydown: function( e ) {
             if ( e.which === 13 ) { // Enter
               if ( !isIE ) { $file.trigger('click'); }
             } else if ( e.which === 8 || e.which === 46 ) { // Backspace & Del
               // On some browsers the value is read-only
               // with this trick we remove the old input and add
               // a clean clone with all the original events attached
               $file.replaceWith( $file = $file.clone( true ) );
               $file.trigger('change');
               $input.val('');
             } else if ( e.which === 9 ){ // TAB
               return;
             } else { // All other keys
               return false;
             }
           }
         });

       });

     };

     // Old browser fallback
     if ( !multipleSupport ) {
       $( document ).on('change', 'input.customfile', function() {

         var $this = $(this),
             // Create a unique ID so we
             // can attach the label to the input
             uniqId = 'customfile_'+ (new Date()).getTime(),
             $wrap = $this.parent(),

             // Filter empty input
             $inputs = $wrap.siblings().find('.file-upload-input')
               .filter(function(){ return !this.value }),

             $file = $('<input type="file" id="'+ uniqId +'" name="'+ $this.attr('name') +'"/>');

         // 1ms timeout so it runs after all other events
         // that modify the value have triggered
         setTimeout(function() {
           // Add a new input
           if ( $this.val() ) {
             // Check for empty fields to prevent
             // creating new inputs when changing files
             if ( !$inputs.length ) {
               $wrap.after( $file );
               $file.customFile();
             }
           // Remove and reorganize inputs
           } else {
             $inputs.parent().remove();
             // Move the input so it's always last on the list
             $wrap.appendTo( $wrap.parent() );
             $wrap.find('input').focus();
           }
         }, 1);

       });
     }

   }(jQuery));

   $('input[type=file]').customFile();
   
   /* ========== 4 ========== */
   
   var li = $('.info-products-detail-item .uk-slider li').length;

   var nav = $('.info-products-detail-item .uk-slidenav');

   if (li < 2) {

       nav.hide();

   }

});
