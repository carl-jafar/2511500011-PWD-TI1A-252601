document.getElementById("menu-toggle").addEventListener("click", function () {
    document.querySelector("nav").classList.toggle("active");
}); 

document.querySelector("form").addEventListener("submit", function (e) { 
        const nama = document.getElementById("txtNama"); 
        const email = document.getElementById("txtEmail"); 
        const pesan = document.getElementById("txtPesan");