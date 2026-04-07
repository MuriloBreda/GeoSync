const stars = document.querySelectorAll(".stars span");

stars.forEach(star => {
    star.addEventListener("click", () => {
        let value = star.getAttribute("data-value");

        stars.forEach(s => s.classList.remove("active"));

        for (let i = 0; i < value; i++) {
            stars[i].classList.add("active");
        }
    });
});

function enviar() {
    alert("Avaliação enviada com sucesso!");
}