-- ============================================
-- Conversion du dump MySQL vers PostgreSQL
-- Base : if0_41822688_eneam
-- Date : sam. 06 juin 2026
-- ============================================

-- Supprimer les tables si elles existent (ordre inverse des dépendances)
DROP TABLE IF EXISTS contenir CASCADE;
DROP TABLE IF EXISTS commande CASCADE;
DROP TABLE IF EXISTS client CASCADE;
DROP TABLE IF EXISTS article CASCADE;
DROP TABLE IF EXISTS "user" CASCADE;

-- --------------------------------------------------------
-- Table `article`
-- --------------------------------------------------------
CREATE TABLE article (
    id_article VARCHAR(20) PRIMARY KEY,
    design VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    categorie VARCHAR(50) NOT NULL
);

INSERT INTO article (id_article, design, prix, categorie) VALUES
('23312', 'LENOVO Core I7 RAM 16 GB SSD 512GB', 429998.00, 'Informatique'),
('3587', 'HIRA 50Cl', 800.00, 'Autres'),
('56', 'SAC NEW MOD PL POWER', 13500.00, 'Autres'),
('6547', 'PROJECTEUR 12A', 26000.00, 'Électronique'),
('6668', 'REDMI 14C 256 GB', 70000.00, 'Informatique'),
('73737', 'CLIMATISEUR', 85000.00, 'Électronique'),
('780', 'LAROUSSE', 7500.00, 'Fournitures'),
('MT320', 'ROLEX OYSTER', 35000.00, 'Vêtements'),
('SM2631', 'SAMSUNG RAM 4GB 128 GB', 85000.00, 'Électronique'),
('VT5399', 'MANCHETTE OR', 3200.00, 'Vêtements');

-- --------------------------------------------------------
-- Table `client`
-- --------------------------------------------------------
CREATE TABLE client (
    id_client SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    age SMALLINT NULL,
    adresse VARCHAR(100) NOT NULL,
    ville VARCHAR(50) NOT NULL,
    mail VARCHAR(100) NULL
);

INSERT INTO client (id_client, nom, prenom, age, adresse, ville, mail) VALUES
(1, 'Edi', 'TOSEOU', 53, 'Gbagamey', 'COTONOU', 'calebvic5@gmail.com'),
(2, 'DOSON', 'Deuni', 8, 'Pobox25', 'Cotonou', 'donu@gmail.com');

-- Redémarrer la séquence après les INSERT manuels
SELECT setval('client_id_client_seq', (SELECT MAX(id_client) FROM client));

-- --------------------------------------------------------
-- Table `commande`
-- --------------------------------------------------------
CREATE TABLE commande (
    id_comm SERIAL PRIMARY KEY,
    date DATE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    id_client INTEGER NOT NULL REFERENCES client(id_client) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO commande (id_comm, date, montant, id_client) VALUES
(1, '2026-05-04', 530798.00, 1),
(2, '2026-05-05', 2869988.00, 2);

SELECT setval('commande_id_comm_seq', (SELECT MAX(id_comm) FROM commande));

-- --------------------------------------------------------
-- Table `contenir`
-- --------------------------------------------------------
CREATE TABLE contenir (
    id_comm INTEGER NOT NULL REFERENCES commande(id_comm) ON DELETE CASCADE ON UPDATE CASCADE,
    id_article VARCHAR(20) NOT NULL REFERENCES article(id_article) ON DELETE CASCADE ON UPDATE CASCADE,
    qtecomm INTEGER NOT NULL DEFAULT 1,
    PRIMARY KEY (id_comm, id_article)
);

INSERT INTO contenir (id_comm, id_article, qtecomm) VALUES
(1, '23312', 1),
(1, '3587', 1),
(1, '6668', 1),
(1, '780', 4),
(2, '23312', 6),
(2, '73737', 2),
(2, 'MT320', 1),
(2, 'SM2631', 1);

-- --------------------------------------------------------
-- Table `user` (échappée car mot réservé PostgreSQL)
-- --------------------------------------------------------
CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO "user" (id, nom, prenom, contact, login, password) VALUES
(1, 'Raoul', 'DASE', '0197350055', 'GNALO26', '$2y$10$szNzS/2DdUF1YYpBEjwvbuEc2omq7h8TNOLE7sKVeOqlEToIej8e.'),
(2, 'AMOUSSOU', 'Lewis', '0154766900', 'prof', '$2y$10$HQ7DXHgGb.hmAVfn/o/uMuDLgwVZHY3WAiTKjTLYTSgunfipuRTUq'),
(3, 'ALOGNISSOU', 'Astrid', '0198464263', 'Etu1', '$2y$10$HRXnlH2z1RkaKp9LTErqYuXtohbdrjKUK0ikhfm3PbDKAtVTVpL8a'),
(4, 'Glazaï', 'Jolie', '26789087', 'Etu', '$2y$10$6lmV7S.CVpZfEMHFf2byeeCYfIGWUSJ4eA6fT4tF6jclTDdMyMuxO'),
(5, 'Bohinou', 'Debora', '0167896789', 'Deb7', '$2y$10$hcy0Kl1EMpcpjfJq2H1l2.bA8Nk.k7lbKI7h9uSN9QQXBdJVK.HJW'),
(6, 'DJANGONI', 'Baudouin', '0190575678', 'djangoni@001', '$2y$10$mblI/Iyq3hyBt.KKrwKMjeu5M0SZNL8vfBfTFg8.TYSfCRulbRYQm'),
(7, 'ADODE', 'Flos', '0145678390', 'adodeme@001', '$2y$10$eX.bkblXnVq.nEiVftFZ.wS.Bv7srVEJPAAOAssb12.CIYuk8G5C'),
(8, 'Koukponou', 'Obed', '+2290140690762', 'Ert344', '$2y$10$Pb76vcEpotVoXmBGMKMQseVgokiGlKJxJYinCYlwsXxyfuK8kPX5G');

SELECT setval('user_id_seq', (SELECT MAX(id) FROM "user"));

-- --------------------------------------------------------
-- Fin de la conversion
-- --------------------------------------------------------