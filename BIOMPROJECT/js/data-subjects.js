// Shows and hides related tests according to button presses

function hideTests() {
    document.getElementById("baseline").style.display = "none";
    document.getElementById("headtilt").style.display = "none";
    document.getElementById("suction1").style.display = "none";
    document.getElementById("suction2").style.display = "none";
}
window.onload = hideTests;

function showBaseline() {
    document.getElementById("baseline").style.display = "block";
    document.getElementById("headtilt").style.display = "none";
    document.getElementById("suction1").style.display = "none";
    document.getElementById("suction2").style.display = "none";
}

function showHeadTest() {
    document.getElementById("baseline").style.display = "none";
    document.getElementById("headtilt").style.display = "block";
    document.getElementById("suction1").style.display = "none";
    document.getElementById("suction2").style.display = "none";
}

function showSuction1() {
    document.getElementById("baseline").style.display = "none";
    document.getElementById("headtilt").style.display = "none";
    document.getElementById("suction1").style.display = "block";
    document.getElementById("suction2").style.display = "none";
}

function showSuction2() {
    document.getElementById("baseline").style.display = "none";
    document.getElementById("headtilt").style.display = "none";
    document.getElementById("suction1").style.display = "none";
    document.getElementById("suction2").style.display = "block";
}