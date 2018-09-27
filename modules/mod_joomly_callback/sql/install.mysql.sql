CREATE TABLE IF NOT EXISTS `#__joomly_callback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
 `phone` varchar(100) NOT NULL,
  `call_time` varchar(100) NOT NULL,
 `created_at` varchar(100) NOT NULL,
 `page` text NOT NULL,
 `ip` varchar(100) NOT NULL,
 PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
