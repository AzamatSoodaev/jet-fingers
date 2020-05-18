$(document).ready(function() {
    let ctrlDown = false,
        ctrlKey = 17,
        cmdKey = 91,
        vKey = 86,
        cKey = 67;

    $(document).keydown(function(e) {
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = true;
    }).keyup(function(e) {
        if (e.keyCode == ctrlKey || e.keyCode == cmdKey) ctrlDown = false;
    });

    // $("#inputfield").keydown(function(e) {
    //     if (ctrlDown && (e.keyCode == vKey || e.keyCode == cKey)) return false;
    // });
    
    // Document Ctrl + C/V 
    $(document).keydown(function(e) {
        if (ctrlDown && (e.keyCode == cKey)) { 
            e.preventDefault();
        }
        if (ctrlDown && (e.keyCode == vKey)) {
            e.preventDefault();
        }
    });
});