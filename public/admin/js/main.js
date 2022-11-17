document.querySelector('.menu').addEventListener('click', () => {
  document.querySelector('.sidebar').classList.toggle('hide');
  document.querySelector('.main').classList.toggle('zero-padding');
});
document.querySelector('.profile').addEventListener('click', () => {
  document.querySelector('.profile-menu').classList.toggle('hide');
});
