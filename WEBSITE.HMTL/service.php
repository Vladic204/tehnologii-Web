<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Auto</title>
    <link rel="stylesheet" href="css/service.css">
    <script src="js/service.js" defer></script>
    <link rel="stylesheet" href="service.css">
</head>
<body>

    <header>
        <h1>VVBBurlea NR1</h1>
        <p>Oferim cele mai bune servicii auto pentru mașina ta!</p>
    </header>

    <section class="service-grid">
        <div class="service-card">
            <i class="fas fa-wrench"></i>
            <h3>Revizii Tehnice</h3>
            <p>Verificăm și întreținem mașina ta pentru o funcționare optimă.</p>
        </div>

        <div class="service-card">
            <i class="fas fa-car-battery"></i>
            <h3>Diagnoză Auto</h3>
            <p>Detectăm orice problemă electronică sau mecanică.</p>
        </div>

        <div class="service-card">
            <i class="fas fa-spray-can"></i>
            <h3>Vopsitorie Auto</h3>
            <p>Servicii profesionale de vopsire și reparații caroserie.</p>
        </div>

        <div class="service-card">
            <i class="fas fa-oil-can"></i>
            <h3>Schimb Ulei</h3>
            <p>Schimb rapid de ulei și filtre pentru motorul tău.</p>
        </div>
    </section>

    <section class="appointment">
        <h2>Programează-te la Service</h2>
        <form>
            <label for="name">Nume:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Telefon:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="service">Alege serviciul:</label>
            <select id="service" name="service">
                <option>Revizie Tehnică</option>
                <option>Diagnoză Auto</option>
                <option>Vopsitorie Auto</option>
                <option>Schimb Ulei</option>
            </select>

            <button type="submit">Trimite Cererea</button>
        </form>
    </section>

</body>
</html>
