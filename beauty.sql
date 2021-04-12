-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 08 2019 г., 09:52
-- Версия сервера: 5.7.11
-- Версия PHP: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `beauty`
--

-- --------------------------------------------------------

--
-- Структура таблицы `master_orders`
--

CREATE TABLE IF NOT EXISTS `master_orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1558534850),
('m130524_201442_init', 1558534852),
('m190124_110200_add_verification_token_column_to_user_table', 1558534852),
('m190524_084601_add_user_columns', 1558688396),
('m190524_090857_delete_username_column_from_user_table', 1558689065);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `master_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `date` int(11) NOT NULL,
  `place` int(11) NOT NULL DEFAULT '0',
  `pay_method` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `category_id`, `master_id`, `description`, `date`, `place`, `pay_method`, `price`) VALUES
(3, 1, 11, NULL, 'Массаж', 1561797900, 0, 0, 1000),
(4, 1, 9, NULL, 'Описание', 1561172760, 2, 0, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `swp_field`
--

CREATE TABLE IF NOT EXISTS `swp_field` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `default` text COLLATE utf8_unicode_ci NOT NULL,
  `params` text COLLATE utf8_unicode_ci,
  `is_require` tinyint(1) NOT NULL DEFAULT '0',
  `is_hidden` tinyint(1) NOT NULL DEFAULT '0',
  `is_search` tinyint(1) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `swp_field`
--

INSERT INTO `swp_field` (`id`, `group_id`, `title`, `default`, `params`, `is_require`, `is_hidden`, `is_search`, `type`, `sort`, `status`) VALUES
(1, 2, 'Заголовок', '', NULL, 0, 0, 0, 0, 0, 100),
(2, 2, 'Иконка', 'fa-circle-o', NULL, 0, 0, 0, 900, 10, 10),
(3, 3, 'Контроллер', '', NULL, 0, 0, 0, 100, 0, 10),
(4, 3, 'Действие', '', NULL, 0, 0, 0, 100, 10, 10),
(5, 3, 'Ссылка на существующий материал', '', '{"groups" : [0]}', 0, 0, 0, 400, 20, 10),
(6, 3, 'Родительское меню', '', '{"groups" : [1]}', 0, 0, 0, 400, 30, 10),
(7, 3, 'Дополнительные контроллеры для активации', '', NULL, 0, 0, 0, 100, 40, 10),
(8, 5, 'Заголовок', '', NULL, 0, 0, 0, 0, 0, 100),
(9, 5, 'Описание сайта (рекомендуется не более 160 символов', '', NULL, 0, 0, 0, 200, 10, 10),
(10, 6, 'Почтовый протокол', '0', '{"items" : ["Mail", "SMTP"]}', 0, 0, 0, 400, 0, 10),
(11, 6, 'SMTP Имя сервера', '', NULL, 0, 0, 0, 100, 10, 10),
(12, 6, 'SMTP Логин', '', NULL, 0, 0, 0, 100, 20, 10),
(13, 6, 'SMTP Пароль', '', NULL, 0, 0, 0, 100, 30, 10),
(14, 6, 'SMTP Порт', '', NULL, 0, 0, 0, 100, 40, 10),
(15, 6, 'SMTP Протокол шифрования', '', NULL, 0, 0, 0, 100, 50, 10),
(16, 8, 'Название', '', NULL, 0, 0, 0, 0, 0, 100),
(17, 8, 'Изображение', '', NULL, 1, 0, 0, 600, 10, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `swp_group`
--

CREATE TABLE IF NOT EXISTS `swp_group` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_singleton` tinyint(1) NOT NULL DEFAULT '0',
  `type` smallint(6) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `swp_group`
--

INSERT INTO `swp_group` (`id`, `group_id`, `slug`, `title`, `is_singleton`, `type`, `sort`, `status`) VALUES
(1, 0, 'menyu', 'Меню', 0, 100, 0, 100),
(2, 1, 'osnovnoe', 'Основное', 0, 0, 0, 100),
(3, 1, 'svyazi', 'Связи', 0, 0, 10, 100),
(4, 0, 'nastroyki', 'Настройки', 1, 100, 10, 100),
(5, 4, 'osnovnoe', 'Основное', 0, 0, 0, 100),
(6, 4, 'pochta', 'Почта', 0, 0, 10, 100),
(7, 0, 'kategorii-uslug', 'Категории услуг', 0, 100, 20, 10),
(8, 7, 'osnovnoe', 'Основное', 0, 0, 0, 100);

-- --------------------------------------------------------

--
-- Структура таблицы `swp_material`
--

CREATE TABLE IF NOT EXISTS `swp_material` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` smallint(6) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `swp_material`
--

INSERT INTO `swp_material` (`id`, `group_id`, `material_id`, `slug`, `title`, `sort`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'razrabotka', 'Разработка', 0, 10, 1558534852, 1558534852),
(2, 1, 0, 'materialov', 'Материалов', 10, 10, 1558534852, 1558534852),
(3, 1, 0, 'menyu', 'Меню', 20, 10, 1558534852, 1558534852),
(4, 1, 0, 'faylovyy-menedzher', 'Файловый менеджер', 30, 10, 1558534852, 1558534852),
(5, 1, 0, 'polzovateli', 'Пользователи', 40, 10, 1558534852, 1558534852),
(6, 1, 0, 'nastroyki', 'Настройки', 50, 10, 1558534852, 1558534852),
(7, 1, 0, 'kategorii', 'Категории', 15, 10, 1559388019, 1559388033),
(8, 7, 0, 'kosmetologiya-i-makiyazh', 'Косметология и макияж ', 0, 10, 1559643773, 1559643773),
(9, 7, 0, 'nogtevoy-servis', 'Ногтевой сервис ', 10, 10, 1559643790, 1559644325),
(10, 7, 0, 'parikmaherskie-uslugi', 'Парикмахерские услуги', 20, 10, 1559643806, 1559643806),
(11, 7, 0, 'massazh', 'Массаж', 30, 10, 1559643834, 1559643834),
(12, 7, 0, 'depilyaciya', 'Депиляция', 40, 10, 1559643848, 1559643848),
(13, 7, 0, 'resnicy-i-brovi', 'Ресницы и брови', 50, 10, 1559643863, 1559643863);

-- --------------------------------------------------------

--
-- Структура таблицы `swp_material_field`
--

CREATE TABLE IF NOT EXISTS `swp_material_field` (
  `id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `swp_material_field`
--

INSERT INTO `swp_material_field` (`id`, `material_id`, `field_id`, `value`) VALUES
(1, 1, 2, 'fa-cogs'),
(2, 2, 2, 'fa-circle-o'),
(3, 2, 3, 'swp/group'),
(4, 2, 6, 'm_1'),
(5, 2, 7, 'swp/field'),
(6, 3, 2, 'fa-circle-o'),
(7, 3, 5, 'g_1'),
(8, 3, 6, 'm_1'),
(9, 4, 2, 'fa-files-o'),
(10, 4, 3, 'site'),
(11, 4, 4, 'files'),
(12, 5, 2, 'fa-users'),
(13, 5, 3, 'user'),
(14, 6, 2, 'fa-cog'),
(15, 6, 5, 'g_4'),
(16, 7, 2, 'fa-book'),
(17, 7, 3, ''),
(18, 7, 4, ''),
(19, 7, 5, 'g_7'),
(20, 7, 6, ''),
(21, 7, 7, ''),
(22, 8, 17, '/uploads/category/maquillage.png'),
(23, 9, 17, '/uploads/category/nail-service.png'),
(24, 10, 17, '/uploads/category/hairdressing-services.png'),
(25, 11, 17, '/uploads/category/massage.png'),
(26, 12, 17, '/uploads/category/depilation.png'),
(27, 13, 17, '/uploads/category/cilia.png');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_subscribe` tinyint(1) DEFAULT '0',
  `is_client` tinyint(1) DEFAULT '0',
  `is_master` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`, `is_subscribe`, `is_client`, `is_master`) VALUES
(1, 'huLCvz5VYayD7AHKpxvrBcwDCpaBDiU0', '$2y$13$uMlPO/C7w/IAx/he/u1GQOKEPQjgELpvube25JtI24XrU4Q.8kpZK', NULL, 'admin@mail.ru', 10, 1558534882, 1559817826, '', 1, 1, 1),
(4, 'IoUkVhEcWJrjJ8BiD5R6DuB9Eb82NcpY', '$2y$13$uGOTDyRwb/46KN6MO2eqG.pPb.x3.8vnEHS31Bqh0Ll3uurfNkLmG', NULL, 'test@mail.ru', 10, 1558689779, 1558690226, 'LoWzL0jmHQc1TO_5fO56zmfPolLwiVUM_1558689779', 1, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `house` varchar(255) DEFAULT NULL,
  `room` varchar(255) DEFAULT NULL,
  `housing` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_info`
--

INSERT INTO `user_info` (`id`, `user_id`, `name`, `description`, `city`, `phone`, `street`, `house`, `room`, `housing`) VALUES
(1, 1, NULL, NULL, NULL, NULL, 'Советская', '73а', '2', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `master_orders`
--
ALTER TABLE `master_orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `swp_field`
--
ALTER TABLE `swp_field`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `swp_group`
--
ALTER TABLE `swp_group`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `swp_material`
--
ALTER TABLE `swp_material`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `swp_material_field`
--
ALTER TABLE `swp_material_field`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- Индексы таблицы `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `master_orders`
--
ALTER TABLE `master_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `swp_field`
--
ALTER TABLE `swp_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT для таблицы `swp_group`
--
ALTER TABLE `swp_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `swp_material`
--
ALTER TABLE `swp_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `swp_material_field`
--
ALTER TABLE `swp_material_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
