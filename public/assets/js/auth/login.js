const password = document.querySelector("#password");
const passwordIcon = document.querySelector(".password-icon");
const eye = document.querySelector("i.fas.fa-eye");

passwordIcon.addEventListener("click", () => {
    let fieldPasswordType = password.getAttribute("type");
    let changeField = fieldPasswordType == "password" ? "text" : "password";

    password.setAttribute("type", changeField);
    changeField == "text" ?
        eye.classList.add("text-info") :
        eye.classList.remove("text-info");
});