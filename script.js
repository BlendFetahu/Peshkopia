// Merr referencën e formularit
const form = document.getElementById("form");

// Shto një event listener për "submit"
form.addEventListener("submit", function (event) {
  // Parandalon dërgimin automatik të formës
  event.preventDefault();

  // Merr vlerat e input-eve
  const email = document.getElementById("name").value.trim();
  const password = document.getElementById("psw").value;

  // Validimi i email-it
  if (!emailPattern.test(email)) {
    alert("Ju lutem vendosni një adresë email-i të vlefshme!");
    return;
  }

  // Validimi i fjalëkalimit
  if (password.length < 8) {
    alert("Fjalëkalimi duhet të ketë të paktën 8 karaktere!");
    return;
  }

  // Nëse të gjitha janë të sakta
  alert("Forma u plotësua me sukses!");
  // Mund ta lejosh formën të dërgohet ose të kryesh ndonjë logjikë tjetër
  form.submit();
});
