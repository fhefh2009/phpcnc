SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `phpcnc`
--

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `collections`
--

CREATE TABLE IF NOT EXISTS `collections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned NOT NULL,
  `creator_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `is_read` tinyint(1) unsigned DEFAULT '0',
  `sender_id` int(11) unsigned NOT NULL,
  `receiver_id` int(11) unsigned NOT NULL,
  `type` tinyint(1) unsigned DEFAULT NULL,
  `topic_id` int(11) unsigned NOT NULL,
  `comment_id` int(11) unsigned NOT NULL,
  `created_on` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `statistics`
--

CREATE TABLE IF NOT EXISTS `statistics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_count` int(11) unsigned NOT NULL DEFAULT '0',
  `subject_count` int(11) unsigned NOT NULL DEFAULT '0',
  `topic_count` int(11) unsigned NOT NULL DEFAULT '0',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `statistics`
--

INSERT INTO `statistics` (`id`, `user_count`, `subject_count`, `topic_count`, `comment_count`) VALUES
(1, 0, 24, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `subjects`
--

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `topic_count` int(11) unsigned NOT NULL DEFAULT '0',
  `last_alter_on` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `description`, `topic_count`, `last_alter_on`) VALUES
(1, '分享交流', '分享自己觉得有趣，好玩，感兴趣的东西。', 0, NULL),
(2, '招聘', '求人才，求工作...', 0, NULL),
(3, '创业', '哪怕摔得粉身碎骨，我也坚定我的选择！', 0, NULL),
(4, '工作', '努力工作ING...', 0, NULL),
(5, '生活', '活着总在做的一件事——生活!爱生活！', 0, NULL),
(6, '师兄帮帮忙', '师兄，帮帮忙嘛！！！', 0, NULL),
(7, 'PHP', '好家伙！！！', 0, NULL),
(8, '框架', '搭一个框框，建一个架架，此物名曰：框架。', 0, NULL),
(9, '部署', 'Let''s talk about it!', 0, NULL),
(10, '前端', '越來越复杂的前端...', 0, NULL),
(11, ' Web安全', '安全啊安全！', 0, NULL),
(12, 'VPS', '我的虚拟专用服务器。', 0, NULL),
(13, 'XXAE', 'GAE，SAE，BAE，XXAE...', 0, NULL),
(14, '数据库', '一片数据汪洋。', 0, NULL),
(15, 'VCS', '版本控制，强有力的协作归档工具。', 0, NULL),
(16, ' GUI', 'PHP&GUI的暧昧！', 0, NULL),
(17, '开发工具', '工欲善其事，必先利其器！', 0, NULL),
(18, '翻译', '中文的魅力。', 0, NULL),
(19, '同城', '我在这里，你在那里？', 0, NULL),
(20, '活动', '一起搞活动！', 0, NULL),
(21, '大杂烩', '一个很大的文件夹，其中存储了类别不明的东西。', 0, NULL),
(22, 'PHPCNC', 'php china community', 0, NULL),
(23, '开源', '开源的力量！', 0, NULL),
(24, 'CMS', 'WordPress, Drupal, Joomla!... ', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `read_count` int(11) unsigned NOT NULL DEFAULT '0',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0',
  `created_on` int(11) unsigned NOT NULL,
  `updated_on` int(11) unsigned DEFAULT NULL,
  `author_id` int(11) unsigned NOT NULL,
  `last_commenter_id` int(11) unsigned DEFAULT NULL,
  `last_comment_on` int(11) unsigned DEFAULT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `blog` varchar(200) DEFAULT NULL,
  `intro` text,
  `avatar` varchar(50) DEFAULT NULL,
  `topic_count` int(11) unsigned NOT NULL DEFAULT '0',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0',
  `activation_code` varchar(100) NOT NULL,
  `forgotten_password_code` varchar(100) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
