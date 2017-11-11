CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(255) NOT NULL,
  login CHAR(128) UNIQUE NOT NULL,
  pass CHAR(64),
  age DATE,
  description TEXT(2056),
  img CHAR(256)
);