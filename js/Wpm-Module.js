const WpmText = (function($) { 

  let text;
  let wordId;
  let word;
  let wordsCount;
  let symbolsCount;

  function setText() {
    text = getText().split(" ").map((word, id) => {
      return `<span data-word-id="${id}">${word}</span>`;
    });
  }

  function setUnderlinedWord() {
    word.attr('class', 'underlined');
  }

  function setWord() {
    word = $(`span[data-word-id="${++wordId}"]`);
  }

  function setWordId() {
    wordId = -1;
  }

  function setFocusOnInput() {
    $('input#userText').focus();
  }

  function getText() {
    let text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
    if (!text.length) {
      return '';
    } 
    return text;
  }

  function printText() {
    $('p#sourceText').html( text.join(' ') );
  }

  function clearInput() {
    $('input#userText').val('');
  } 

  function prevWordCorrect() {
    word.removeAttr('class');
  }

  String.prototype.rtrim = function() {
    let trimmed = this.replace(/\s+$/g, '');
    return trimmed;
  };

  return {
    restart: function() {   
      setText();
      printText();
      setWordId();
      setWord();
      setUnderlinedWord();
      setFocusOnInput();
    },

    validateText: function(value) { 
      if (value.length - 1 !== word.text().length) return;
      
      if (value.rtrim() !== word.text()) return;

      clearInput();
      prevWordCorrect();
      setWord();
      setUnderlinedWord();
    }
  };

})(jQuery);