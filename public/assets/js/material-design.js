/*
* Name:        Oscar
* Written by: 	Unifato - (http://unifato.com)
* Version:     1.0.0
*/

(function($) {
  'use strict';

  var el = $('input:not([type=checkbox]):not([type=radio]), textarea');
  if( !el.length ) return;
  el.each(function() {
    var $this = $(this),
        self = this;

    var hasValueFunction = function() {
      if( self.value.length > 0 ) {
        self.parentNode.classList.add('input-has-value');
        $(self).closest('.form-group').addClass('input-has-value');
      }
      else {
        self.parentNode.classList.remove('input-has-value');
        $(self).closest('.form-group').removeClass('input-has-value');
      }
    };

    hasValueFunction(this);
    $this.on('input', hasValueFunction);

    $this.focusin(function() {
      this.parentNode.classList.add('input-focused');
      $this.closest('.form-group').addClass('input-focused');
    });
    $this.focusout(function() {
      this.parentNode.classList.remove('input-focused');
      $this.closest('.form-group').removeClass('input-focused');
    });

    $this.find('.remove-focus').on('click',function() {
      $this.emit('focusout');
    });
  });

})(jQuery);
