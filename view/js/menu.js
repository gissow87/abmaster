function asignAnimations() {
    let listElement = document.querySelectorAll('.list__button--click')

    listElement.forEach(element => {
        element.addEventListener('click', () => {
            element.classList.toggle('arrow');

            let hight = 0;
            let menu = element.nextElementSibling;
            if(menu.clientHeight == 0)
            hight = menu.scrollHeight;
            menu.style.height = hight + "px";
        });
    });
}