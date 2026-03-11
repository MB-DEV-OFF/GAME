// Basculer entre connexion et inscription
function toggleAuthForm() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    
    loginForm.classList.toggle('active');
    registerForm.classList.toggle('active');
    
    return false;
}

// Validation du formulaire d'inscription
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            const password = document.getElementById('register_password').value;
            const confirm = document.getElementById('register_password_confirm').value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Les mots de passe ne correspondent pas!');
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 6 caractères!');
            }
        });
    }
});
