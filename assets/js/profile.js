//Change eye icon for the current password field
const toggleCurPassword = document.querySelector('#toggleCurPassword');
const curpassword = document.querySelector('#curpassword');

let isVisibleCur = false;
toggleCurPassword.addEventListener('click', function(e) {
    if (isVisibleCur == false) {
        isVisibleCur = true;
        document.getElementById("toggleCurPassword").textContent = "visibility";
    } else {
        isVisibleCur = false;
        document.getElementById("toggleCurPassword").textContent = "visibility_off";
    }
    const type = curpassword.getAttribute('type') === 'password' ? 'text' : 'password';
    curpassword.setAttribute('type', type);
});

//Change eye icon for the new password field
const toggleNewPassword = document.querySelector('#toggleNewPassword');
const newpassword = document.querySelector('#newpassword');

let isVisibleNew = false;
toggleNewPassword.addEventListener('click', function(e) {
    if (isVisibleNew == false) {
        isVisibleNew = true;
        document.getElementById("toggleNewPassword").textContent = "visibility";
    } else {
        isVisibleNew = false;
        document.getElementById("toggleNewPassword").textContent = "visibility_off";
    }
    const type = newpassword.getAttribute('type') === 'password' ? 'text' : 'password';
    newpassword.setAttribute('type', type);
});

//Change eye icon for the repeat password field
const toggleRepeatPassword = document.querySelector('#toggleRepeatPassword');
const newpassword2 = document.querySelector('#newpassword2');

let isVisibleRepeat = false;
toggleRepeatPassword.addEventListener('click', function(e) {
    if (isVisibleRepeat == false) {
        isVisibleRepeat = true;
        document.getElementById("toggleRepeatPassword").textContent = "visibility";
    } else {
        isVisibleRepeat = false;
        document.getElementById("toggleRepeatPassword").textContent = "visibility_off";
    }
    const type = newpassword2.getAttribute('type') === 'password' ? 'text' : 'password';
    newpassword2.setAttribute('type', type);
});