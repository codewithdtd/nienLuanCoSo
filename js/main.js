const navbar__menu = document.querySelector('.navbar__menu');

navbar__menu.onclick = () => {
    let nav_item = document.querySelector(".navbar__items");
    nav_item.classList.toggle("navbar__items--active"); 
}




