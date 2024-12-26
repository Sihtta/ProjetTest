const menubar = document.querySelector('#menu');
const Navbar = document.querySelector('.navbar');

menubar.onclick = () => {
    menubar.classList.toggle('bx-x');
    Navbar.classList.toggle('active');
};

const section = document.querySelectorAll('section');
const navlink = document.querySelectorAll('header nav a');

window.onscroll = () => {
    section.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 150;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');
        if (top > offset && top < offset + height) {
            sec.classList.add('start-animation');
            navlink.forEach(links => {
                links.classList.remove('active');
                document.querySelector('header nav a[href*=' + id + ']').classList.add('active');
            });
        }
    });

    var header = document.querySelector('.header');
    header.classList.toggle('sticky', window.scrollY > 100);
    menubar.classList.remove('bx-x');
    Navbar.classList.remove('active');

    const cards = document.querySelectorAll('.card');
    const triggerBottom = window.innerHeight * 0.9;

    cards.forEach(card => {
        const cardTop = card.getBoundingClientRect().top;

        if (cardTop < triggerBottom) {
            card.classList.add('show');
        } else {
            card.classList.remove('show');
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => card.classList.add('preload'));
});

document.addEventListener('DOMContentLoaded', () => {
    const skillCards = document.querySelectorAll('.skill-card');

    const revealSkills = () => {
        const triggerBottom = window.innerHeight * 0.9;

        skillCards.forEach(skillCard => {
            const cardTop = skillCard.getBoundingClientRect().top;

            if (cardTop < triggerBottom) {
                skillCard.classList.add('show');
            } else {
                skillCard.classList.remove('show');
            }
        });
    };

    window.addEventListener('scroll', revealSkills);

    revealSkills();
});

document.addEventListener('DOMContentLoaded', () => {
    const contactSection = document.querySelector('.contact');

    const revealContact = () => {
        const triggerBottom = window.innerHeight * 0.9;
        const sectionTop = contactSection.getBoundingClientRect().top;

        if (sectionTop < triggerBottom) {
            contactSection.classList.add('start-animation');
        }
    };

    window.addEventListener('scroll', revealContact);

    revealContact();
});

