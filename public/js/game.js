// Variables globales
let currentLevel = {
    id: null,
    word: '',
    images: [],
    hint: ''
};

let gameStats = {
    currentScore: 0,
    currentLevel: 1
};

// Initialiser le jeu
document.addEventListener('DOMContentLoaded', function() {
    loadGameStats();
    loadNewLevel();
    setupEventListeners();
});

// Charger les statistiques du joueur
function loadGameStats() {
    fetch('../api/getProfile.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.user) {
                gameStats.currentScore = data.user.score;
                gameStats.currentLevel = data.user.level;
                updateScoreDisplay();
            }
        })
        .catch(error => console.error('Erreur:', error));
}

// Charger un nouveau niveau
function loadNewLevel() {
    fetch('../api/getLevel.php')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.riddle) {
                currentLevel = data.riddle;
                displayImages(currentLevel.images);
                clearAnswerInput();
                clearHint();
            } else {
                showMessage('Erreur lors du chargement du niveau', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showMessage('Erreur de connexion', 'error');
        });
}

// Afficher les images
function displayImages(images) {
    const imageElements = ['image1', 'image2', 'image3', 'image4'];
    
    imageElements.forEach((id, index) => {
        const img = document.getElementById(id);
        if (images[index]) {
            // Utiliser Unsplash avec un ID photo aléatoire pour chaque image
            const randomId = Math.floor(Math.random() * 1000000);
            img.src = `https://images.unsplash.com/photo-${randomId}?w=500&h=500&fit=crop&auto=format`;
            img.onerror = function() {
                // Si l'image échoue, en charger une autre
                this.src = `https://images.unsplash.com/photo-${Math.floor(Math.random() * 1000000)}?w=500&h=500&fit=crop&auto=format`;
            };
        }
    });
}

// Configurer les écouteurs d'événements
function setupEventListeners() {
    // Bouton Soumettre
    document.getElementById('submitBtn').addEventListener('click', submitAnswer);
    
    // Entrée au clavier
    document.getElementById('answerInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            submitAnswer();
        }
    });
    
    // Clavier virtuel
    document.querySelectorAll('.key').forEach(key => {
        key.addEventListener('click', function() {
            if (this.id === 'deleteBtn') {
                deleteLastLetter();
            } else if (this.id === 'clearBtn') {
                clearAnswerInput();
            } else {
                addLetterToInput(this.dataset.letter);
            }
        });
    });
    
    // Bouton Indice
    document.getElementById('hintBtn').addEventListener('click', showHint);
}

// Ajouter une lettre à l'input
function addLetterToInput(letter) {
    const input = document.getElementById('answerInput');
    input.value += letter;
    input.focus();
}

// Supprimer la dernière lettre
function deleteLastLetter() {
    const input = document.getElementById('answerInput');
    input.value = input.value.slice(0, -1);
    input.focus();
}

// Effacer l'input
function clearAnswerInput() {
    document.getElementById('answerInput').value = '';
    clearResultMessage();
    document.getElementById('answerInput').focus();
}

// Afficher l'indice
function showHint() {
    const hintText = document.getElementById('hintText');
    const hint = currentLevel.hint || 'Pas d\'indice disponible';
    hintText.textContent = hint;
}

// Effacer l'indice
function clearHint() {
    document.getElementById('hintText').textContent = '';
}

// Soumettre la réponse
function submitAnswer() {
    const answer = document.getElementById('answerInput').value.trim();
    
    if (!answer) {
        showMessage('Écrivez quelque chose!', 'error');
        return;
    }
    
    const payload = {
        answer: answer,
        correct_word: currentLevel.word,
        riddle_id: currentLevel.id
    };
    
    fetch('../api/checkAnswer.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            showMessage(data.message, 'error');
            return;
        }
        
        if (data.correct) {
            // Bonne réponse!
            gameStats.currentScore += data.points;
            updateScoreDisplay();
            
            showMessage(`✅ ${data.message} +${data.points} points!`, 'success');
            
            // Charger le prochain niveau après 2 secondes
            setTimeout(() => {
                loadNewLevel();
            }, 2000);
        } else {
            // Mauvaise réponse
            showMessage(`❌ ${data.message} La réponse était: ${currentLevel.word}`, 'error');
            
            // Charger le prochain niveau après 3 secondes
            setTimeout(() => {
                loadNewLevel();
            }, 3000);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showMessage('Erreur lors de la vérification', 'error');
    });
}

// Afficher un message
function showMessage(message, type) {
    const messageEl = document.getElementById('resultMessage');
    messageEl.textContent = message;
    messageEl.className = `result-message ${type}`;
}

// Effacer le message
function clearResultMessage() {
    const messageEl = document.getElementById('resultMessage');
    messageEl.textContent = '';
    messageEl.className = 'result-message';
}

// Mettre à jour l'affichage du score
function updateScoreDisplay() {
    document.getElementById('currentScore').textContent = gameStats.currentScore;
    document.getElementById('currentLevel').textContent = gameStats.currentLevel;
}
