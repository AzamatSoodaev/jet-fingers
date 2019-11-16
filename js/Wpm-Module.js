const WpmText = (function($) { 

  let text;
  let wordId;
  let word;
  let wordsAmount;
  let textLength;

  function setText() {
    text = getText().split(" ").map((word, id) => {
      return `<span data-word-id="${id}">${word}</span>`;
    });
  } 

  function setWordsAmount() {
    wordsAmount = $('#sourceText span').length;
    console.log(wordsAmount);
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

  function printTextLength() {
    $('#text-length').html(getText().length + ' symbols');
  }

  function disablePrinting() {
    $('#userText').attr('disabled', '');
  }

  function clearInput() {
    $('input#userText').val('');
  } 

  function prevWordCorrect() {
    word.removeAttr('class');
  }

  function invalidChar() {
    word.attr('class', 'invalid-char');
  }

  String.prototype.rtrim = function() {
    let trimmed = this.replace(/\s+$/g, '');
    return trimmed;
  };

  return {
    restart: function() {   
      setText();
      printText();
      setWordsAmount();
      printTextLength();
      setWordId();
      setWord();
      setUnderlinedWord();
      setFocusOnInput();
    },

    validateText: function(value) { 
      let word_substring = word.text().substr(0, value.length);
      let isEqual = value.rtrim() === word.text();
      let isSpaceKeyPressed = value.length - 1 === word.text().length;
      let isLastWord = (wordId+1) === wordsAmount;

      if (isSpaceKeyPressed && isEqual) {
        clearInput();
        prevWordCorrect();
        setWord();
        setUnderlinedWord();
      }
      else if (isLastWord && isEqual) {
        disablePrinting();
        clearInput();
        prevWordCorrect();
      }
      else if (value === word_substring) {
        setUnderlinedWord();
      } 
      else {
        invalidChar(); 
      }
    }
  };

})(jQuery);