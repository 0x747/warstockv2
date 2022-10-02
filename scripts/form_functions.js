let nameErrorMessage = document.getElementById("nameError");
let emailErrorMessage = document.getElementById("emailError");
let passwordErrorMessage = document.getElementById("passwordError");
let ToCErrorMessage = document.getElementById("ToCError");
let dateErrorMessage = document.getElementById("dateError");

let red = "rgb(180, 0, 0)";
let borderGrey = "rgb(169, 169, 169)";

let emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
let passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

let daysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
let day = document.getElementById("day");
let month = document.getElementById("month");
let year = document.getElementById("year");

function validateForm() { 

    let isValid = true;

    //First Name
    try { 
        if(document.getElementById("fname").value == "") {
            isValid = false;
            document.getElementById("fname").style.borderColor = red;
            nameErrorMessage.style.backgroundColor = red;
            nameErrorMessage.innerHTML = "Please enter your full name.";
        } else {
            document.getElementById("fname").style.borderColor = borderGrey; 
            nameErrorMessage.style.backgroundColor = "transparent"; 
            nameErrorMessage.innerHTML = ""; 
        }
    } catch(TypeError) { /* if error occurs do nothing and pass */ }

    // Last Name
    try {
        if(document.getElementById("lname").value == "") {
            isValid = false;
            document.getElementById("lname").style.borderColor = red;
            nameErrorMessage.style.backgroundColor = red;
            nameErrorMessage.innerHTML = "Please enter your full name.";
        } else if(document.getElementById("fname").value && document.getElementById("lname").value) { // Check if both name fields are set before closing error message. A simple else will close the message even if first name is missing.
            document.getElementById("lname").style.borderColor = borderGrey;
            nameErrorMessage.style.backgroundColor = "transparent"; 
            nameErrorMessage.innerHTML = ""; 
        }
    } catch(TypeError) {}    
    

    // Email
    try {
        if(emailRegex.test(document.getElementById("email").value) == false) {
            isValid = false;
            document.getElementById("email").style.borderColor = red;
            emailErrorMessage.style.backgroundColor = red;
            emailErrorMessage.innerHTML = "Email address is invalid.";
        } else {
            document.getElementById("email").style.borderColor = borderGrey;
            emailErrorMessage.style.backgroundColor = "transparent";
            emailErrorMessage.innerHTML = ""; 
        }
    } catch(TypeError) {}  
    
    // Password 
    try {
        if(passwordRegex.test(document.getElementById("password").value) == false) {
            isValid = false;
            document.getElementById("password").style.borderColor = red;
            passwordErrorMessage.style.backgroundColor = red;
            passwordErrorMessage.innerHTML = "Password must be between 8-30 characters, including one uppercase,<br> one lowercase and one special character.";
        } 
        else {
            document.getElementById("password").style.borderColor = borderGrey;
            passwordErrorMessage.style.backgroundColor = "transparent";
            passwordErrorMessage.innerHTML = "";
        }
    } catch(TypeError) {}


    // Date 
    try {
        if(day.value == "day" || month.value == "month" || year.value == "year") {
            isValid = false;
            console.log("be");
            showDateError();
            console.log("aft");
        } 
        else if(month.value != 2 && day.value > daysInMonth[month.value - 1]) {
            isValid = false;
            showDateError();
        }
        else if(month.value == 2 && (!isLeapYear(year.value) && day.value > 28)) {
            isValid = false;
            showDateError();
        }
        else {
            dateErrorMessage.style.backgroundColor = "transparent";
            dateErrorMessage.style.marginTop = "0px";
            dateErrorMessage.innerHTML = "";
        }
    } catch(TypeError) {}

    // Checkbox
    try {
        if(document.getElementById("checkbox").checked == false) {
            isValid = false;
            ToCErrorMessage.style.backgroundColor = red;
            ToCErrorMessage.style.marginTop = "5px";
            ToCErrorMessage.innerHTML = "You must accept the Terms & Conditions to continue.";
        } else {
            ToCErrorMessage.style.backgroundColor = "transparent";
            ToCErrorMessage.style.marginTop = "0px";
            ToCErrorMessage.innerHTML = ""; 
        }
    } catch(TypeError) {}  

    if(!isValid) {
        return false;
    }

    return true;
}

function showDateError() {
    dateErrorMessage.style.backgroundColor = red;
    dateErrorMessage.style.marginTop = "7px";
    dateErrorMessage.innerHTML = "Please select valid date.";
}

function isLeapYear(year) {
    if(year % 400 == 0 || year % 100 != 0 && year % 4 == 0) {
        return true;
    }

    return false;
}