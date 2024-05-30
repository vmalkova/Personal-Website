// general functions

function removeError(input) {
    let parent = input.parentElement;
    let errorP = parent.nextElementSibling;
    parent.style.border = '0.1rem solid #073e55';
    if (errorP.nodeName === 'P') {
        errorP.remove();
    }
}

function setErrorFor(input, message) {
    let parent = input.parentElement;
    let errorText = document.createTextNode(message);
    let errorBox = document.createElement('p');
    errorBox.id = 'error';
    errorBox.appendChild(errorText);
    parent.after(errorBox);
    parent.style.border = '0.1rem solid rgb(142, 26, 50)';
}

function validEmail(email) {
    let emailValue = email.value;
    let atPosition = emailValue.indexOf('@');
    let dotPosition = emailValue.lastIndexOf('.');
    return atPosition > 0 && dotPosition > atPosition+1 && dotPosition < emailValue.length-1;
}

function validPassword(password) {
    let passwordValue = password.value;
    return passwordValue.length >= 8;
}


// log in form validation

let email = document.getElementById('email');
let password = document.getElementById('password');

function logIn(e)
{
    removeError(email);
    removeError(password);
    if (email.value === '')
    {
        setErrorFor(email, 'Email cannot be blank');
    }
    else if (!validEmail(email))
    {
        setErrorFor(email, 'Email is not valid');
    }
    if (password.value === '')
    {
        setErrorFor(password, 'Password cannot be blank');
    }
    else if (!validPassword(password))
    {
        setErrorFor(password, 'Wrong password');
    }
    if (!validEmail(email) || !validPassword(password))
    {
        e.preventDefault();
    }
    return;
}

document.getElementById('loginButton').addEventListener('click', logIn);


// sign up form validation

let newnName = document.getElementById('newName');
let newEmail = document.getElementById('newEmail');
let newPassword = document.getElementById('newPassword');
let confirmPassword = document.getElementById('confirmPassword');

function signUp(e)
{
    removeError(newName);
    removeError(newEmail);
    removeError(newPassword);
    removeError(confirmPassword);
    if (newName.value === '')
    {
        setErrorFor(newName, 'Name cannot be blank');
    }
    if (newEmail.value === '')
    {
        setErrorFor(newEmail, 'Email cannot be blank');
    }
    else if (!validEmail(newEmail))
    {
        setErrorFor(newEmail, 'Email is not valid');
    }
    if (newPassword.value === '')
    {
        setErrorFor(newPassword, 'Password cannot be blank');
    }
    else if (!validPassword(newPassword))
    {
        setErrorFor(newPassword, 'Password must be at least 8 characters long');
    }
    if (confirmPassword.value === '')
    {
        setErrorFor(confirmPassword, 'Please confirm your password');
    }
    else if (newPassword.value !== confirmPassword.value)
    {
        setErrorFor(confirmPassword, 'Passwords do not match');
    }
    if (!validEmail(newEmail) || !validPassword(newPassword) || newPassword.value !== confirmPassword.value || newName.value === '')
    {
        e.preventDefault();
    }
    return;
}

document.getElementById('signupButton').addEventListener('click', signUp);