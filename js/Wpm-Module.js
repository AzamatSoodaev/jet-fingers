const KEYSTROKES_PER_WORD = 5;

const WpmText = (function($) {
    let 
        text,
        words,
        wordPointer,
        started_at,
        time_end,
        total_time,
        countDownTime,
        keystrokes,
        max,
        distance,
        mySpeed,
        substraction,
        offsetTop,
        $word;

    const 
        $inputfield = $('input#inputfield'),
        $racecar = $('#racecar'),
        $paragraph = $('p#sourceText'),
        $chart = $('#chart'),
        $countDownTimer = $("#count-down");

    function reset() {
        wordPointer = -1;
        keystrokes = 0;
        max = 0;
        words = text.split(' ');
        distance = 610 / text.length;
        total_time = 60; // in seconds
        substraction = 0;
        offsetTop = 21;
        started_at = 0;
        
        $countDownTimer.text("01:00");
        $chart.hide();
        $inputfield.prop('disabled', false);
        $inputfield.focus();
        $inputfield.val('');
        $racecar.css('padding-left', 0); 
        $('.text-container').scrollTop(0);

        clearInterval(countDownTime);
    }

    function calculate() {
        time_end = (new Date().getTime() - started_at) / 1000; 
        mySpeed = Math.round(((keystrokes / KEYSTROKES_PER_WORD / time_end) * 60) * 100) / 100;
    }

    function showResults() {
        $('#user_score').text(`${mySpeed} wpm`);

        console.log('total chars: ' + text.length);
        console.log('keystrokes: ' + keystrokes);
        console.log('time: ' +  time_end);
    }

    function getTextArray() {
        return text.split(" ").map((word, id) => {
            return `<span id="${id}">${word}</span>`;
        });
    }

    function highlightWord() {
        $word = $(`#${++wordPointer}`);
        $word.addClass('underlined');
    }

    function endGame() {
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

            if ($word[0].offsetTop !== offsetTop) {
                $('.text-container').scrollTop($word[0].offsetTop - 21);
                offsetTop = $word[0].offsetTop;
            }

            return;
        }

        if (inputValue === wordSubstring) {
            if (max < inputValue.length) {
                max = inputValue.length;
                keystrokes++;
            }

            $word.attr('class', 'underlined');
            $inputfield.css('background-color', '#ffffff');
            $racecar.css('padding-left', distance * (keystrokes - substraction));
        } else {
            $word.attr('class', 'invalid-char');
            $inputfield.css('background-color', '#fbc7db');
        }

        if (isLastWord && isEqual) {
            endGame();
        }
    }

    function startTimers() {
        console.log('timer started');

        started_at = new Date().getTime();

        countDown();
        countDownTime = setInterval(countDown, 1000);
    }

    function countDown() {
        let minutes = parseInt(total_time / 60);
        let seconds = total_time % 60;

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $countDownTimer.text(minutes + ":" + seconds);

        if (--total_time < 0) {
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