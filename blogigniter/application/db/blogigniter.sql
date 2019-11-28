-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-01-2019 a las 18:19:54
-- Versión del servidor: 5.6.20-log
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `blogigniter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl`
--

CREATE TABLE IF NOT EXISTS `acl` (
`ai` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_actions`
--

CREATE TABLE IF NOT EXISTS `acl_actions` (
`action_id` int(10) unsigned NOT NULL,
  `action_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `action_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  `category_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acl_categories`
--

CREATE TABLE IF NOT EXISTS `acl_categories` (
`category_id` int(10) unsigned NOT NULL,
  `category_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `category_desc` varchar(100) NOT NULL COMMENT 'Human readable description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auth_sessions`
--

CREATE TABLE IF NOT EXISTS `auth_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url_clean` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`category_id`, `name`, `url_clean`) VALUES
(1, 'Categoria 1.1.1', 'categoria-1'),
(3, 'Categoria 3', 'categoria-3'),
(4, 'Categoria 4', 'categoria-4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ci_sessions`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denied_access`
--

CREATE TABLE IF NOT EXISTS `denied_access` (
`ai` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `reason_code` tinyint(1) unsigned DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `group_user_posts`
--

CREATE TABLE IF NOT EXISTS `group_user_posts` (
`group_user_post_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `type` enum('favorite') NOT NULL DEFAULT 'favorite'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `group_user_posts`
--

INSERT INTO `group_user_posts` (`group_user_post_id`, `post_id`, `user_id`, `type`) VALUES
(2, 4, 531788111, 'favorite');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ips_on_hold`
--

CREATE TABLE IF NOT EXISTS `ips_on_hold` (
`ai` int(10) unsigned NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login_errors`
--

CREATE TABLE IF NOT EXISTS `login_errors` (
`ai` int(10) unsigned NOT NULL,
  `username_or_email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Volcado de datos para la tabla `login_errors`
--

INSERT INTO `login_errors` (`ai`, `username_or_email`, `ip_address`, `time`) VALUES
(35, 'root', '::1', '2019-01-08 10:04:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url_clean` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(100) NOT NULL,
  `posted` enum('si','no') NOT NULL DEFAULT 'no',
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `url_clean`, `content`, `description`, `created_at`, `image`, `posted`, `category_id`) VALUES
(2, 'Entrada número  2', 'entrada-numero-2', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="/curso01/uploads/post/esto-es-una-prueba-de-un-post-2.png" style="height:282px; width:500px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', '2018-12-27 15:51:06', 'lorem-ipsum.png', 'si', 3),
(3, 'Entrada número 3', 'entrada-numero-3', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', '', '2018-12-27 21:40:41', '', 'si', 1),
(4, 'Entrada número 4', 'entrada-numero-4', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="/curso01/uploads/post/esto-es-una-prueba-de-un-post-2.png" style="height:282px; width:500px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'Otros post creado con blogigniter', '2019-01-04 02:15:10', 'entrada-numero-4.png', 'si', 1),
(5, 'Entrada número  5', 'entrada-numero-5', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="/curso01/uploads/post/esto-es-una-prueba-de-un-post-2.png" style="height:282px; width:500px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. ', '2019-01-04 02:15:28', '', 'si', 1),
(6, 'Entrada número 6', 'entrada-numero-6', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><img alt="" src="/curso01/uploads/post/esto-es-una-prueba-de-un-post-2.png" style="height:282px; width:500px" /></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n', 'Descripción de tu super Post', '2019-01-04 02:16:05', 'testttt-testttsss.png', 'no', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post_comments`
--

CREATE TABLE IF NOT EXISTS `post_comments` (
`post_comment_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `comment` varchar(300) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `post_comments`
--

INSERT INTO `post_comments` (`post_comment_id`, `parent_id`, `comment`, `user_id`, `post_id`, `created_at`) VALUES
(1, NULL, 'Hola mundo', 531788111, 5, '2019-01-09 23:17:49'),
(2, 1, 'Hola mundo 2', 531788111, 5, '2019-01-09 23:17:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `username_or_email_on_hold`
--

CREATE TABLE IF NOT EXISTS `username_or_email_on_hold` (
`ai` int(10) unsigned NOT NULL,
  `username_or_email` varchar(255) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(12) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `auth_level` tinyint(3) unsigned NOT NULL,
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `passwd` varchar(60) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `passwd_recovery_code` varchar(60) DEFAULT NULL,
  `passwd_recovery_date` datetime DEFAULT NULL,
  `passwd_modified_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `name`, `surname`, `auth_level`, `banned`, `passwd`, `avatar`, `passwd_recovery_code`, `passwd_recovery_date`, `passwd_modified_at`, `last_login`, `created_at`, `modified_at`) VALUES
(112205711, 'admin2', 'asa@aaa.com', '', '', 9, '0', '$2y$11$Q3z2x1xgBW9Y26Uvw5.3OOg9eL73ETZhYFsyyw5QbflmfrIwIaC9G', '', NULL, NULL, NULL, NULL, '2019-01-03 10:06:39', '2019-01-03 10:06:39'),
(531788111, 'acy29', 'acy@gmail.com', 'Andres', 'Cruz', 1, '0', '$2y$11$f4ViF8bla.UWenXVywvDN.0DTLWPLexvn35zuLP1V.XlConvFKyLi', 'imagen_531788111.png', NULL, NULL, '2019-01-07 05:45:12', '2019-01-10 14:46:16', '2019-01-07 09:28:14', '2019-01-10 14:46:16'),
(1249563298, 'admin', 'admin@blogigniter.com', '', '', 9, '0', '$2y$11$f4ViF8bla.UWenXVywvDN.0DTLWPLexvn35zuLP1V.XlConvFKyLi', '4a4df-codeigniter-logo-png-transparent.png', NULL, NULL, '2019-01-05 13:12:01', '2019-01-10 18:18:51', '2018-12-30 10:18:49', '2019-01-10 18:18:51');

--
-- Disparadores `users`
--
DELIMITER //
CREATE TRIGGER `ca_passwd_trigger` BEFORE UPDATE ON `users`
 FOR EACH ROW BEGIN
    IF ((NEW.passwd <=> OLD.passwd) = 0) THEN
        SET NEW.passwd_modified_at = NOW();
    END IF;
END
//
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acl`
--
ALTER TABLE `acl`
 ADD PRIMARY KEY (`ai`), ADD KEY `action_id` (`action_id`), ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `acl_actions`
--
ALTER TABLE `acl_actions`
 ADD PRIMARY KEY (`action_id`), ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `acl_categories`
--
ALTER TABLE `acl_categories`
 ADD PRIMARY KEY (`category_id`), ADD UNIQUE KEY `category_code` (`category_code`), ADD UNIQUE KEY `category_desc` (`category_desc`);

--
-- Indices de la tabla `auth_sessions`
--
ALTER TABLE `auth_sessions`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`id`), ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indices de la tabla `denied_access`
--
ALTER TABLE `denied_access`
 ADD PRIMARY KEY (`ai`);

--
-- Indices de la tabla `group_user_posts`
--
ALTER TABLE `group_user_posts`
 ADD PRIMARY KEY (`group_user_post_id`), ADD UNIQUE KEY `post_id_2` (`post_id`,`user_id`,`type`), ADD KEY `user_id` (`user_id`), ADD KEY `post_id` (`post_id`);

--
-- Indices de la tabla `ips_on_hold`
--
ALTER TABLE `ips_on_hold`
 ADD PRIMARY KEY (`ai`);

--
-- Indices de la tabla `login_errors`
--
ALTER TABLE `login_errors`
 ADD PRIMARY KEY (`ai`);

--
-- Indices de la tabla `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`post_id`), ADD KEY `category_id` (`category_id`);

--
-- Indices de la tabla `post_comments`
--
ALTER TABLE `post_comments`
 ADD PRIMARY KEY (`post_comment_id`), ADD KEY `post_id` (`post_id`), ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `username_or_email_on_hold`
--
ALTER TABLE `username_or_email_on_hold`
 ADD PRIMARY KEY (`ai`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `acl`
--
ALTER TABLE `acl`
MODIFY `ai` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `acl_actions`
--
ALTER TABLE `acl_actions`
MODIFY `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `acl_categories`
--
ALTER TABLE `acl_categories`
MODIFY `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `denied_access`
--
ALTER TABLE `denied_access`
MODIFY `ai` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `group_user_posts`
--
ALTER TABLE `group_user_posts`
MODIFY `group_user_post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `ips_on_hold`
--
ALTER TABLE `ips_on_hold`
MODIFY `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `login_errors`
--
ALTER TABLE `login_errors`
MODIFY `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `posts`
--
ALTER TABLE `posts`
MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `post_comments`
--
ALTER TABLE `post_comments`
MODIFY `post_comment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `username_or_email_on_hold`
--
ALTER TABLE `username_or_email_on_hold`
MODIFY `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acl`
--
ALTER TABLE `acl`
ADD CONSTRAINT `acl_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `acl_actions` (`action_id`) ON DELETE CASCADE,
ADD CONSTRAINT `acl_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `acl_actions`
--
ALTER TABLE `acl_actions`
ADD CONSTRAINT `acl_actions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `acl_categories` (`category_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `group_user_posts`
--
ALTER TABLE `group_user_posts`
ADD CONSTRAINT `group_user_posts_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `group_user_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Filtros para la tabla `posts`
--
ALTER TABLE `posts`
ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `post_comments`
--
ALTER TABLE `post_comments`
ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
