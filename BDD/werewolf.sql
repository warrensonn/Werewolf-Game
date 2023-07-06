-- Werewolf DB creation file

-- DB administration
DROP DATABASE IF EXISTS werewolf;
CREATE DATABASE IF NOT EXISTS werewolf;
GRANT SHOW DATABASES ON *.* TO werewolf@localhost IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON `werewolf`.* TO werewolf@localhost;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
USE werewolf;

-- DB structure creation

CREATE TABLE IF NOT EXISTS characters (
  name CHAR(30) UNIQUE NOT NULL,
  image_path CHAR(50) NOT NULL,
  PRIMARY KEY (name)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS game (
  id INT(3) UNIQUE NOT NULL,
  saving TINYINT(1) DEFAULT 0,
  killing TINYINT(1) DEFAULT 0,
  PRIMARY KEY (id_game)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS players (
  id_game INT(3) NOT NULL,
  pseudo CHAR(30) NOT NULL,
  role CHAR(30) NOT NULL,
  PRIMARY KEY (id_game, pseudo),
  FOREIGN KEY (role) REFERENCES characters(name),
  FOREIGN KEY (id_game) REFERENCES game(id)
) ENGINE=InnoDB;


-- Alimentation des données paramètres

INSERT INTO characters (name, image_path) VALUES
('Villageois', 'C:\xampp\htdocs\www\loupgarou\assets\villageois.png'),
('Loup-garou', 'C:\xampp\htdocs\www\loupgarou\assets\loup.png'),
('Voyante', 'C:\xampp\htdocs\www\loupgarou\assets\voyante.png'),
('Sorcière', 'C:\xampp\htdocs\www\loupgarou\assets\sorciere.png');

INSERT INTO game (id) VALUES
(0);

INSERT INTO players (id_game, pseudo, role) VALUES
(0, 'j1', 'Villageois'),
(0, 'j2', 'Villageois'),
(0, 'j3', 'Villageois'),
(0, 'j4', 'Voyante'),
(0, 'j5', 'Villageois'),
(0, 'j6', 'Sorcière'),
(0, 'j7', 'Loup-garou'),
(0, 'j8', 'Loup-garou'),
