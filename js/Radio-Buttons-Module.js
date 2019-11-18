let radioButtonsModule = (function($) {

  let language = 'English';

  $langs = $('input:radio[name=langs]');
  $languageButton = $('#languageMenuBtn');

  return {
  	defineLang: function() {  
  		if (!$langs.prop('ckecked')) {
  			WpmText.setLanguageId(1);
  		}

  		$langs.change(function() { 
  			WpmText.setLanguageId($(this).data('langId'));
  			WpmText.restart();
  			$languageButton.text(this.value);
	    });
  	}
  };

})(jQuery);