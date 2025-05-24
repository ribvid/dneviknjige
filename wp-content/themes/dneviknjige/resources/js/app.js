import './components/burger-menu.js';
import Tobii from '@midzer/tobii';

import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Import app.css and all CSS files from blocks, compositions, and utilities folders
// Using import.meta.glob as a workaround for Vite's lack of postcss-import-ext-glob support
import.meta.glob([
  '../css/app.css',
  '../css/blocks/*.css',
  '../css/compositions/*.css',
  '../css/utilities/*.css',
], {
  eager: true,
})

document.querySelectorAll('[data-element="gallery"]').forEach((galleryEl) => {
  const images = galleryEl.querySelectorAll('img');
  if (images.length === 0) return;

  let currentIndex = 0;

  function showNextImage() {
    // Fade out current image
    images[currentIndex].dataset.animate = "fadeOut"

    // Move to next image (loop back to first if at end)
    currentIndex = (currentIndex + 1) % images.length;

    // Show and fade in the next image
    images[currentIndex].dataset.animate = "fadeIn"
  }

  // Set up automatic rotation (optional)
  const interval = setInterval(showNextImage, 2000); // Change image every 2 seconds
})

if (document.querySelector('[data-element="lightbox"]')) {
  new Tobii({
    selector: '[data-element="lightbox"]',
    captionAttribute: 'data-caption',
    navLabel: [
      "Nazaj",
      "Naprej",
    ],
    closeLabel: "Zapri",
    dialogTitle: "Fotogalerija",
    counter: false,
  });
}
