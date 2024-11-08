window.addEventListener('scroll', function() {
    var navbar = document.getElementById('navbar');
    if (window.scrollY > 0) {
        navbar.classList.add('navbar-shadow');
    } else {
        navbar.classList.remove('navbar-shadow');
    }
});

document.addEventListener('DOMContentLoaded', function() {

    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    if (hamburger && sidebar) {
        hamburger.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    const links = document.querySelectorAll('.nav-links a');

    for (const link of links) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
           
            if (href.startsWith("#")) {
                e.preventDefault();
                const targetId = href.substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    }

    const modeToggle = document.getElementById('mode-toggle');
    const sunIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-brightness-high" viewBox="0 0 16 16"> <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/></svg>';
    const moonIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars" viewBox="0 0 16 16"> <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/> <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/></svg>';

    if (modeToggle) {
        modeToggle.innerHTML = sunIcon;

        modeToggle.addEventListener('click', function() {
            document.body.classList.toggle('light-mode');
            if (document.body.classList.contains('light-mode')) {
                modeToggle.innerHTML = moonIcon;
            } else {
                modeToggle.innerHTML = sunIcon;
            }
        });
    }
});


// Validasi password
function validasiPassword(password) {
    if (!/[a-z]/.test(password)) {
        alert("Password harus mengandung setidaknya satu huruf kecil.");
        return false;
    }

    if (!/[A-Z]/.test(password)) {
        alert("Password harus mengandung setidaknya satu huruf besar.");
        return false;
    }

    if (!/[@$!%*?&]/.test(password)) {
        alert("Password harus mengandung setidaknya satu karakter spesial (@, $, !, %, *, ?, &).");
        return false;
    }

    return true;
}

//validasi regis login
function validasiForm() {
    let username = document.getElementById('username').value;
    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (username === "") {
        alert("Username Harus Terisi");
        return false;
    }

    if (username.length > 20) {
        alert("Username tidak boleh lebih dari 12 karakter");
        return false;
    }

    if (name === "") {
        alert("Nama Harus Terisi");
        return false;
    }

    if (email === "") {
        alert("Email Harus Terisi");
        return false;
    }

    if (password === "") {
        alert("Password Harus Terisi");
        return false;
    }

    if (password.length < 8) {
        alert("Password tidak boleh kurang dari 8 karakter");
        return false;
    }

    if (password.indexOf(' ') >= 0) {
        alert("Password tidak boleh mengandung spasi");
        return false;
    }

    if (!validasiPassword(password)) {
        return false;
    }

    return true;
}
