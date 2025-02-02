
// Merr referencat për elementet
const form = document.getElementById("form");
const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const confirmPassword = document.getElementById("confirm");

// Regex për email (format korrekt: example@domain.com)
const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
// Regex for password: minimum 8 characters, at least one letter and one number, letters and numbers only
const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;


// Event listener për submit
form.addEventListener("submit", function (event) {
  event.preventDefault(); // Parandalon dërgimin automatik

  // Validimi i username
  if (username.value.length < 5 || username.value.length > 25) {
    alert("Username duhet të jetë ndërmjet 5 dhe 25 karaktereve!");
    return;
  }

  // Validimi i email-it (regex)
  if (!emailPattern.test(email.value.trim())) {
    alert("Ju lutem vendosni një adresë email-i të vlefshme! (p.sh., example@example.com)");
    return;
  }

  // Validimi i password (duhet të ketë të paktën 8 karaktere dhe të përmbajë shkronja dhe numra)
if (!passwordPattern.test(password.value)) {
  alert("Password duhet të ketë të paktën 8 karaktere, një shkronjë dhe një numër (vetëm shkronja dhe numra lejohet)!");
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
