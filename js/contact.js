$(document).ready(function () {
  const sendMail = (contact) => {
    // save the **mailsender** folder on public_html file
    // change the localURL to prod URL like http://domain.com/mailsender/public/email/send
    axios
      .post("http://localhost:80/mailsender/public/email/send1", contact)
      .then((response) => { 
        document.getElementById("btnSubmit").disabled = false;
        $('input[type="submit"]').prop('disabled', false);
        document.getElementById("contactForm1").reset();
        window.alert(`Su mensaje ha sido enviado con éxito`);
      })
      .catch((error) => console.error(error));
  };

  const sendMail2 = (contact) => {
    // save the **mailsender** folder on public_html file
    // change the localURL to prod URL like http://domain.com/mailsender/public/email/send
    axios
      .post("http://localhost:80/mailsender/public/email/send2", contact)
      .then((response) => { 
        document.getElementById("btnSubmit2").disabled = false;
        $('input[type="submit"]').prop('disabled', false);
        document.getElementById("contactForm2").reset();
        window.alert(`Su mensaje ha sido enviado con éxito`);
      })
      .catch((error) => console.error(error));
  };

  const form = document.querySelector("#contactForm2");

  const formEvent = form.addEventListener("submit", (event) => {
    event.preventDefault();
    document.getElementById("btnSubmit2").disabled = true;
    $('input[type="submit"]').prop('disabled', true);

    const email = document.querySelector("#contactEmail").value;
    const name = document.querySelector("#contactName").value;
    const message = document.querySelector("#message").value;
    
    const contact = { name, email, message};
    sendMail2(contact);
  });
});
