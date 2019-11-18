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
  let $word;
  let $inputfield = $('input#inputfield');
  let $racecar = $('#racecar');
  let $paragraph = $('p#sourceText');
  let $chart = $('#chart');

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
  }

  function showResults() {
    $('#user_score').text(`${mySpeed} wpm`);
    $('#symbols').text(symbolsCounter);
    $('#time').text(`${time_end} seconds`);
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

  function defaultSettings() {
    reset();
    startTimer();
    $paragraph.html( getTextArray().join(' ') ); // show text 
    highlightWord();
    $chart.hide();
    $inputfield.removeAttr('disabled');
    $inputfield.focus();
    $racecar.css('padding-left', 0);
  }

  // function moveRaceCar() {
  //   raceInterval = setInterval(
  //     $.ajax({
  //       type: "POST",
  //       url: './server/distance.php',
  //       cache: false, 
  //       data: {distance: symbolsCounter},
  //       success: function(response)
  //       {
  //         let jsonData = JSON.parse(response); 
  //         if (jsonData.success == "1")
  //         {
  //           console.log('2:connected successfully');
  //           $racecar.css('padding-left', distance *  jsonData.distance);
  //         }
  //         else
  //         { 
  //           console.log('2:connection failed');
  //         }
  //       }
  //     }), 2000);
  // }

  return {  
    restart: function() {  
      $.ajax({
        type: "POST",
        url: './server/get_text.php',
        cache: false, 
        data: {text_id: 1},
        success: function(response)
        {
          let jsonData = JSON.parse(response); 
          if (jsonData.success == "1")
          {
            console.log('1:connected successfully');
            text = jsonData.text;
            defaultSettings(); 
            raceInterval = setInterval(()=>{
              $.ajax({
                type: "POST",
                url: './server/distance.php',
                cache: false, 
                data: {distance: symbolsCounter},
                success: function(response)
                {
                  let jsonData = JSON.parse(response); 
                  if (jsonData.success == "1")
                  {
                    console.log('2:connected successfully');
                    $racecar.css('padding-left', distance *  jsonData.distance);
                  }
                  else
                  { 
                    console.log('2:connection failed');
                  }
                }
              })}, 1000);
          }
          else
          { 
            console.log('2:connection failed');
          }
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
          // $racecar.css('padding-left', distance * symbolsCounter);
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