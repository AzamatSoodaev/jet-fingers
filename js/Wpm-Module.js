const WpmText = (function($) {
    let 
        text,
        words,
        wordPointer,
        noofseconds,
        timeInterval,
        keystrokes,
        max,
        distance,
        mySpeed,
        time_end,
        countDownTime,
        duration,
        substraction,
        $word;

    const 
        $inputfield = $('input#inputfield');
        $racecar = $('#racecar'),
        $paragraph = $('p#sourceText'),
        $chart = $('#chart'),
        $countDownTimer = $("#count-down");

    function reset() {
        wordPointer = -1;
        keystrokes = 0;
        noofseconds = 0;
        max = 0;
        words = text.split(' ');
        distance = 610 / text.length;
        $countDownTimer.text("01:00");
        duration = 60; // in seconds
        substraction = 0;
        
        $chart.hide();
        $inputfield.prop('disabled', false);
        $inputfield.focus();
        $inputfield.val('');
        $racecar.css('padding-left', 0); 

        clearInterval(countDownTime);
        clearInterval(timeInterval);
    }

    function calculate() {
        mySpeed = Math.round(((keystrokes / 5 / noofseconds) * 60) * 100) / 100;
        time_end = Math.round(noofseconds * 10) / 10;
    }

    function showResults() {
        $('#user_score').text(`${mySpeed} wpm`);

        console.log('total chars: ' + text.length);
        console.log('keystrokes: ' + keystrokes);
        console.log('time: ' + time_end + ' seconds');
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

    function endGame() {
        clearInterval(timeInterval);
        clearInterval(countDownTime);

        $inputfield.unbind();
        $inputfield.val('');
        $inputfield.prop('disabled', true);
        $chart.show();
        $paragraph.hide();

        calculate();
        showResults();
    }

    function validateText() {
        if (this.value === ' ') {
            this.value = '';
            return;
        }

        let inputValue = this.value;
        let wordSubstring = words[wordPointer].substr(0, inputValue.length);
        let isEqual = inputValue.trimEnd() === words[wordPointer];
        let isSpaceKeyPressed = inputValue.length - 1 === words[wordPointer].length;
        let isLastWord = wordPointer === words.length - 1;

        if (isSpaceKeyPressed && isEqual) {
            $inputfield.val('');
            $word.attr('class', 'correct');
            highlightWord();
            max = 0;

            // Spaces need 1 keystroke
            keystrokes++;
            substraction++;

            // Uppercase letters need 2 keystrokes
            if (inputValue[0] === inputValue[0].toUpperCase()) {
                keystrokes++;
                substraction++;
            }

            return;
        }

        if (inputValue === wordSubstring) {
            if (max < inputValue.length) {
                max = inputValue.length;
                keystrokes++;
            }

            $word.attr('class', 'underlined');
            $racecar.css('padding-left', distance * (keystrokes - substraction));
        } else {
            $word.attr('class', 'invalid-char');
        }

        if (isLastWord && isEqual) {
            endGame();
        }
    }

    function startTimers() {
        console.log('timers');

        countNoofseconds();
        timeInterval = setInterval(countNoofseconds, 100);

        countDown();
        countDownTime = setInterval(countDown, 1000);
    }

    function countNoofseconds() {
        noofseconds += 0.1;
    }

    function countDown() {
        let minutes = parseInt(duration / 60);
        let seconds = duration % 60;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $countDownTimer.text(minutes + ":" + seconds);

        if (--duration < 0) {
            endGame();
        }
    }

    function render(response) {
        text = JSON.parse(response).para;
        
        reset();
        
        $paragraph.html(getTextArray().join(' '));
        $paragraph.show();
        
        highlightWord();
        
        $inputfield.unbind();
        $inputfield.one('keydown', startTimers);
        $inputfield.on('input', validateText);
    }

    return {
        start: function() {
            this.post();

            $('#reload-btn').on('click', () => this.post());
        },

        post: function() {
            $.ajax({
                type: "POST",
                url: './server/para.php', 
                success: function(response) {
                    render(response);
                }
            });
        },
    };
})(jQuery);