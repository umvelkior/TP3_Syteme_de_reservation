# Base de donnée

**Titre**: TP3_reservation
**Nombre de Tables**: 2

## Table 1 - Utilisateurs

- id
- nom
- prénom
- date de naissance
- num de tel
- email
- mdp

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    date_de_naissance DATE,
    numero_telephone VARCHAR(15),
    email VARCHAR(100) UNIQUE NOT NULL,
    mdp VARCHAR(255) NOT NULL
);
```

## Table 2 - RDV

- id
- id de l'utilisateur
- titre
- date
- heure
- commentaire

```sql
CREATE TABLE rdv (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    jour DATE NOT NULL,
    heure TIME NOT NULL,
    commentaire VARCHAR(1000),
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id)
);
```