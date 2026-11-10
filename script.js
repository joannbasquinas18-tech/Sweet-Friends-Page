const heroText = document.getElementById('hero-text');
const phrases = [
  'A cozy little corner filled with smiles, giggles, and tiny surprises.',
  'Made for warm moments, soft laughs, and sweet memories.',
  'A gentle sparkle for the people who make life feel extra lovely.'
];

let phraseIndex = 0;
let charIndex = 0;
let deleting = false;

function typeLoop() {
  const current = phrases[phraseIndex];

  if (!deleting) {
    heroText.textContent = current.slice(0, charIndex + 1);
    charIndex += 1;

    if (charIndex === current.length) {
      deleting = true;
      setTimeout(typeLoop, 1200);
      return;
    }
  } else {
    heroText.textContent = current.slice(0, charIndex - 1);
    charIndex -= 1;

    if (charIndex === 0) {
      deleting = false;
      phraseIndex = (phraseIndex + 1) % phrases.length;
    }
  }

  setTimeout(typeLoop, deleting ? 60 : 90);
}

typeLoop();
