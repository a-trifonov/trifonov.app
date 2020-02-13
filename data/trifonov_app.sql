--
-- База данных: `trifonov_app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `loans`
--

CREATE TABLE `loans` (
  `loan_number` varchar(4) NOT NULL,
  `amount` double(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `payments`
--

CREATE TABLE `payments` (
  `payment_number` varchar(4) NOT NULL,
  `amount` double(10,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `payment_info` varchar(4) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `statuses`
--

CREATE TABLE `statuses` (
  `id` tinyint(1) NOT NULL,
  `title` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `statuses`
--

INSERT INTO `statuses` (`id`, `title`) VALUES
(1, 'active'),
(2, 'paid');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `loans`
--
ALTER TABLE `loans`
  ADD UNIQUE KEY `loan_number` (`loan_number`);

--
-- Индексы таблицы `payments`
--
ALTER TABLE `payments`
  ADD UNIQUE KEY `payment_number` (`payment_number`);

--
-- Индексы таблицы `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
