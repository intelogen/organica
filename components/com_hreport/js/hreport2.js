activephase = 1;

function togglephase(i) {

    if (!window.ie6) {
            resetHeight('#mainmodules .block div div div');
            resetHeight('#mainmodules2 .block div div div');
    }
    resetHeight('div.main-height');

    $('phase'+activephase).setStyle('display','none');
    $('phase'+i).setStyle('display','');
    activephase = i;

    if (!window.ie6) {
            maxHeight('#mainmodules .block div div div');
            maxHeight('#mainmodules2 .block div div div');
    }
    maxHeight('div.main-height');


}

