document.addEventListener('DOMContentLoaded', function () {
    const headerMemberIcon = document.getElementById('header-member-icon');
    const sessionUsername = document.getElementById('session-username');
    const sessionRole = document.getElementById('session-role');

    const firstLetter = sessionUsername.innerHTML.charAt(0);
    headerMemberIcon.innerHTML = firstLetter;

    if (sessionRole.innerHTML === '1') {
        headerMemberIcon.style.backgroundColor = '#ff991f';
    } else {
        headerMemberIcon.style.backgroundColor = '#4bce97';
    }
});