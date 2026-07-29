const themeBtn = document.querySelector(".theme-btn");

themeBtn.addEventListener("click", () => {

    document.body.classList.toggle("dark");

    const icon = themeBtn.querySelector("i");

    if(document.body.classList.contains("dark")){

        icon.classList.remove("fa-moon");
        icon.classList.add("fa-sun");

    }else{

        icon.classList.remove("fa-sun");
        icon.classList.add("fa-moon");

    }

});

const menuBtn = document.querySelector(".menu-btn");
const navMenu = document.querySelector(".nav-menu");

menuBtn.addEventListener("click", () => {

    navMenu.classList.toggle("active");

    menuBtn.querySelector("i").classList.toggle("fa-xmark");

});

const scrollBar = document.querySelector(".scroll-bar");
const backTop = document.querySelector(".back-to-top");


window.addEventListener("scroll",()=>{

    let scrollTop = document.documentElement.scrollTop;

    let height =
    document.documentElement.scrollHeight -
    document.documentElement.clientHeight;


    let progress = (scrollTop / height) * 100;


    scrollBar.style.width = progress + "%";


    if(scrollTop > 400){

        backTop.classList.add("show");

    }else{

        backTop.classList.remove("show");

    }

});


backTop.onclick = ()=>{

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

};

window.addEventListener("load",()=>{

    document.querySelector(".loader")
    .classList.add("hide");

});

const cursor = document.querySelector(".cursor");
const dot = document.querySelector(".cursor-dot");


document.addEventListener("mousemove",(e)=>{

    cursor.style.left=e.clientX+"px";

    cursor.style.top=e.clientY+"px";


    dot.style.left=e.clientX+"px";

    dot.style.top=e.clientY+"px";

});