// JavaScript para mostrar/ocultar el menú
const menuToggle = document.getElementById('menuToggle');
const menuContent = document.getElementById('menuContent');

menuToggle.addEventListener('click', () => {
  menuContent.classList.toggle('show');
});
