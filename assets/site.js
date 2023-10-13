//region .non-touch
// Set touch support .nonTouch css class to html element if browser doesn't support touch
let isTouchDevice = true;
const touchSupport = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0)
if (!touchSupport) { // browser doesn't support touch
    document.documentElement.className += " nonTouch"
    isTouchDevice = false;
}
//endregion

function setScrollingDown(yes) {
    const header = document.querySelector("#header");
    if (yes === true && header.classList.contains("scrollingDown") === false) {
        header.classList.add("scrollingDown");
    } else if (yes === false && header.classList.contains("scrollingDown") === true) {
        header.classList.remove("scrollingDown");
    }
}

/**
 * This function needs to be called whenever the top bar height changes. At initial load, we are calling this a few
 * times to make sure we get the correct marginTop.
 */
function setBodyWrapperMarginTop() {
    const bodyWrapper = document.querySelector("#bodyWrapper");
    bodyWrapper.style.marginTop = (document.querySelector("#header").scrollHeight) + 'px';
    originalBodyWidth = window.innerWidth;
}

/**
 * Inserts the email into elements with css class email
 */
function insertEmailIntoHtmlElements() {
    const emails = document.getElementsByClassName('email')
    const addr = email_local + '@' + email_domain;
    for (let email of emails) {
        email.innerHTML = "<a href='mailto:" + addr + "' class='emailAddress'>" + addr + "</a>";
    }
}

/**
 * On mobile devices with touch capabilities, we want to give user feedback that the element is clicked for 300ms.
 * Unfortunately, :hover and :active works differently on mobile devices and also different between mobile browsers.
 * This below standardises the behaviour easily.
 */
function addClickEventsIfTouchDevice() {
    if (!isTouchDevice) return;
    document.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', event => {
            a.classList.add('active');
            setTimeout(function () {
                a.classList.remove('active');
            }, 300);
        });
    });
}

/**
 * Anchor links are used in Table of Contents of Markdown pages and posts.
 * This helps us to scroll to a given element, smoothly, also taking the header height into consideration.
 */
function setUpAnchorLinksSmoothScrolling() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');

    anchorLinks.forEach(link => {
        link.addEventListener('click', function (event) {
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
}

//region Register events
let lastScrollTop = 0;
let originalBodyWidth = window.innerWidth;

// As we scroll, we want to set the direction which way we are scrolling to up or down, so we know to collapse or
// expand the header.
window.addEventListener('scroll', function () {
    let currentScrollTop = window.scrollY || document.documentElement.scrollTop;
    const header = document.querySelector("#header");

    if (Math.abs(currentScrollTop - lastScrollTop) <= 200) {
        return;
    }

    if (currentScrollTop > lastScrollTop && currentScrollTop > header.scrollHeight) {
        setScrollingDown(true);
    } else {
        setScrollingDown(false);
    }

    lastScrollTop = currentScrollTop;

}, {passive: true});

window.addEventListener('resize', function () {
    if (originalBodyWidth !== document.body.clientWidth) {
        setBodyWrapperMarginTop();
    }
});


window.addEventListener('load', function () {
    setBodyWrapperMarginTop();
    insertEmailIntoHtmlElements();
    addClickEventsIfTouchDevice();
});

window.addEventListener('DOMContentLoaded', function () {
    setBodyWrapperMarginTop();
    setUpAnchorLinksSmoothScrolling();
});

// When less.js finishes loading, call setBodyWrapperMarginTop() to get a correct margin.
// In production this has no effect as less.js is only used in development.
if (typeof less !== 'undefined' && less.pageLoadFinished) {
    less.pageLoadFinished.then(
        function () {
            setBodyWrapperMarginTop();
        }
    );
}
//endregion