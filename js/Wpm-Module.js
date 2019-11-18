const WpmText = (function($) { 

  let text;
  let words;
  let wordPointer;
  let noofseconds;
  let timeInterval;
  let symbolsCounter;
  let max;
  let distance;
  let mySpeed;
  let time_end;
  let isLoading = false;
  let raceInterval;
  let userLevel;

  let $word;
  let $inputfield = $('input#inputfield');
  let $racecar = $('#racecar');
  let $paragraph = $('p#sourceText');
  let $chart = $('#chart'); 

  const SKILL_LEVEL = {
    0: 'Beginner',
    25: 'Intermediate',
    31: 'Average',
    42: 'Pro',
    55: 'Typemaster',
    80: 'Megaracer'
  };

  function reset() {
    wordPointer = -1;
    symbolsCounter = 0; 
    noofseconds = 0;
    max = 0;
    words = text.split(' ');
    distance = 570 / words.join('').length; 
  } 

  function calculate() {
    mySpeed =  Math.round(((symbolsCounter / 5 / noofseconds) * 60) * 100) / 100;
    time_end = Math.round(noofseconds * 10) / 10;

    userLevel = 'Beginner';

    for (let score in SKILL_LEVEL) {
      if (mySpeed >= score) {  
        userLevel = SKILL_LEVEL[score];
      }
    } 
  }

  function showResults() {
    $('#user_score').text(`${mySpeed} wpm`);
    $('#symbols').text(symbolsCounter);
    $('#time').text(`${time_end} seconds`);
    $('#skill').text(userLevel);
  } 

  function getTextArray() {
    return text.split(" ").map((word, id) => {
      return `<span data-word-id="${id}">${word}</span>`;
    });  
  }
  
  function highlightWord() {
    $word = $(`span[data-word-id="${++wordPointer}"]`);
    $word.addClass('underlined');
  } 

  function startTimer() {
    timeInterval = setInterval(() => { 
      noofseconds += 0.1; 
    }, 100); 
  }  

  return {  
    restart: function() {  
      $.ajax({
        type: "POST",
        url: './server/para.php',
        cache: false, 
        success: function(response) {
          let jsonData = JSON.parse(response);
          text = jsonData.para;
          reset();
          startTimer();
          $paragraph.html( getTextArray().join(' ') ); // show text 
          highlightWord();
          $chart.hide();
          $inputfield.removeAttr('disabled');
          $inputfield.focus();
          $racecar.css('padding-left', 0);
        }
     });
    },

    endGame: function () {
      clearInterval(timeInterval); 
      clearInterval(raceInterval);
      $inputfield.val('');
      $inputfield.attr('disabled', '');
      $chart.show();
      $word.attr('class', 'correct');
      calculate();
      showResults(); 
    },

    updateView: function() {
      $inputfield.val('');
      $word.attr('class', 'correct'); // previus word is correct
      highlightWord(); 
    },

    validateText: function(inputValue) {  
      let wordSubstring = words[wordPointer].substr(0, inputValue.length);
      let isEqual = inputValue.trimEnd() === words[wordPointer];
      let isSpaceKeyPressed = inputValue.length - 1 === words[wordPointer].length;
      let isLastWord = wordPointer === words.length - 1;

      if (isSpaceKeyPressed && isEqual) {
        this.updateView();
        max = 0;
        return;
      }

      if (inputValue === wordSubstring) {
        if (max < inputValue.length) {
          max = inputValue.length;
          symbolsCounter++;
          $racecar.css('padding-left', distance * symbolsCounter);
        } 
        $word.attr('class', 'underlined');
      } else {
        $word.attr('class', 'invalid-char');
      }

      if (isLastWord && isEqual) {
        this.endGame();
      } 
    }
  };
})(jQuery);