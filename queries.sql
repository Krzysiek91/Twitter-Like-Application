CREATE DATABASE twitter;

USE twitter;

CREATE TABLE Users
(
  id INT AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  hash_pass VARCHAR(60) NOT NULL,
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

CREATE TABLE Comments
(
id INT AUTO_INCREMENT,
user_id INT NOT NULL,
tweet_id INT NOT NULL,
comment_text TEXT NOT NULL,
creation_date DATETIME NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY (tweet_id) REFERENCES Tweets(id)
)

CREATE TABLE MESSAGES
(
id INT NOT NULL AUTO_INCREMENT,
sender_id INT NOT NULL,
recipient_id INT NOT NULL,
message_text TEXT,
is_read TINYINT(4) DEFAULT NULL,
creation_date DATETIME NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY (sender_id) REFERENCES Users(id),
FOREIGN KEY (recipient_id) REFERENCES Users(id)
)