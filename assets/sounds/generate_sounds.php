<?php
// Ce script permet de générer des fichiers audio de base pour le jeu
// Il faut l'exécuter une fois pour créer les fichiers

// Fonction pour créer un fichier texte avec un message explicatif
function createSoundPlaceholder($filename, $message) {
    $file = fopen($filename, 'w');
    fwrite($file, $message);
    fclose($file);
    
    echo "Fichier créé : $filename<br>";
}

// Créer les fichiers de sons
createSoundPlaceholder('flip.mp3', "Ce fichier est un placeholder pour le son de retournement de carte.\nVeuillez le remplacer par un vrai fichier audio MP3.");
createSoundPlaceholder('match.mp3', "Ce fichier est un placeholder pour le son de correspondance trouvée.\nVeuillez le remplacer par un vrai fichier audio MP3.");
createSoundPlaceholder('nomatch.mp3', "Ce fichier est un placeholder pour le son d'erreur.\nVeuillez le remplacer par un vrai fichier audio MP3.");
createSoundPlaceholder('victory.mp3', "Ce fichier est un placeholder pour le son de victoire.\nVeuillez le remplacer par un vrai fichier audio MP3.");

echo "<p>Les fichiers de sons ont été créés avec succès. Veuillez les remplacer par de vrais fichiers audio MP3.</p>";
echo "<p>Vous pouvez trouver des sons gratuits sur des sites comme <a href='https://freesound.org/' target='_blank'>Freesound</a> ou <a href='https://mixkit.co/free-sound-effects/' target='_blank'>Mixkit</a>.</p>";
?>
