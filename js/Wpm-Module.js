const WpmText = (function($) { 

  let text;
  let wordId;
  let word;
  let noofseconds;
  let timeInterval;
  let symbols;
  let realTimeScore;
  let max;
  let started_at;
  let ended_at;
  let distance;

  // setters

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

  function setEndTime() {
    ended_at = new Date().getSeconds();
  }

  function setDistance() {
    distance = 590 / getText().split(' ').join('').length; 
  }

  // getters

  function getText() {
    let text = 'They suspect him of human being. if you want it to have one decimal place, even when that would be a 0, then add...';
    if (!text.length) {
      return '';
    } 
    return text;
  }

  function getMySpeed() {
    return Math.round(((symbols / 5 / noofseconds) * 60) * 100) / 100;
  }

  function printText() {
    $('p#sourceText').html( text.join(' ') );
  }

  function printTextLength() {
    $('#text-length').html(getText().length + ' symbols');
  }

  function printCurrentScore() {
    realTimeScore = setInterval(() => {
      $('#wpm').html( getMySpeed() + ' wpm' );
    }, 1000);
  }

  function printTime() {
    $('#time').text((Math.round(noofseconds * 10) / 10) + ' seconds');
  }

  function printSymbols() {
    $('#symbols').text(symbols);
  }

  function printWPM() {
    $('#user_score').text( getMySpeed() + ' wpm' );
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

  function startTimer() {
    started_at = new Date().getSeconds();
    symbols = 0; 
    noofseconds = 0;
    max = 0;

    timeInterval = setInterval(() => { 
      noofseconds += 0.1; 
    }, 100); 
  } 

  String.prototype.rtrim = function() {
    let trimmed = this.replace(/\s+$/g, '');
    return trimmed;
  };

  return {
    restart: function() {  
      setText();
      printText(); 
      printTextLength();
      setWordId();
      setWord();
      setUnderlinedWord();
      setFocusOnInput();
      startTimer();
      printCurrentScore();
      setDistance();
    },

    endGame: function () {
      disablePrinting();
      clearInput();
      prevWordCorrect();
      clearInterval(timeInterval);
      clearInterval(realTimeScore);
      printWPM();
      printSymbols();
      setEndTime();
      printTime();
    },

    updateView: function() {
      clearInput();
      prevWordCorrect();
      setWord();
      setUnderlinedWord();
      max = 0;
    },

    validateText: function(value) { 
      let word_substring = word.text().substr(0, value.length);
      let isEqual = value.rtrim() === word.text();
      let isSpaceKeyPressed = value.length - 1 === word.text().length;
      let isLastWord = (wordId+1) === text.length;

      if (isSpaceKeyPressed && isEqual) {
        this.updateView();
        return;
      }

      if (value === word_substring) {
        if (max < value.length) {
          max = value.length;
          symbols++;
          $('#racecar').css('padding-left', distance * symbols);
        } 
        setUnderlinedWord();
      } else {
        invalidChar();
      }

      if (isLastWord && isEqual) {
        this.endGame();
      } 
    }
  };
})(jQuery);