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
  let userLevel;
  let countDownTime;
  let duration = 60;

  let $word;
  let $inputfield = $('input#inputfield');
  let $racecar = $('#racecar');
  let $paragraph = $('p#sourceText');
  let $chart = $('#chart'); 
  let $countDownTimer = $("#count-down");

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
    distance = 540 / words.join('').length; 
    userLevel = 'Beginner';
    $countDownTimer.text("01:00");
  } 

  function calculate() {
    mySpeed =  Math.round(((symbolsCounter / 5 / noofseconds) * 60) * 100) / 100;
    time_end = Math.round(noofseconds * 10) / 10;

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
    console.log('timer started');

    timeInterval = setInterval(() => { 
      noofseconds += 0.1; 
    }, 100); 
  }  

  function updateView() {
    $inputfield.val('');
    $word.attr('class', 'correct');
    highlightWord(); 
  }

  function endGame() {
    clearInterval(timeInterval); 
    clearInterval(countDownTime);
    $inputfield.unbind();
    $inputfield.val('');
    $inputfield.prop('disabled', true);
    $chart.show();
    $word.attr('class', 'correct');
    calculate();
    showResults(); 
  }

  function validateText() {  
    let inputValue = this.value;
    let wordSubstring = words[wordPointer].substr(0, inputValue.length);
    let isEqual = inputValue.trimEnd() === words[wordPointer];
    let isSpaceKeyPressed = inputValue.length - 1 === words[wordPointer].length;
    let isLastWord = wordPointer === words.length - 1;

    if (isSpaceKeyPressed && isEqual) {
      updateView();
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
      endGame();
    } 
  }

  function activate() {
    $inputfield.on('keydown', () => {
      console.log('game started');
      startTimer();
      countDownBegin();
      countDown();
      $inputfield.unbind('keydown');
    });
  }

  function countDownBegin() {
    let minutes = parseInt(duration / 60, 10);
    let seconds = parseInt(duration % 60, 10);

    minutes = minutes < 10 ? "0" + minutes : minutes;
    seconds = seconds < 10 ? "0" + seconds : seconds;

    $countDownTimer.text(minutes + ":" + seconds);

    if (--duration < 0) { 
      endGame();
    }  
  }

  function countDown() { 
    countDownTime = setInterval(countDownBegin, 1000);
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
          activate();
          $paragraph.html( getTextArray().join(' ') ); // show text 
          highlightWord();
          $chart.hide();
          $inputfield.prop('disabled', false);
          $inputfield.focus();
          $racecar.css('padding-left', 0);
          $inputfield.on('input', validateText);
        }
     });
    }, 
  };
})(jQuery);