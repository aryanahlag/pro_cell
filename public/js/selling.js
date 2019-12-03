$('*').off('keyup  keydown');
window.addEventListener('keypress', function (e) {
    key = e.keyCode;
    if (key == 113) {
        let find = $("#findCode");
        find.focus();

        setTimeout(() => {

        }, 3000)
    }
})
