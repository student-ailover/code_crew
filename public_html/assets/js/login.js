document.querySelector('form').addEventListener('submit', async function (e) {
    e.preventDefault(); // Prevent the default form submission (page refresh)

    // 1. Capture the data from the form
    const formData = new FormData(this);

    try {
        // 2. Send the request to login.php
        const response = await fetch('assets/php/login.php', {
            method: 'POST',
            body: formData
        });

        // Check if the server responded correctly (e.g., status 200)
        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        // 3. Parse the JSON response
        const data = await response.json();

        if (data.success) {
            // Success: Notify the user and redirect to the dashboard or main page
            alert("Welcome back, " + data.user_name + "!");
            window.location.href = 'main.html'; 
        } else {
            // Failure: Display the error message (e.g., "Invalid email or password")
            alert("Login Failed: " + data.message);
        }

    } catch (error) {
        // Handle network or unexpected errors
        console.error('Login Error:', error);
        alert("A connection error occurred. Please try again later.");
    }
});