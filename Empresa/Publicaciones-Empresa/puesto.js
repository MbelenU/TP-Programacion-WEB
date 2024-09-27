function setStatus(button) {
    const buttons = button.parentElement.querySelectorAll('button');
    buttons.forEach(btn => {
        btn.classList.remove('active');
    });
    button.classList.add('active');
}