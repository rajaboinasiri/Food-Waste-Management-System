document.addEventListener("DOMContentLoaded", () => {
    const donateButtonContainer = document.getElementById("donate-food-btn-container");

    if (localStorage.getItem("registered") === "true") {
        donateButtonContainer.classList.remove("hidden");
    }
});

function donateFood() {
    alert("Thank you for donating food!");
}
