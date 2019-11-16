const WpmText = (function($) { 

  let text;
  let textArray;
  let wordId;
  let word;
  let noofseconds;
  let timeInterval;
  let symbols;
  let max;
  let distance;
  let mySpeed;
  let time_end;

  function reset() {
    wordId = -1;
    symbols = 0; 
    max = 0;
    text = 'They suspect him of human being.';
    distance = 570 / text.split(' ').join('').length;
    textArray = getTextArray();
  }

  function calculate() {
    mySpeed =  Math.round(((symbols / 5 / noofseconds) * 60) * 100) / 100;
    time_end = Math.round(noofseconds * 10) / 10;
  }

  function showResults() {
    $('#user_score').text(`${mySpeed} wpm`);
    $('#symbols').text(symbols);
    $('#time').text(`${time_end} seconds`);
  }

  function getTextArray() {
    return text.split(" ").map((word, id) => {
      return `<span data-word-id="${id}">${word}</span>`;
    });  
  }
  
  function setWord() {
    word = $(`span[data-word-id="${++wordId}"]`);
    word.attr('class', 'underlined')
  }

  function showText() {
    $('p#sourceText').html( textArray.join(' ') );
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
    noofseconds = 0;
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
      startTimer();
      reset();
      showText(); 
      setWord();
    },

    endGame: function () {
      clearInterval(timeInterval);
      disablePrinting();
      clearInput();
      prevWordCorrect();
      calculate();
      showResults();
    },

    updateView: function() {
      clearInput();
      prevWordCorrect();
      setWord();
      max = 0;
    },

    validateText: function(value) { 
      let word_substring = word.text().substr(0, value.length);
      let isEqual = value.rtrim() === word.text();
      let isSpaceKeyPressed = value.length - 1 === word.text().length;
      let isLastWord = (wordId+1) === textArray.length;

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
        word.attr('class', 'underlined');
      } else {
        invalidChar();
      }

      if (isLastWord && isEqual) {
        this.endGame();
      } 
    }
  };
})(jQuery);