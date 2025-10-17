const asideleft = document.querySelector('.left');
const navigation_side = asideleft.querySelector('.navigation-side');
const asideRight = document.querySelector('.right');
const wp_image = asideleft.querySelector('.wrapper-image');
const menu_chidrens = Array.from(document.querySelector('.wrapper-navigation').children[1]?.children ?? []);
const button_close = document.querySelector('.wrapper-action').children[0];
const button_open = document.querySelector('.wrapper-action').children[1];

function getSetupData() {
    try {
        return setupNeededData;
    } catch (e) {
    }
    return {
        pathname: '',
        locations: {},
    };
}

function getAnimationSideBar() {
    try {
        return animationSideBar;
    } catch (error) {

    }
    return {
        open: 'open-siderbar',
        close : 'close-sidebar'
    }
}

function getAdditionalHandler(isOpen = true) {
    try {
        return additionalHandler(isOpen, asideRight);
    } catch (error) {
    }
}

function handleMultipleMenu() {
    menu_chidrens.forEach(menu => {
        if (menu.classList.contains('multiple')) {
            menu.addEventListener('click', (e) => {
                if (asideleft.children[0].dataset.open.includes('false')) {
                    openSideBar({ target: button_open })
                };
                handleSubMenu(menu);
            });
        }
    });
}

function handleSubMenu(menuElement, isInitialize = false) {
    if (isInitialize) return;
    const open = menuElement.dataset.open.includes('true');
    Array.from(menuElement.children)
        .filter((s, index) => s.classList.contains('sub-menu'))
        .forEach(sub => {
            sub.style.display = open ? 'none' : 'flex';
            sub.style.justifyContent = 'start';
            sub.children[0].style.display = open ? 'none' : 'flex';
        });
    menuElement.dataset.open = !open;
}

function openSideBar({ target }) {
    menu_chidrens.forEach(element => {
        element.children[0].children[1].style.display = 'block';
        element.children[0].style.justifyContent = 'start';
    });

    const { open, close } = getAnimationSideBar();

    getAdditionalHandler();

    asideleft.classList.remove(close);
    asideleft.classList.add(open);
    navigation_side.style.width = '100%';
    

    button_close.style.display = 'block';
    button_open.style.display = 'none';

    // display the logo
    wp_image.children[0].style.display = 'block';
    wp_image.children[1].style.display = 'none';
    asideleft.children[0].dataset.open = true;
    
}

function closeSideBar() {
    menu_chidrens.forEach(element => {
        element.children[0].children[1].style.display = 'none';
        element.children[0].style.justifyContent = 'center';
        if (element.classList.contains('multiple')) {
            element.dataset.open = true;
            handleSubMenu(element);
        }
    });

    const { open, close } = getAnimationSideBar();

    getAdditionalHandler(false);
    asideleft.classList.remove(open);
    asideleft.classList.add(close);
    navigation_side.style.width = 'inherit';

    button_close.style.display = 'none';
    button_open.style.display = 'block';

    // display the logo
    wp_image.children[0].style.display = 'none';
    wp_image.children[1].style.display = 'block';
    asideleft.children[0].dataset.open = false;
}

// handle active and non active main-menu
function handleActiveAndNonActiveMainMenu() {
    let { locations, pathname: currentPath } = getSetupData();
    const pathname = (location.pathname).split(`/${currentPath}/`)[1];
    menu_chidrens.forEach(menu => {
        const name = menu.id.split('-')[1];
        const isMultiple = menu.classList.contains('multiple');
        const display_name = menu.children[0];
        if (isMultiple && name == pathname) {
            console.log('ismultipler')
            const isCurrentLocation = locations[name].includes(pathname);
            if (isCurrentLocation) {
                display_name.classList.add('active');
                Array.from(menu.children)
                    .find(sub => sub.id == pathname)
                    ?.classList.add('active');
                handleSubMenu(menu, true);
            }
        } else if (name == pathname) {
            console.log('active')
            display_name.classList.add('active');
        }
    });
}


button_open.addEventListener('click', openSideBar);

button_close.addEventListener('click', closeSideBar);
handleActiveAndNonActiveMainMenu();
handleMultipleMenu();