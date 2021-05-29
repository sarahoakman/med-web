// Checks if given inputs satisfy making a new researcher

function verify() {
    var username = document.getElementById("username_n").style.display;
    var password = document.getElementById("password_n").style.display;
    var firstname = document.getElementById("firstname_n").style.display;
    var lastname = document.getElementById("lastname_n").style.display;
    var dob = document.getElementById("dob_n").style.display;
    var gender = document.getElementById("gender_n").style.display;
    var contact = document.getElementById("contact_n").style.display;
    if (username == "block" || password == "block" || firstname == "block" || lastname == "block" || dob == "block" || gender == "block" || contact == "block") {
        alert("Invalid form, researcher not added");
        return false;
    }
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var firstname = document.getElementById("firstname").value;
    var lastname = document.getElementById("lastname").value;
    var dob = document.getElementById("dob").value;
    var gender = document.getElementById("gender").value;
    var contact = document.getElementById("contact").value;
    var errors = [];
    if (username == "") {
        errors.push("Enter a Username");
    }
    if (password == "") {
        errors.push("Enter a Password");
    }
    if (firstname == "") {
        errors.push("Enter a First Name");
    }
    if (lastname == "") {
        errors.push("Enter a Last Name");
    } 
    if (dob == "") {
        errors.push("Enter a DOB");
    } 
    if (gender == "") {
        errors.push("Select a gender");
    }
    if (errors.length != 0) {
        alert(errors.toString());
        return false;
    }
    return true;
}

function hideVerification() {
    document.getElementById("username").value = "";
    document.getElementById("password").value = "";
    document.getElementById("firstname").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("dob").value = "";
    document.getElementById("gender").value = "";
    document.getElementById("contact").value = "";
    document.getElementById("username_n").style.display = "none";
    document.getElementById("username_y").style.display = "none";
    document.getElementById("password_n").style.display = "none";
    document.getElementById("password_y").style.display = "none";
    document.getElementById("firstname_n").style.display = "none";
    document.getElementById("firstname_y").style.display = "none";
    document.getElementById("lastname_n").style.display = "none";
    document.getElementById("lastname_y").style.display = "none";
    document.getElementById("dob_n").style.display = "none";
    document.getElementById("dob_y").style.display = "none";
    document.getElementById("gender_n").style.display = "none";
    document.getElementById("gender_y").style.display = "none";
    document.getElementById("contact_n").style.display = "none";
    document.getElementById("contact_y").style.display = "none";
}

window.onload = hideVerification;

function verifyUsername() {
    var check = document.getElementById("username").value;
    var msg1 = document.getElementById("username_n");
    var msg2 = document.getElementById("username_y");
    if (check.length < 1 || check.Length > 15) {
        msg1.style.display = "block";
        msg2.style.display = "none";
    } else {
        msg1.style.display = "none";
        msg2.style.display = "block";
    }
}

function verifyPassword() {
    var check = document.getElementById("password").value;
    var msg1 = document.getElementById("password_n");
    var msg2 = document.getElementById("password_y");
    if (check.length < 8 || check.Length > 25) {
        msg1.style.display = "block";
        msg2.style.display = "none";
    } else {
        msg1.style.display = "none";
        msg2.style.display = "block";
    }
}

function verifyFirstname() {
    var check = document.getElementById("firstname").value;
    var msg1 = document.getElementById("firstname_n");
    var msg2 = document.getElementById("firstname_y");
    var re1 = /^[a-zA-Z'-]+$/;
    if (re1.test(check) == false || check.length < 1 || check.length > 20) {
        msg1.style.display = "block";
        msg2.style.display = "none";
    } 
    if (re1.test(check) == true && check.length >= 1 && check.length <= 20) {
        msg1.style.display = "none";
        msg2.style.display = "block";
    }
}

function verifyLastname() {
    var check = document.getElementById("lastname").value;
    var msg1 = document.getElementById("lastname_n");
    var msg2 = document.getElementById("lastname_y");
    var re1 = /^[a-zA-Z'-]+$/;
    if (re1.test(check) == false || check.length < 1 || check.length > 25) {
        msg1.style.display = "block";
        msg2.style.display = "none";
    } else  {
        msg1.style.display = "none";
        msg2.style.display = "block";
    }
}

function verifyDOB() {
    var check = document.getElementById("dob").value;
    var msg1 = document.getElementById("dob_n");
    var msg2 = document.getElementById("dob_y");
    // Checks that it's in the correct format
    var re1 = /^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/;
    // Splits it into day, month, year
    var str = check.split("/");
    // Change into an int to compare, making sure it's not centuries ago
    var year = parseInt(str[2]);
    // Rearrange date so that the month appears first for the Date format
    var tempDate = str[1] + "/" + str[0] + "/" + str[2];
    // Get a date object
    var date = Date.parse(tempDate);
    // Get the current date and split into year, month, date
    var currDate = new Date();
    var currYear = currDate.getFullYear();
    var currMonth = currDate.getMonth();
    var currDay = currDate.getDate();
    // make a date 18 years ago to make sure registration is by valid people
    var validDate = new Date(currYear - 18, currMonth, currDay);
    // toggle the error messages and tick icon for invalid and valid dates
    if (re1.test(check) == true && isNaN(date) == false && year >= 1899 
        && validDate >= date) {
        msg1.style.display = "none";
        msg2.style.display = "block";
    } else  {
        msg1.style.display = "block";
        msg2.style.display = "none";
    }
}

function verifyGender() {
    var check = document.getElementById("gender").value;
    var msg1 = document.getElementById("gender_n");
    var msg2 = document.getElementById("gender_y");
    if (check == "") {
        msg1.style.display = "block";
        msg2.style.display = "none";
    } else {
        msg1.style.display = "none";
        msg2.style.display = "block";
    }
}

function verifyContact() {
    var check = document.getElementById("contact").value;
    var msg1 = document.getElementById("contact_n");
    var msg2 = document.getElementById("contact_y");
    var re1 = /^[0-9]+$/;
    if (check != "") {
        if (!re1.test(check) ||  !(check.length == 10 || check.length == 8)) {
            msg1.style.display = "block";
            msg2.style.display = "none";
        } else {
            msg1.style.display = "none";
            msg2.style.display = "block";
        }
    } else {
        msg1.style.display = "none";
        msg2.style.display = "block";
    }
}

function openAddForm() {
      document.getElementById("AddForm").style.display = "block";
}

function closeAddForm() {
      document.getElementById("AddForm").style.display = "none";
      hideVerification();
}

function openUpdateForm(username) {
    document.getElementById("UpdateForm").style.display = "block";
    document.getElemenyById("edit-researcher").name = username;
}

function closeUpdateForm() {
    document.getElementById("UpdateForm").style.display = "none";
}