CREATE DATABASE Projet_CSICSI;

USE Projet_CSI;

CREATE TABLE etudiants (
    matetu INT(20) PRIMARY KEY,
    nometu VARCHAR(155) NOT NULL,
    prenometu VARCHAR(155) NOT NULL,
    datnaissetu DATE NOT NULL,
    lieu_de_naissance VARCHAR(155) NOT NULL,
    mailetu VARCHAR(155) NOT NULL,
    numetu VARCHAR(20) NOT NULL,
    grou_td VARCHAR(20),
    niveau_user INT NOT NULL,
    id_enseignant INT,
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant)
);

CREATE TABLE enseignants (
    id_enseignant INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    prenom VARCHAR(155) NOT NULL,
    mail VARCHAR(155) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    departement VARCHAR(155) NOT NULL,
    specialite VARCHAR(155) NOT NULL,
    cod_edt INT(20),
    niveau_user INT NOT NULL,
    mat_secretaire INT
);

CREATE TABLE responsables_parcours (
    mat_res_parcour INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    prenom VARCHAR(155) NOT NULL,
    mail VARCHAR(155) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    id_enseignant INT,
    cod_cours INT(20),
    niveau_user INT NOT NULL,
    cod_evenement INT(20),
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant)
);

CREATE TABLE appareilleurs (
    id_appareilleur INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    prenom VARCHAR(155) NOT NULL,
    mail VARCHAR(155) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    cod_salle INT(20),
    niveau_user INT NOT NULL
);

CREATE TABLE secretaires (
    id_secretaire INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    prenom VARCHAR(155) NOT NULL,
    mail VARCHAR(155) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    niveau_user INT NOT NULL,
    id_etudiant INT,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (matetu)
);

CREATE TABLE cours_td (
    id_ct INT AUTO_INCREMENT PRIMARY KEY,
    typef ENUM('cours', 'td') NOT NULL,
    titre VARCHAR(155) NOT NULL,
    intitule VARCHAR(155) NOT NULL,
    contenu LONGBLOB NOT NULL,
    matiere VARCHAR(155) NOT NULL,
    id_enseignant INT,
    id_filiere INT,
    niveau INT NOT NULL,
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant)
);

CREATE TABLE documents (
    id_doc INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(155) NOT NULL,
    type_d VARCHAR(50) NOT NULL,
    annee YEAR NOT NULL,
    contenu LONGBLOB NOT NULL,
    id_auteur INT(20),
    id_filiere INT,
    niveau INT NOT NULL
);

CREATE TABLE salles (
    id_salle INT AUTO_INCREMENT PRIMARY KEY,
    nom_sa VARCHAR(155) NOT NULL,
    capacite INT NOT NULL,
    id_evenement INT,
    statut VARCHAR(50) NOT NULL
);

CREATE TABLE emplois_du_temps (
    cod_edt INT AUTO_INCREMENT PRIMARY KEY,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    niveau INT NOT NULL,
    contenu LONGBLOB NOT NULL,
    id_filiere INT,
    annee_uni YEAR NOT NULL
);

CREATE TABLE notes (
    id_note INT AUTO_INCREMENT PRIMARY KEY,
    cod_ue VARCHAR(50) NOT NULL,
    cod_ecue VARCHAR(50) NOT NULL,
    nom_mat VARCHAR(155) NOT NULL,
    annee_uni YEAR NOT NULL,
    note DECIMAL(5, 2) NOT NULL,
    date_n DATE NOT NULL,
    id_filiere INT,
    id_etudiant INT,
    id_enseignant INT,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (matetu),
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant)
);

CREATE TABLE bibliotheque (
    id_fichier INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(155) NOT NULL,
    description_b TEXT,
    date_b DATE NOT NULL,
    id_enseignant INT,
    mat_partenaire INT,
    mat_res_parcour INT,
    id_doc INT,
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant)
);

CREATE TABLE partenaires (
    mat_partenaire INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    contact VARCHAR(20) NOT NULL,
    mail VARCHAR(155) NOT NULL
);

CREATE TABLE parcours (
    cod_parcours INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    description_p TEXT NOT NULL,
    niveau INT NOT NULL,
    mat_res_parcour INT
);

CREATE TABLE responsables_exam (
    mat_res_examen INT(20) PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenoms VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    mat_res_ufr INT,
    mat_res_filiere INT,
    niveau_user INT NOT NULL,
    mat_res_parcour INT
);

CREATE TABLE inscriptions (
    id_inscription INT AUTO_INCREMENT PRIMARY KEY,
    date_i DATE NOT NULL,
    id_etudiant INT,
    mat_res_parcour INT,
    id_secretaire INT,
    id_filiere INT,
    niveau INT NOT NULL,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (matetu),
    FOREIGN KEY (id_secretaire) REFERENCES secretaires (id_secretaire)
);

CREATE TABLE responsables_ufr (
    mat_res_ufr INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    prenom VARCHAR(155) NOT NULL,
    email VARCHAR(155) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    id_enseignant INT,
    mat_res_filiere INT,
    mat_partenaire INT,
    niveau_user INT NOT NULL,
    mat_res_parcour INT
);

CREATE TABLE responsables_filieres (
    mat_res_filiere INT(20) PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    prenom VARCHAR(155) NOT NULL,
    email VARCHAR(155) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    id_filiere INT,
    cod_edt INT,
    niveau_user INT NOT NULL,
    id_enseignant INT,
    id_etudiant INT,
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (matetu)
);

CREATE TABLE evenements (
    cod_evenement INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(155) NOT NULL,
    date_e DATE NOT NULL,
    lieu VARCHAR(155) NOT NULL,
    contenu LONGBLOB,
    description TEXT
);

CREATE TABLE filieres (
    id_filiere INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(155) NOT NULL,
    mat_res_filiere INT,
    id_parcour INT,
    FOREIGN KEY (mat_res_filiere) REFERENCES responsables_filieres (mat_res_filiere),
    FOREIGN KEY (id_parcour) REFERENCES parcours (cod_parcours)
);

CREATE TABLE demandes (
    id_demande INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    statut VARCHAR(50) NOT NULL,
    id_enseignant INT,
    id_etudiant INT,
    FOREIGN KEY (id_enseignant) REFERENCES enseignants (id_enseignant),
    FOREIGN KEY (id_etudiant) REFERENCES etudiants (matetu)
);

-- Créer la table user
CREATE TABLE utilisateur (
    id_user INT(20) PRIMARY KEY,
    nom_user VARCHAR(155) NOT NULL,
    mp_user VARCHAR(155) NOT NULL,
    mail_user VARCHAR(100),
    niveau_user INT NOT NULL
);