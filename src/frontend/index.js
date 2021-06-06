import Glide from "@glidejs/glide";

const glide = new Glide("#ak-testimonial-slider", {
  type: "carousel",
  startAt: 0,
  perView: 3,
  autoplay: 5000,
  breakpoints: {
    800: {
      perView: 2,
    },
    400: {
      perView: 1,
    },
  },
}).mount();
