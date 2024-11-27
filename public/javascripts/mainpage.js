const settings = document.getElementById('settings');
const EventsToggleClickSettings = document.getElementById('EventsToggleClickSettings');

function Settings() {

    settings.style.display = "block";

    setTimeout(() => {
        settings.style.opacity = "1";
    }, 100);

}

EventsToggleClickSettings.addEventListener("click", () => {

    settings.style.opacity = "0";

    setTimeout(() => {
        settings.style.display = "none";
    }, 100);

})

function validateUsername() {

    const username = document.getElementById('new_username').value;
    const errorMessage = document.getElementById('error-message');
    const valid = username.length > 1 && !username.includes(' ');

    if (!valid) {
        errorMessage.style.display = 'block';
    } else {
        errorMessage.style.display = 'none';
    }

    return valid;

}

