document.addEventListener('DOMContentLoaded', function () {
  const userMenu = document.querySelector('.user-menu');
  const dropdown = document.getElementById('dropdown');
  const userEmail = document.getElementById('user-email');

  userMenu.addEventListener('mouseenter', () => {
    dropdown.style.display = 'block';
  });

  userMenu.addEventListener('mouseleave', () => {
    dropdown.style.display = 'none';
  });

  const donateButton = document.getElementById('donate-food-btn');

  donateButton.addEventListener('mouseenter', () => {
    donateButton.style.backgroundColor = '#a59c94';
  });

  donateButton.addEventListener('mouseleave', () => {
    donateButton.style.backgroundColor = '#c0b8b0';
  });

  const profileLink = document.querySelector('#dropdown a.profile-link');
  const logoutLink = document.querySelector('#dropdown a.logout-link');

  profileLink && profileLink.addEventListener('click', () => {
    window.location.href = '/profile.php';
  });

  logoutLink && logoutLink.addEventListener('click', () => {
    window.location.href = '/logout';
  });

  donateButton.addEventListener('click', function () {
    window.location.href = 'donate.html';
  });
});
