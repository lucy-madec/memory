document.addEventListener('DOMContentLoaded', () => {
    // Éléments DOM
    const cards = document.querySelectorAll('.memory-card');
    const timerElement = document.getElementById('timer');
    const movesCountElement = document.getElementById('moves-count');
    const pairsCountElement = document.getElementById('pairs-count');
    const totalPairsElement = document.getElementById('total-pairs');
    const gameOverModal = new bootstrap.Modal(document.getElementById('gameOverModal'));
    const modalPlayerName = document.getElementById('modal-player-name');
    const modalTime = document.getElementById('modal-time');
    const modalMoves = document.getElementById('modal-moves');
    const playAgainBtn = document.getElementById('play-again-btn');

    // Variables du jeu
    let hasFlippedCard = false;
    let lockBoard = false;
    let firstCard, secondCard;
    let matchedPairs = 0;
    let moves = gameData.moves || 0;
    let gameTimer;
    let seconds = 0;
    let gameOver = false;
    
    // Initialisation
    function initGame() {
        // Mettre à jour les compteurs
        movesCountElement.textContent = moves;
        pairsCountElement.textContent = matchedPairs;
        totalPairsElement.textContent = gameData.totalPairs;
        
        // Démarrer le chronomètre
        startTimer();
        
        // Ajouter les événements aux cartes
        cards.forEach(card => card.addEventListener('click', flipCard));
        
        // Événement pour rejouer
        playAgainBtn.addEventListener('click', () => {
            window.location.href = 'index.php';
        });
        
        // Ajouter des effets sonores
        loadSounds();
    }
    
    // Effets sonores
    let flipSound, matchSound, noMatchSound, victorySound;
    
    function loadSounds() {
        flipSound = new Audio('assets/sounds/flip.mp3');
        matchSound = new Audio('assets/sounds/match.mp3');
        noMatchSound = new Audio('assets/sounds/nomatch.mp3');
        victorySound = new Audio('assets/sounds/victory.mp3');
        
        // Précharger les sons
        flipSound.load();
        matchSound.load();
        noMatchSound.load();
        victorySound.load();
        
        // Réduire le volume
        flipSound.volume = 0.3;
        matchSound.volume = 0.3;
        noMatchSound.volume = 0.3;
        victorySound.volume = 0.5;
    }
    
    function playSound(sound) {
        if (sound) {
            sound.currentTime = 0;
            sound.play().catch(e => console.log('Erreur de lecture audio:', e));
        }
    }
    
    // Gestion du chronomètre
    function startTimer() {
        const startTime = gameData.startTime * 1000; // Convertir en millisecondes
        const elapsedTime = Math.floor((Date.now() - startTime) / 1000);
        seconds = elapsedTime > 0 ? elapsedTime : 0;
        
        updateTimerDisplay();
        
        gameTimer = setInterval(() => {
            seconds++;
            updateTimerDisplay();
        }, 1000);
    }
    
    function updateTimerDisplay() {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
    }
    
    function stopTimer() {
        clearInterval(gameTimer);
    }
    
    // Gestion des cartes
    function flipCard() {
        if (lockBoard) return;
        if (this === firstCard) return;
        if (this.classList.contains('flipped')) return;

        playSound(flipSound);
        this.classList.add('flipped');

        if (!hasFlippedCard) {
            // Premier clic
            hasFlippedCard = true;
            firstCard = this;
            return;
        }

        // Deuxième clic
        secondCard = this;
        incrementMoves();
        checkForMatch();
    }

    function incrementMoves() {
        moves++;
        movesCountElement.textContent = moves;
        
        // Enregistrer le nombre de mouvements dans la session
        fetch('save_moves.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `moves=${moves}`
        }).catch(error => console.error('Erreur lors de la sauvegarde des mouvements:', error));
    }

    function checkForMatch() {
        const isMatch = firstCard.dataset.pairId === secondCard.dataset.pairId;

        if (isMatch) {
            playSound(matchSound);
            disableCards();
            incrementPairs();
        } else {
            playSound(noMatchSound);
            unflipCards();
        }
    }

    function disableCards() {
        firstCard.removeEventListener('click', flipCard);
        secondCard.removeEventListener('click', flipCard);
        
        // Ajouter une classe pour indiquer que les cartes sont trouvées
        firstCard.classList.add('matched');
        secondCard.classList.add('matched');
        
        resetBoard();
    }

    function unflipCards() {
        lockBoard = true;

        setTimeout(() => {
            firstCard.classList.remove('flipped');
            secondCard.classList.remove('flipped');
            resetBoard();
        }, 1000);
    }

    function resetBoard() {
        [hasFlippedCard, lockBoard] = [false, false];
        [firstCard, secondCard] = [null, null];
    }
    
    function incrementPairs() {
        matchedPairs++;
        pairsCountElement.textContent = matchedPairs;
        
        // Vérifier si toutes les paires sont trouvées
        if (matchedPairs === gameData.totalPairs) {
            endGame();
        }
    }
    
    // Fin de partie
    function endGame() {
        if (gameOver) return;
        gameOver = true;
        
        stopTimer();
        playSound(victorySound);
        
        // Mettre à jour les informations du modal
        modalPlayerName.textContent = gameData.playerName;
        modalTime.textContent = timerElement.textContent;
        modalMoves.textContent = moves;
        
        // Sauvegarder le score
        saveScore();
        
        // Afficher le modal après un court délai
        setTimeout(() => {
            gameOverModal.show();
        }, 500);
    }
    
    function saveScore() {
        fetch('save_score.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `time=${seconds}&moves=${moves}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Score sauvegardé avec succès');
            } else {
                console.error('Erreur lors de la sauvegarde du score:', data.message);
            }
        })
        .catch(error => console.error('Erreur lors de la sauvegarde du score:', error));
    }
    
    // Démarrer le jeu
    initGame();
});
