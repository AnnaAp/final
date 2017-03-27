
-- Дамп структуры для таблица apukhtina.answers
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `time_create` timestamp NOT NULL ,
  PRIMARY KEY (`id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп структуры для таблица apukhtina.problems
CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `time_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`,`id`),
  KEY `status_time` (`status`,`time_create`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп структуры для таблица apukhtina.topics
CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `topics_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп структуры для таблица apukhtina.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lgn_psw` (`login`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO users (login,password) VALUES ('admin','21232f297a57a5a743894a0e4a801fc3');

