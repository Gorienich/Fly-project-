var login_button = document.getElementById("loginBtn");
var register_button = document.getElementById("registerBtn");
var login_form = document.getElementById("login");
var register_form = document.getElementById("register");
var form_box = document.getElementById("form-box");
var content = document.getElementById("content");
var password_register = document.getElementById("password_register");
var password_re_register = document.getElementById("password_re_register");
var email_register = document.getElementById("email_register");
var email_login = document.getElementById("email_login");
var firstname_register = document.getElementById("firstname_register");
var lastname_register = document.getElementById("lastname_register");

function login() {
    if (login_button.classList.contains("white-btn")) {
        login_button.className = "btn";
        form_box.style.visibility = "hidden";
        form_box.style.opacity = 0;
        form_box.style.zIndex = 1;
        content.style.visibility = "visible";
        content.style.opacity = 1;
        content.style.zIndex = 10;
    } else {
        content.style.opacity = 0;
        content.style.visibility = "hidden";
        content.style.zIndex = 1;
        form_box.style.zIndex = 10;
        login_form.style.left = "4px";
        register_form.style.right = "-520px";
        login_button.className = "btn white-btn";
        register_button.className = "btn right-btn";
        form_box.style.visibility = "visible";
        form_box.style.opacity = 1;
    }
}

function logout() {
    window.location.href = "logout.php";
}

function register() {
    if (register_button.classList.contains("white-btn")) {
        register_button.className = "btn right-btn";
        form_box.style.opacity = 0;
        form_box.style.visibility = "hidden";
        form_box.style.zIndex = 1;
        content.style.visibility = "visible";
        content.style.opacity = 1;
        content.style.zIndex = 10;
    } else {
        content.style.opacity = 0;
        content.style.visibility = "hidden";
        content.style.zIndex = 1;
        form_box.style.zIndex = 10;
        login_form.style.left = "-510px";
        register_form.style.right = "5px";
        login_button.className = "btn";
        register_button.className = "btn right-btn white-btn";
        form_box.style.visibility = "visible";
        form_box.style.opacity = 1;
    }
}

function validateRegister() {
    var valid = true;
    email_register.classList.remove('red-outline');
    password_register.classList.remove('red-outline');
    password_re_register.classList.remove('red-outline');
    firstname_register.classList.remove('red-outline');
    lastname_register.classList.remove('red-outline');
    if (password_register.value.length == 0 || password_register.value != password_re_register.value) {
        password_register.classList.add('red-outline');
        password_re_register.classList.add('red-outline');
        password_register.setCustomValidity('Passwords must be matching.');
        password_register.reportValidity();
        valid = false;
    }
    if (!(/^\w+([\._-]?\w+)*@\w+([\._-]?\w+)*(\.\w{2,3})+$/.test(email_register.value)) || !(/^[a-zA-Z\@0-9\.-_]+$/.test(email_register.value))) {
        email_register.classList.add('red-outline');
        email_register.setCustomValidity('Invalid email address.');
        email_register.reportValidity();
        valid = false;
    }
    if (!(/^[a-zA-Z]+$/.test(firstname_register.value))) {
        firstname_register.classList.add('red-outline');
        firstname_register.setCustomValidity('Invalid first name.');
        firstname_register.reportValidity();
        valid = false;
    }
    if (!(/^[a-zA-Z]+$/.test(lastname_register.value))) {
        lastname_register.classList.add('red-outline');
        lastname_register.setCustomValidity('Invalid last name.');
        lastname_register.reportValidity();
        valid = false;
    }
    return valid;
}

function validateLogin() {
    var valid = true;
    email_login.classList.remove('red-outline');
    if (!(/^\w+([\._-]?\w+)*@\w+([\._-]?\w+)*(\.\w{2,3})+$/.test(email_login.value)) || !(/^[a-zA-Z\@0-9\.-_]+$/.test(email_login.value))) {
        email_login.classList.add('red-outline');
        email_login.setCustomValidity('Invalid email address.');
        email_login.reportValidity();
        valid = false;
    }
    return valid;
}