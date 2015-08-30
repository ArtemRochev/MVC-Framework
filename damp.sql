drop database book;
drop user book;

CREATE DATABASE book 
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;

CREATE USER book IDENTIFIED BY '1111';
GRANT ALL ON book.* TO book;

USE book;

CREATE TABLE user (
	user_id INT PRIMARY KEY AUTO_INCREMENT,
	user_name varchar(100) NOT NULL,
	user_email varchar(100) NOT NULL UNIQUE
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;
	
CREATE TABLE comment (
	comment_id INT PRIMARY KEY AUTO_INCREMENT,
	comment_user_id INT NOT NULL,
	comment_text TEXT NOT NULL,
	comment_time TIMESTAMP NOT NULL,
	comment_changed_by_admin INT(1) DEFAULT 0,
	FOREIGN KEY (comment_user_id)
		REFERENCES user(user_id)
) DEFAULT CHARSET=utf8 ENGINE=InnoDB;

INSERT INTO user (user_name, user_email) VALUES
	("Oleg", "oleg@gmail.com"),
	("Artem", "artem@gmail.com"),
	("Vova", "vova@gmail.com")
;

INSERT INTO comment (comment_user_id, comment_text) VALUES
	(1, "Классаня статья, спасибо!!"),
	(2, "мне тож понравилась)))"),
	(3, "супер!:)"),
	(2, "продам холодильник, тел 924679468")
;

select * from user;
select * from comment;
