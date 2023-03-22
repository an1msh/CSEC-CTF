CREATE DATABASE ctf_db;
CREATE USER 'ctf_user'@'localhost' IDENTIFIED BY 'reconftw';
GRANT ALL PRIVILEGES ON ctf_db.* TO 'ctf_user'@'localhost';

USE ctf_db;

CREATE TABLE users ( id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL);

exit
