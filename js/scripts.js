document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.memory-card');

    let hasFlippedCard = false;
    let lockBoard = false;
    let firstCard, secondCard;

    function flipCard() {
        if (lockBoard) return; // Bloque le clic si le plateau est verrouillé
        if (this === firstCard) return; // Empêche de cliquer deux fois sur la même carte

        this.classList.add('flipped'); // Ajoute la classe flipped pour montrer le front

        if (!hasFlippedCard) {
            hasFlippedCard = true;
            firstCard = this;
            return;
        }

        secondCard = this;
        lockBoard = true; // Verrouille le plateau
        checkForMatch();
    }

    function checkForMatch() {
        let isMatch = firstCard.dataset.pairId === secondCard.dataset.pairId;
        isMatch ? disableCards() : unflipCards();
    }

    function disableCards() {
        firstCard.removeEventListener('click', flipCard);
        secondCard.removeEventListener('click', flipCard);
        resetBoard();
    }

    function unflipCards() {
        setTimeout(() => {
            firstCard.classList.remove('flipped');
            secondCard.classList.remove('flipped');
            resetBoard();
        }, 1500); // Temps d'attente avant de retourner les cartes
    }

    function resetBoard() {
        [hasFlippedCard, lockBoard] = [false, false];
        [firstCard, secondCard] = [null, null];
    }

    cards.forEach(card => card.addEventListener('click', flipCard));
});
