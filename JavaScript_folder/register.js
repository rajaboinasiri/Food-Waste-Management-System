let otpSent = false;
let otpValue = "";
let otpVerified = false;


function sendOtp() {
    const email = document.getElementById("email").value;
    if (!email) {
        alert("Please enter your email.");
        return;
    }
    fetch("send_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email: email }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                otpSent = true;
                document.getElementById("otp-row").style.display = "table-row";
                document.getElementById("verify-otp-row").style.display = "table-row";
                alert("OTP sent successfully to your email.");
            } else {
                alert(data.message || "Failed to send OTP. Try again.");
            }
        })
        .catch(() => alert("An error occurred. Please try again."));
}


function verifyOtp() {
    const enteredOtp = document.getElementById("otp").value;
    if (!otpSent) {
        alert("Please send the OTP first.");
        return;
    }
    fetch("validate_otp.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ otp: enteredOtp }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                otpVerified = true;
                alert("OTP verified. Enter password to complete registration.");
                document.getElementById("password-row").style.display = "table-row";
                document.getElementById("verify-otp-row").style.display = "none";
                document.getElementById("register-btn").disabled = false;
            } else {
                alert(data.message || "Invalid OTP. Please try again.");
            }
        })
        .catch(() => alert("Error during OTP verification."));
}


document.getElementById("register-form").addEventListener("submit", function (event) {
    event.preventDefault(); 

    if (!otpVerified) {
        alert("Please verify your OTP before submitting.");
        return;
    }

    const formData = new FormData(document.getElementById("register-form"));

    fetch("register.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            const registerBtn = document.getElementById("register-btn");
            const successMessageDiv = document.getElementById("success-message");
            
            if (data.success) {
                
                successMessageDiv.innerHTML = data.message || "Successfully registered!";
                successMessageDiv.style.color = "green";

                
                setTimeout(() => {
                    window.location.href = 'signin.html'; 
                }, 2000); 
                
                
                document.getElementById("register-form").reset();
                document.getElementById("otp-row").style.display = "none";
                document.getElementById("password-row").style.display = "none";
                document.getElementById("verify-otp-row").style.display = "none";
                registerBtn.disabled = true;
                
                otpVerified = false;
                otpSent = false; 
            } else {
                // Display error message if registration failed
                successMessageDiv.innerHTML = data.message || "Registration failed. Please try again.";
                successMessageDiv.style.color = "red";
            }
        })
        .catch(() => alert("An error occurred during registration."));
});
