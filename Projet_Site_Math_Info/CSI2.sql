
USE Projet_CSI;

-- Créer la table user
CREATE TABLE utilisateur (
    id_user INT(20) PRIMARY KEY,
    nom_user VARCHAR(155) NOT NULL,
    mp_user VARCHAR(155) NOT NULL,
    niveau_user INT NOT NULL
);

-- Modifier la table enseignant pour ajouter la colonne niveau_user
ALTER TABLE enseignants ADD COLUMN niveau_user INT;

-- Modifier la table etudiant pour ajouter la colonne niveau_user
ALTER TABLE etudiants ADD COLUMN niveau_user INT;

-- Modifier la table appareilleur pour ajouter la colonne niveau_user
ALTER TABLE appareilleurs ADD COLUMN niveau_user INT;

-- Modifier la table secretaire pour ajouter la colonne niveau_user
ALTER TABLE secretaires ADD COLUMN niveau_user INT;

-- Modifier la table responsable_ufr pour ajouter la colonne niveau_user
ALTER TABLE responsables_ufr ADD COLUMN niveau_user INT;

-- Modifier la table responsable_parcours pour ajouter la colonne niveau_user
ALTER TABLE responsables_parcours ADD COLUMN niveau_user INT;

-- Modifier la table responsable_exam pour ajouter la colonne niveau_user
ALTER TABLE responsables_exam ADD COLUMN niveau_user INT;

-- Modifier la table responsable_filiere pour ajouter la colonne niveau_user
ALTER TABLE responsables_filieres ADD COLUMN niveau_user INT;

-- Modifier la table utilisateur pour ajouter la colonne mail_user
ALTER TABLE utilisateur ADD COLUMN mail_user VARCHAR(100);
