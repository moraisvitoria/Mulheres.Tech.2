DROP DATABASE IF EXISTS redir;
CREATE DATABASE redir CHARACTER SET utf8 COLLATE utf8_general_ci;
USE redir;

CREATE TABLE users (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password TEXT NOT NULL,
    photo VARCHAR(255) NOT NULL,
    lastlogin TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('on', 'off', 'del') DEFAULT 'on'
);

INSERT INTO users (name, email, password, photo) VALUES
('Joca Silva', 'joca@silva.com', SHA1('Senha123'), 'https://randomuser.me/api/portraits/lego/1.jpg');

CREATE TABLE redir (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(64) NOT NULL,
    short VARCHAR(64) NOT NULL,
    url TEXT NOT NULL,
    user INT NOT NULL,
    expires DATE DEFAULT TIMESTAMPADD(DAY, 3650, NOW()),
    mode ENUM('url', '301') DEFAULT 'url',
    counter INT NOT NULL DEFAULT '0',
    status ENUM('on', 'off', 'del') DEFAULT 'on',
    FOREIGN KEY (user) REFERENCES users (id)
);

INSERT INTO redir (name, short, url, user) VALUES
('Google Drive', 'drive', 'https://drive.google.com/', '1'),
('Google Meet', 'meet', 'https://meet.google.com/fbn-yuyp-ays', '1'),
('CataBits', 'catabits', 'https://www.catabits.com.br/', '1'),
('By Luferat', 'luferat', 'https://www.luferat.net/', '1'),
('Koi Gourmet', 'koi', 'https://www.koidoces.com/', '1');
