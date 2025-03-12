document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");
    const searchButton = document.getElementById("search-button");
    const categoriesContainer = document.querySelector(".categories"); // Containerul categoriilor
    const categories = document.querySelectorAll(".category");

    function searchCars() {
        const searchText = searchInput.value.toLowerCase();
        let resultsFound = false;

        categories.forEach(category => {
            const title = category.querySelector("h3").innerText.toLowerCase();
            const description = category.querySelector("p").innerText.toLowerCase();

            if (title.includes(searchText) || description.includes(searchText)) {
                category.style.display = "block";
                resultsFound = true;
            } else {
                category.style.display = "none";
            }
        });

        if (resultsFound) {
            categoriesContainer.style.display = "flex";  // Afișează containerul în mod flex pentru aliniere
            categoriesContainer.style.justifyContent = "center"; // Centrează rezultatele
            categoriesContainer.style.flexWrap = "wrap"; // Asigură alinierea ordonată
        } else {
            categoriesContainer.style.display = "none"; // Ascunde complet containerul dacă nu sunt rezultate
        }
    }

    searchButton.addEventListener("click", searchCars);

    // Permite căutarea și la apăsarea tastei Enter
    searchInput.addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            searchCars();
        }
    });
});
