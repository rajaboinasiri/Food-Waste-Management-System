document.addEventListener('DOMContentLoaded', () => {
  const name = localStorage.getItem('userName');
  const email = localStorage.getItem('userEmail');
  const phone = localStorage.getItem('userPhone');

  document.getElementById('profile-name').textContent = name || 'N/A';
  document.getElementById('profile-email').textContent = email || 'N/A';
  document.getElementById('profile-phone').textContent = phone || 'N/A';
});
