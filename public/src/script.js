// =====================
// HAMBURGER MENU
// =====================
const hamburger = document.getElementById("hamburger");
const navLinks = document.getElementById("navLinks");

hamburger.addEventListener("click", () => {
  navLinks.classList.toggle("active");
});

// =====================
// THEME TOGGLE (Dark/Light)
const themeToggle = document.getElementById("themeToggle");

// Page load par theme restore
if(localStorage.getItem("theme") === "dark"){
    document.body.classList.remove("light");
    document.body.classList.add("dark");
    themeToggle.innerHTML = "🌙";
}else{
    document.body.classList.remove("dark");
    document.body.classList.add("light");
    themeToggle.innerHTML = "☀️";
}

// Toggle Theme
themeToggle.addEventListener("click", () => {

    if(document.body.classList.contains("light")){

        document.body.classList.remove("light");
        document.body.classList.add("dark");

        localStorage.setItem("theme","dark");
        themeToggle.innerHTML = "🌙";

    }else{

        document.body.classList.remove("dark");
        document.body.classList.add("light");

        localStorage.setItem("theme","light");
        themeToggle.innerHTML = "☀️";
    }

});

// =====================
// SMOOTH SCROLL
// =====================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener("click", function(e) {
    e.preventDefault();

    document.querySelector(this.getAttribute("href")).scrollIntoView({
      behavior: "smooth"
    });
  });
});



// for fqa

document.querySelectorAll(".faq-item").forEach(item => {
  item.addEventListener("click", () => {
    item.classList.toggle("active");
  });
});



// review
const slider = document.querySelector(".review-container");
const next = document.querySelector(".next");
const prev = document.querySelector(".prev");

next.addEventListener("click", () => {
  slider.scrollBy({
    left: 380,
    behavior: "smooth"
  });
});

prev.addEventListener("click", () => {
  slider.scrollBy({
    left: -380,
    behavior: "smooth"
  });
});

setInterval(() => {
  slider.scrollBy({
    left: 380,
    behavior: "smooth"
  });

  if (
    slider.scrollLeft + slider.clientWidth >=
    slider.scrollWidth - 10
  ) {
    slider.scrollTo({
      left: 0,
      behavior: "smooth"
    });
  }
}, 4000);


// resume previwe
const previewBtn = document.getElementById("previewBtn");
const modal = document.getElementById("resumeModal");
const closeBtn = document.querySelector(".close");

// OPEN MODAL
previewBtn.addEventListener("click", (e) => {
  e.preventDefault();
  modal.style.display = "flex";
});

// CLOSE MODAL
closeBtn.addEventListener("click", () => {
  modal.style.display = "none";
});

// OUTSIDE CLICK CLOSE
window.addEventListener("click", (e) => {
  if (e.target === modal) {
    modal.style.display = "none";
  }
});
