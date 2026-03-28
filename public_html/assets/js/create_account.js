document.querySelector('form').addEventListener('submit', async function (e) {
    e.preventDefault(); // Stop form from refreshing the page

    // 1. Capture Form Data
    const formData = new FormData(this);
    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');

    // 2. Client-side Validation
    if (password !== confirmPassword) {
        alert("Passwords do not match. Please try again.");
        return;
    }

    // 3. Data Mapping: Match keys expected by create_account.php
    // Combine First and Last names into 'full_name'
    const fullName = `${formData.get('first_name')} ${formData.get('last_name')}`;
    formData.append('full_name', fullName);
    
    // Map 'birthday' to 'dob'
    formData.append('dob', formData.get('birthday'));

    // 4. Submit and Handle Response
    try {
        const response = await fetch('assets/php/create_account.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            // Logic for a successful account creation
            alert(data.message);
            window.location.href = 'login.html'; 
        } else {
            // Logic for handled errors (e.g., duplicate email)
            alert("Registration failed: " + data.message);
        }

    } catch (error) {
        // Log network or unexpected parsing errors
        console.error('Submission error:', error);
        alert("A connection error occurred. Please check your internet and try again.");
    }
});