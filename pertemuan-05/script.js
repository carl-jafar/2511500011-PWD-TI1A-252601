document.getElementById("menu-toggle").addEventListener("click", function () {
    document.querySelector("nav").classList.toggle("active");
}); 

document.querySelector("form").addEventListener("submit", function (e) { 
        const nama = document.getElementById("txtNama"); 
        const email = document.getElementById("txtEmail"); 
        const pesan = document.getElementById("txtPesan");

        document.querySelectorAll(".error-msg").forEach(el => el.remove()); 
  [nama, email, pesan].forEach(el => el.style.border = ""); 
 
  let isValid = true; 