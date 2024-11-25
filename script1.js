// Merr referencat për elementet
const form = document.getElementById("form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm");

// Event listener për submit
form.addEventListener("submit", function (event) {
  event.preventDefault(); // Parandalon dërgimin automatik

/*--Pjesa e Validimit Email (Spo me funksionon???)*/



  // Validimi i username
  if (username.value.length < 5 || username.value.length > 25) {
    alert("Username duhet të jetë ndërmjet 5 dhe 25 karaktereve!");
    return;
  }

  if (!emailPattern.test(email.value)) {
    alert("Ju lutem vendosni një adresë email-i të vlefshme!");
    return;
  }

  // Validimi i password
  if (password.value.length < 8) {
    alert("Password duhet të jetë të paktën 8 karaktere!");
    return;
  }

  // Kontrollo nëse password dhe confirm përputhen
  if (password.value !== confirmPassword.value) {
    alert("Password dhe Confirm nuk përputhen!");
    return;
  }

  // Nëse çdo gjë është valide
  alert("Llogaria u krijua me sukses!");
  form.submit(); // Dërgo formularin
});
