
// Merr referencën e formularit
const form = document.getElementById("form");

// Shto një event listener për "submit"
form.addEventListener("submit", function (event) {
  // Parandalon dërgimin automatik të formës
  event.preventDefault();

  // Merr vlerat e input-eve
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value;

  // Regex për email (standarde)
  const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

  // Regex për fjalëkalimin (min 8 karaktere, 1 numër, 1 simbol)
  const passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

  // Validimi i email-it
  if (!emailPattern.test(email)) {
    alert("Ju lutem vendosni një adresë email-i të vlefshme! (p.sh., example@example.com)");
    return;
  }

  // Validimi i fjalëkalimit
  if (!passwordPattern.test(password)) {
    alert("Fjalëkalimi duhet të ketë të paktën 8 karaktere, një numër dhe një simbol!");
    return;
  }

  // Nëse të gjitha janë të sakta
  alert("Forma u plotësua me sukses!");
  form.submit();
});
