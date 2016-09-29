CREATE TABLE users(
	`id` int(255) unsigned auto_increment not null,
	`role` int(10) not null,
	`name` varchar(200),
	`surname` varchar(200),
	`email` varchar(255),
	`password` varchar(255),
	`image` varchar(255),
	CONSTRAINT pk_users PRIMARY KEY(id)
) ENGINE = InnoDB;

CREATE TABLE categories(
	`id` int(255) unsigned auto_increment not null,
	`name` varchar(200),
	`description` text,
	CONSTRAINT pk_categories PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE tags(
	`id` int(255) unsigned auto_increment not null,
	`name` varchar(255),
	`description` text,
	CONSTRAINT pk_tags PRIMARY KEY(id)
)ENGINE = InnoDB;

CREATE TABLE entries(
	`id` int(255) unsigned auto_increment not null,
	`user_id` int(255) unsigned not null,
	`category_id` int(255) unsigned not null,
	`title` varchar(255),
	`content` text,
	`status` varchar(20),
	`image` varchar(255),
	CONSTRAINT pk_entries PRIMARY KEY(id),
	FOREIGN KEY(user_id) references users(id),
	FOREIGN KEY(category_id) references categories(id)
)ENGINE = InnoDB;

CREATE TABLE entry_tag(
	`id` int(255) unsigned auto_increment not null,
	`entry_id` int(255) unsigned not null,
	`tag_id` int(255) unsigned not null,
	CONSTRAINT entry_tag PRIMARY KEY(id),
	FOREIGN KEY(entry_id) references entries(id),
	FOREIGN KEY(tag_id) references tags(id)
)ENGINE = InnoDB;