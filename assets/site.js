//region .non-touch
// Set touch support .nonTouch css class to html element if browser doesn't support touch
let isTouchDevice = true;
const touchsupport = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0)
if (!touchsupport){ // browser doesn't support touch
    document.documentElement.className += " nonTouch"
    isTouchDevice = false;
}
//endregion

let lastScrollTop = 0;
let timer;
const delay = 200;
let originalBodyWidth = window.innerWidth;

window.addEventListener('scroll', function() {
    let currentScrollTop = window.scrollY || document.documentElement.scrollTop;
    const header = document.querySelector("#header");

    if (Math.abs(currentScrollTop - lastScrollTop) <= 200) {
        return;
    }

    if (currentScrollTop > lastScrollTop && currentScrollTop > header.scrollHeight) {
        setScrollingDown(true);
    }
    else {
        setScrollingDown(false);
    }

    lastScrollTop = currentScrollTop;

}, {passive: true});

function setScrollingDown(yes) {
    const header = document.querySelector("#header");
    if (yes === true && header.classList.contains("scrollingDown") === false) {
        header.classList.add("scrollingDown");
    }
    else if (yes === false && header.classList.contains("scrollingDown") === true) {
        header.classList.remove("scrollingDown");
    }
}

function setBodyWrapperMarginTop() {
    const bodyWrapper = document.querySelector("#bodyWrapper");
    bodyWrapper.style.marginTop = (document.querySelector("#header").scrollHeight) + 'px';
    originalBodyWidth = window.innerWidth;
}

// on window resize
window.addEventListener('resize', function () {
    if (originalBodyWidth !== document.body.clientWidth) {
        setBodyWrapperMarginTop();
    }
});


window.addEventListener('load', function () {
    setBodyWrapperMarginTop();

    //region Insert site email address into all .email elements
    const emails = document.getElementsByClassName('email')
    const addr = email_local + '@' + email_domain;
    for (let email of emails) {
        email.innerHTML = "<a href='mailto:"+addr+"' class='emailAddress'>"+addr+"</a>";
    }
    //endregion

    if (isTouchDevice) {
        document.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', event => {
                a.classList.add('active');
                setTimeout(function () {
                    a.classList.remove('active');
                }, 300);
            });
        });
    }
});

window.addEventListener('DOMContentLoaded', function() {
    setBodyWrapperMarginTop();

    // Find all anchor links on the page
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');

    anchorLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Stop the default anchor behavior

            const targetId = this.getAttribute('href'); // e.g., "#heading"
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                const rect = targetElement.getBoundingClientRect();
                const absoluteTop = window.pageYOffset + rect.top - document.querySelector("#header").scrollHeight;

                window.scrollTo({
                    top: absoluteTop,
                    behavior: "smooth" // Smooth scrolling
                });
            }
        });
    });
});
