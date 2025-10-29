 document.getElementById("menu-toggle").addEventListener("click", function () {
      document.querySelector("nav").classList.toggle("active");
  }); 

          const nama = document.getElementById("txtNama"); 
          const email = document.getElementById("txtEmail"); 
          const pesan = document.getElementById("txtPesan");

          nama.value = localStorage.getItem("nama") || "";
          email.value = localStorage.getItem("email") || "";
          pesan.value = localStorage.getItem("pesan") || "";

  document.querySelector("form").addEventListener("submit", function (e) { 

        let isValid = true; 

    if (nama.value.trim().length < 3) { 
      showError(nama, "Nama minimal 3 huruf dan tidak boleh kosong."); 
      isValid = false; 
    } else if (!/^[A-Za-z\s]+$/.test(nama.value)) { 
      showError(nama, "Nama hanya boleh berisi huruf dan spasi."); 
      isValid = false; 
    } 