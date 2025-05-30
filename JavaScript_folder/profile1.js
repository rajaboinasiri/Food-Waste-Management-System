document.addEventListener('DOMContentLoaded', () => {
  const email = localStorage.getItem('userEmail');
  document.getElementById('profile-email').textContent = email || 'N/A';
});
