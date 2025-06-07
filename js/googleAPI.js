window.handleCredentialResponse = function(response) {
    console.log("Encoded JWT ID token:", response.credential);

    fetch('/auth/google', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ token: response.credential })
    })
    .then(res => res.json())
    .then(data => {
      console.log('Logged in user:', data);
      window.location.href = "../client/client/home"; // Adjust path if needed
    });
  };