#Base de donnée

**Titre**: TP3_reservation
**Nombre de Tables**: 2

##Table 1 - Utilisateur

- id
- pseudo
- email
- mdp

```sql
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
    mdp VARCHAR(255) NOT NULL,
);
```

##Table 2 - RDV

- id
- id de l'utilisateur
- titre
- date
- heure
- commentaire

```sql
CREATE TABLE rendezvous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    jour DATE NOT NULL,
    heure TIME NOT NULL,
    commentaire VARCHAR(1000),
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id)
);
```