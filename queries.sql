CREATE DATABASE twitter;

USE twitter;

CREATE TABLE Users
(
  id INT AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  hash_pass VARCHAR(60) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY(id)
);

//Użytkownik może mieć wiele wpisów, wpis może mieć tylko jednego Usera.
CREATE TABLE Tweets
(
  id INT AUTO_INCREMENT,
  user_id INT NOT NULL,
  text TEXT NOT NULL,
  creation_date TEXT NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY(user_id) REFERENCES Users(id) ON DELETE CASCADE
);