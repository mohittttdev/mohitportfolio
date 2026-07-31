

document.addEventListener('DOMContentLoaded', () => {

  /* SCROLL PROGRESS BAR */
  const scrollBar = document.getElementById('scrollBar');
  function updateScrollProgress() {
    const scrollTop = window.scrollY;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    if (scrollBar) scrollBar.style.width = progress + '%';
  }

  /*   HEADER SCROLLED STATE */
  const header = document.getElementById('header');
  function updateHeaderState() {
    if (window.scrollY > 40) header.classList.add('scrolled');
    else header.classList.remove('scrolled');
  }

  /*  BACK TO TOP BUTTON */
  const backToTop = document.getElementById('backToTop');
  function updateBackToTop() {
    if (window.scrollY > 500) backToTop.classList.add('show');
    else backToTop.classList.remove('show');
  }
  if (backToTop) {
    backToTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* Combined scroll handler  */
  window.addEventListener('scroll', () => {
    updateScrollProgress();
    updateHeaderState();
    updateBackToTop();
    updateActiveNavLink();
  }, { passive: true });

  // Run once on load
  updateScrollProgress();
  updateHeaderState();
  updateBackToTop();

  /*  THEME TOGGLE (DARK / LIGHT)  */
  const themeBtn = document.getElementById('themeBtn');
  const htmlEl = document.documentElement;
  const themeIcon = themeBtn ? themeBtn.querySelector('i') : null;

  function applyTheme(theme) {
    htmlEl.setAttribute('data-theme', theme);
    localStorage.setItem('portfolio-theme', theme);
    if (themeIcon) {
      themeIcon.classList.remove('fa-moon', 'fa-sun');
      themeIcon.classList.add(theme === 'dark' ? 'fa-moon' : 'fa-sun');
    }
  }

  // Load saved theme (falls back to whatever is already set in HTML, default: dark)
  const savedTheme = localStorage.getItem('portfolio-theme');
  if (savedTheme) applyTheme(savedTheme);

  if (themeBtn) {
    themeBtn.addEventListener('click', () => {
      const current = htmlEl.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
      const next = current === 'dark' ? 'light' : 'dark';
      themeBtn.classList.add('spin');
      applyTheme(next);
      setTimeout(() => themeBtn.classList.remove('spin'), 500);
    });
  }

  /*   MOBILE MENU TOGGLE */
  const menuBtn = document.getElementById('menuBtn');
  const navMenu = document.getElementById('navMenu');
  const menuIcon = menuBtn ? menuBtn.querySelector('i') : null;

  function closeMenu() {
    navMenu.classList.remove('open');
    if (menuIcon) { menuIcon.classList.remove('fa-xmark'); menuIcon.classList.add('fa-bars'); }
  }

  if (menuBtn && navMenu) {
    menuBtn.addEventListener('click', () => {
      const isOpen = navMenu.classList.toggle('open');
      if (menuIcon) {
        menuIcon.classList.toggle('fa-bars', !isOpen);
        menuIcon.classList.toggle('fa-xmark', isOpen);
      }
    });

    // Close menu when a nav link is clicked
    navMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', closeMenu);
    });
  }

  /*  ACTIVE NAV LINK ON SCROLL  */
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-menu a');

  function updateActiveNavLink() {
    let currentId = '';
    sections.forEach(section => {
      const rect = section.getBoundingClientRect();
      if (rect.top <= 120 && rect.bottom >= 120) {
        currentId = section.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      const href = link.getAttribute('href').replace('#', '');
      link.classList.toggle('active', href === currentId);
    });
  }

  /*  SCROLL REVEAL (IntersectionObserver)  */
  const revealEls = document.querySelectorAll('[data-reveal]');
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('in-view');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  revealEls.forEach(el => revealObserver.observe(el));

  /* COUNTER ANIMATION (hero stats + achievements)  */
  function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-count'), 10) || 0;
    const isPercent = el.textContent.trim().includes('%');
    const suffix = el.textContent.trim().replace(/[0-9]/g, '') || '';
    const duration = 1500;
    const startTime = performance.now();

    function tick(now) {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
      const value = Math.floor(eased * target);
      el.textContent = value + suffix;
      if (progress < 1) requestAnimationFrame(tick);
      else el.textContent = target + suffix;
    }
    requestAnimationFrame(tick);
  }

  const counterEls = document.querySelectorAll('[data-count]');
  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        counterObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.5 });

  counterEls.forEach(el => counterObserver.observe(el));

  /*  SKILL PROGRESS BARS  */
  const progressBars = document.querySelectorAll('.progress-bar[data-width]');
  const progressObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const bar = entry.target;
        const width = bar.getAttribute('data-width');
        bar.style.setProperty('--target-width', width);
        bar.classList.add('animated');
        progressObserver.unobserve(bar);
      }
    });
  }, { threshold: 0.4 });

  progressBars.forEach(bar => progressObserver.observe(bar));

  /*   PROJECT FILTER  */
  const filterButtons = document.querySelectorAll('.project-filter button');
  const projectCards = document.querySelectorAll('.project-card');

  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      filterButtons.forEach(b => b.classList.remove('active'));
      btn.classList.add('active');

      const filter = btn.getAttribute('data-filter');

      projectCards.forEach(card => {
        const categories = (card.getAttribute('data-category') || '').split(' ');
        const shouldShow = filter === 'all' || categories.includes(filter);
        card.classList.toggle('hidden-item', !shouldShow);
      });
    });
  });

  /*  FAQ ACCORDION */
  const faqQuestions = document.querySelectorAll('.faq-question');

  faqQuestions.forEach(question => {
    question.addEventListener('click', () => {
      const isOpen = question.getAttribute('aria-expanded') === 'true';

      // Close all others (accordion behavior)
      faqQuestions.forEach(q => q.setAttribute('aria-expanded', 'false'));

      // Toggle current
      question.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
    });
  });

  /*  CONTACT FORM */
  const contactForm = document.getElementById('contactForm');
  const formStatus = document.getElementById('formStatus');

  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const action = contactForm.getAttribute('action');
      const submitBtn = contactForm.querySelector('.contact-btn');
      const originalBtnHTML = submitBtn.innerHTML;

      // If no real endpoint configured yet, just show a friendly message
      if (!action || action === '#') {
        formStatus.textContent = 'Please connect a form endpoint (e.g. Formspree) to enable sending.';
        formStatus.style.color = '#e0a13c';
        return;
      }

      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
      formStatus.textContent = '';

      try {
        const formData = new FormData(contactForm);
        const response = await fetch(action, {
          method: 'POST',
          body: formData,
          headers: { 'Accept': 'application/json' }
        });

        if (response.ok) {
          formStatus.textContent = 'Message sent successfully! I\'ll get back to you soon.';
          formStatus.style.color = '';
          contactForm.reset();
        } else {
          formStatus.textContent = 'Something went wrong. Please try again or email me directly.';
          formStatus.style.color = '#e05c5c';
        }
      } catch (err) {
        formStatus.textContent = 'Network error. Please try again or email me directly.';
        formStatus.style.color = '#e05c5c';
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnHTML;
      }
    });
  }

const newsletterForm = document.getElementById('newsletterForm');

newsletterForm.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(newsletterForm);

    fetch('backend/subscribe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {

        const input = newsletterForm.querySelector('input[name="email"]');

        if (data.trim() === "success") {
            input.value = "";
            input.placeholder = "Subscribed! Thank you 🎉";
        } else if (data.trim() === "exists") {
            input.value = "";
            input.placeholder = "Already Subscribed!";
        } else {
            alert(data);
        }

    });
});

  /* SMOOTH SCROLL FOR "SCROLL DOWN" INDICATOR  */
  const scrollDown = document.querySelector('.scroll-down');
  if (scrollDown) {
    scrollDown.style.cursor = 'pointer';
    scrollDown.addEventListener('click', () => {
      const trusted = document.querySelector('.trusted');
      if (trusted) trusted.scrollIntoView({ behavior: 'smooth' });
    });
  }

});