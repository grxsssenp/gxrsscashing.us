-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 29 2018 г., 23:11
-- Версия сервера: 5.5.52-MariaDB-cll-lve
-- Версия PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vhost01008_tttt`
--

-- --------------------------------------------------------

--
-- Структура таблицы `demo_admin`
--

CREATE TABLE IF NOT EXISTS `demo_admin` (
  `id` int(11) NOT NULL,
  `win_youtuber` int(11) NOT NULL,
  `lose_youtuber` int(11) NOT NULL,
  `win_user` int(11) NOT NULL,
  `lose_user` int(11) NOT NULL,
  `pd` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_admin`
--

INSERT INTO `demo_admin` (`id`, `win_youtuber`, `lose_youtuber`, `win_user`, `lose_user`, `pd`) VALUES
(1, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `demo_config`
--

CREATE TABLE IF NOT EXISTS `demo_config` (
  `ID` int(11) NOT NULL,
  `site_name` text NOT NULL,
  `site_domain` text NOT NULL,
  `site_url` text NOT NULL,
  `site_footer` text NOT NULL,
  `site_info` text NOT NULL,
  `site_contacts` text NOT NULL,
  `bgc_site` text NOT NULL,
  `input_f` int(11) NOT NULL,
  `out_f` int(11) NOT NULL,
  `inputmax_f` int(11) NOT NULL,
  `outmax_f` int(11) NOT NULL,
  `bonus_reg` int(11) NOT NULL,
  `vk_group_id` int(11) NOT NULL,
  `vk_group_token` text NOT NULL,
  `vk_id` int(11) NOT NULL,
  `vk_secret` text NOT NULL,
  `fk_id` int(11) NOT NULL,
  `fk_secret` text NOT NULL,
  `fk_secret_2` text NOT NULL,
  `pr_id` int(11) NOT NULL,
  `pr_key` text NOT NULL,
  `pr_curr` text NOT NULL,
  `phone_qiwi` varchar(11) NOT NULL,
  `token_qiwi` text NOT NULL,
  `wallet` text NOT NULL,
  `preloader_active` int(11) NOT NULL,
  `qiwi_active` int(11) NOT NULL,
  `freekassa_active` int(11) NOT NULL,
  `payeer_active` int(11) NOT NULL,
  `minBetPercent` varchar(25) NOT NULL,
  `maxBetPercent` varchar(25) NOT NULL,
  `betSizeMin` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_config`
--

INSERT INTO `demo_config` (`ID`, `site_name`, `site_domain`, `site_url`, `site_footer`, `site_info`, `site_contacts`, `bgc_site`, `input_f`, `out_f`, `inputmax_f`, `outmax_f`, `bonus_reg`, `vk_group_id`, `vk_group_token`, `vk_id`, `vk_secret`, `fk_id`, `fk_secret`, `fk_secret_2`, `pr_id`, `pr_key`, `pr_curr`, `phone_qiwi`, `token_qiwi`, `wallet`, `preloader_active`, `qiwi_active`, `freekassa_active`, `payeer_active`, `minBetPercent`, `maxBetPercent`, `betSizeMin`) VALUES
(1, 'demo', 'demo', 'demo', '2018 © demo', '<li>Денежный бонус при регистрации</li>                                                                     <li>Быстрые и честные выплаты</li>                                                                     <li>Проверяйте на честность любую игру</li>                                                                     <li>Дополнительно зарабатывайте на рефералах</li> 																																	  <li>Поднимайте легкие деньги у нас</li>\n', '<h6>Для связи с администрацией пишите в <a href="https://vk.com/im?sel=-165406723" target="_blank">сообщество Вконтакте</a></h6>\n', 'tehnology.png', 0, 0, 0, 0, 0, 0, '', 0, '', 0, '', '', 0, '', 'RUB', '0', '', 'Wallet', 1, 1, 1, 1, '0', '0', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `demo_email`
--

CREATE TABLE IF NOT EXISTS `demo_email` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` text NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `demo_games`
--

CREATE TABLE IF NOT EXISTS `demo_games` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `login` text NOT NULL,
  `chislo` text NOT NULL,
  `cel` text NOT NULL,
  `suma` text NOT NULL,
  `shans` text NOT NULL,
  `win_summa` text NOT NULL,
  `type` text NOT NULL,
  `data` text NOT NULL,
  `hash` text NOT NULL,
  `salt1` text NOT NULL,
  `salt2` text NOT NULL,
  `saltall` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `demo_payments`
--

CREATE TABLE IF NOT EXISTS `demo_payments` (
  `id` int(11) NOT NULL,
  `user_id` text NOT NULL,
  `suma` text NOT NULL,
  `data` text NOT NULL,
  `qiwi` text NOT NULL,
  `transaction` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `demo_payout`
--

CREATE TABLE IF NOT EXISTS `demo_payout` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `suma` text NOT NULL,
  `qiwi` text NOT NULL,
  `status` text NOT NULL,
  `data` text NOT NULL,
  `ip` text NOT NULL,
  `system` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `demo_promo`
--

CREATE TABLE IF NOT EXISTS `demo_promo` (
  `id` int(11) NOT NULL,
  `promo` text NOT NULL,
  `active` text NOT NULL,
  `activelimit` text NOT NULL,
  `idactive` text NOT NULL,
  `data` text NOT NULL,
  `summa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `demo_users`
--

CREATE TABLE IF NOT EXISTS `demo_users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `hash` text NOT NULL,
  `admin` text NOT NULL,
  `ban` int(11) NOT NULL,
  `ban_mess` text NOT NULL,
  `ip_reg` text NOT NULL,
  `ip` text NOT NULL,
  `referer` text NOT NULL,
  `data_reg` text NOT NULL,
  `online` int(11) NOT NULL,
  `online_time` int(11) NOT NULL,
  `balance` text NOT NULL,
  `bonus` int(11) NOT NULL,
  `bonus_url` text NOT NULL,
  `vkname` text NOT NULL,
  `vkhash` text NOT NULL,
  `youtube` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `demo_win`
--

CREATE TABLE IF NOT EXISTS `demo_win` (
  `id` int(11) NOT NULL,
  `win` text NOT NULL,
  `lose` text NOT NULL,
  `pd` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `demo_win`
--

INSERT INTO `demo_win` (`id`, `win`, `lose`, `pd`) VALUES
(1, '0', '0', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `demo_admin`
--
ALTER TABLE `demo_admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_config`
--
ALTER TABLE `demo_config`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `demo_email`
--
ALTER TABLE `demo_email`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_games`
--
ALTER TABLE `demo_games`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_payments`
--
ALTER TABLE `demo_payments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_payout`
--
ALTER TABLE `demo_payout`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_promo`
--
ALTER TABLE `demo_promo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_users`
--
ALTER TABLE `demo_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `demo_win`
--
ALTER TABLE `demo_win`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `demo_admin`
--
ALTER TABLE `demo_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `demo_config`
--
ALTER TABLE `demo_config`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `demo_email`
--
ALTER TABLE `demo_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `demo_games`
--
ALTER TABLE `demo_games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `demo_payments`
--
ALTER TABLE `demo_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `demo_payout`
--
ALTER TABLE `demo_payout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `demo_promo`
--
ALTER TABLE `demo_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `demo_users`
--
ALTER TABLE `demo_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `demo_win`
--
ALTER TABLE `demo_win`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
