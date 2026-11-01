# Preguntes de reflexió
1. **Per què guardem qui ha votat al servidor (al fitxer de vots) i no en una cookie ha_votat? Què podria fer un alumne si ho guardéssim en una cookie?**
Ho guardem al servidor perque l'alumne no ho pugui modificar, si fos una cookie podria editarla  amb F12 o entrar des d'un altre navegador i tornar a votar.

2. **Què passa si un usuari canvia el valor de la cookie darrera_visita a les eines del navegador? Com ho heu controlat?**
Ho he controlat comprovant que siguin nomes digits  majors que 0 i d'un temps anterior a l'actualitat si no es aixi es considera com si fos la primera visita.

3. **Quina diferència hi ha entre el timeout de 5 minuts de la sessió i els 30 dies de la cookie darrera_visita? On es guarda cada dada?**
El timeout de 5 minuts es guarda al servidor i es per seguretat, mentre que la cookie de darrera_visita es guarda al navegador i serveix per comoditat.

4. **A index.php, per què no podem mostrar l'hora que acabem de guardar a darrera_visita llegint $_COOKIE['darrera_visita'] a la mateixa petició?**
Perque la cookie no te aquest valor fins a la propera petició.