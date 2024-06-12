function ShowMenu() 
{

    var MenuButton = document.getElementById('menuButton');
    var Menu = document.getElementById('Slide-Menu');
    var StyleMenu = window.getComputedStyle(Menu);

    if (StyleMenu.width == '0px') {
        Menu.style.width = '60vw';
        Menu.style.padding = '10px';
        Menu.style.zIndex = -1;
        MenuButton.style.color = 'rgb(255, 255, 255)';
        MenuButton.innerText = 'Close';
    }

    if (StyleMenu.width != '0px') {
        Menu.style.width = '0px';
        Menu.style.padding = '0px';
        Menu.style.zIndex = 1;
        MenuButton.style.color = 'rgb(0, 0, 0)';
        MenuButton.innerHTML = 'Menu';
    }

}

function ChangeMenuStyles() {
    
    var MenuButton = document.getElementById('menuButton');
    var Menu = document.getElementById('Slide-Menu');
    var StyleMenu = window.getComputedStyle(Menu);
    
    Menu.style.width = '0px';
    Menu.style.padding = '0px';
    Menu.style.zIndex = 1;
    MenuButton.style.color = 'rgb(0, 0, 0)';
    MenuButton.innerHTML = 'Menu';

    if (innerWidth >= 865) {
        Menu.style.width = '100%';
        Menu.style.transition = 'none';
    } else {
        setTimeout(function () {
            Menu.style.transition = '0.5s all ease-in-out';
        }, 100)
    }
}
