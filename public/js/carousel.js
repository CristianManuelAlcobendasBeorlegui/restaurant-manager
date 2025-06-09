let index = 0;
const figures = document.querySelector(".carousel__figures");
const total = figures.children.length;
const container = document.querySelector(".carousel__container");
const buttons = document.querySelectorAll(".carousel__indicator-button");

function updateCarousel() {
  const width = figures.offsetWidth;
  figures.style.transform = `translateX(-${index * width}px)`;
}

buttons.forEach((button, i) => {
  button.addEventListener("click", () => {
    clearInterval(interval);

    document
      .querySelector(".carousel__indicator-button--active")
      .classList.remove("carousel__indicator-button--active");
    button.classList.add("carousel__indicator-button--active");

    index = i % total;
    updateCarousel();
    interval = setInterval(nextSlide, 10000);
  });
});

function nextSlide() {
  index = (index + 1) % total;
  document
    .querySelector(".carousel__indicator-button--active")
    .classList.remove("carousel__indicator-button--active");
  buttons[index].classList.add("carousel__indicator-button--active");
  updateCarousel();
}

let interval = setInterval(nextSlide, 10000);

// Actualiza el carrusel si cambia el tamaño de la ventana
window.addEventListener("resize", updateCarousel);

// Asegúrate de alinear correctamente al cargar la página
window.addEventListener("DOMContentLoaded", updateCarousel);
