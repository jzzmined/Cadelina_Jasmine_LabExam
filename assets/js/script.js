// Show/hide password
document.querySelectorAll('.pw .eye').forEach(btn => {
  btn.addEventListener('click', () => {
    const input = btn.parentElement.querySelector('input');
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
  });
});

// Clear a field's error styling as the user types
document.querySelectorAll('.field input').forEach(inp => {
  inp.addEventListener('input', () => {
    inp.classList.remove('invalid');
    const err = inp.parentElement.querySelector('.err');
    if (err) err.remove();
  });
});

const forgot = document.getElementById('forgot');
if (forgot) forgot.addEventListener('click', e => {
  e.preventDefault();
  alert('Password reset is not part of this exam project.');
});