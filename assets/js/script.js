function togglePassword() {
    var inputPass = document.getElementById("passwordInput");

    if (inputPass) {
        if (inputPass.type === "password") {
            inputPass.type = "text";
        } else {
            inputPass.type = "password";
        }
    }
}