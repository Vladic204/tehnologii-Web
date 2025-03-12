document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.appointment form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Previne trimiterea formularului în mod implicit

        // Colectează datele din formular
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const service = document.getElementById('service').value;

        // Validare număr de telefon (începe cu +373 și are 8 cifre suplimentare)
        const phonePattern = /^\+373\d{8}$/; // +373 urmat de exact 8 cifre
        if (!phonePattern.test(phone)) {
            alert('Te rugăm să introduci un număr de telefon valid care începe cu +373 și are 8 cifre suplimentare.');
            return; // Oprește executarea funcției dacă numărul de telefon nu este valid
        }

        // Aici puteți adăuga logica pentru trimiterea datelor la server sau afișarea unui mesaj
        console.log('Nume:', name);
        console.log('Telefon:', phone);
        console.log('Serviciu ales:', service);

        // Afișează un mesaj de confirmare
        alert('Cererea ta a fost trimisă cu succes! Te vom contacta în curând.');

        // Resetează formularul după trimitere
        form.reset();
    });
});