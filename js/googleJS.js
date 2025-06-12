window.handleCredentialResponse = function(response) {
  fetch('../auth/google_AUTH.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ token: response.credential })
  })
  .then(res => res.json())
  .then(data => {
    window.location.href = data.redirect;
  });
};
