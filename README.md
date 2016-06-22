# Exercice PHP OO Euro2016

1. **Import / affichage des données**

- charger / parser le fichier competition.json
- affichez la liste des groupes ( nom du groupes et liste des équipes )
- rendre le nom du groupe cliquable.
- au clic : affichez la liste de matches du groupes et un bouton "retour à la liste"

- class **Competition**
  - a un constructeur attend l'url du json » parse et instancie des objets Groupes
  - a une propriété groups
  - a une méthode getGroupByName()

- class **Group**
  - a une propriété teams : un tableau d'objets Team
  - a une méthode getMatches() qui renvoie la liste de ses matchs

- classes ...

2. **Pronostics**
- pour chaque match affichez :
  - deux chps permettant de saisir et de stocker votre pronostic + un bouton de sauvegarde
  - deux chps permettant de saisir et de stocker le résultat réel + un bouton de sauvegarde

**Méthode** : vous stockez les résultats comme vous voulez sql / local / sqlite ou autres

3. **Résultats :** une fois tous les matchs joués :

- affichez le nombre de pronostics corrects :
  - vainqueur ou match nul deviné » 1pt
  - score deviné » 3pt

4. votre score ?