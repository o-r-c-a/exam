-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 14. Jan 2024 um 22:32
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `hotel`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `extras`
--

CREATE TABLE `extras` (
  `extras_id` int(2) NOT NULL,
  `description` varchar(32) NOT NULL,
  `price` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `extras`
--

INSERT INTO `extras` (`extras_id`, `description`, `price`) VALUES
(1, 'breakfast', 9.50),
(2, 'pets', 12.50),
(3, 'parking', 6.50);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE `news` (
  `news_id` int(32) NOT NULL,
  `text` varchar(4096) NOT NULL,
  `title` varchar(96) NOT NULL,
  `release_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `picPath` varchar(64) NOT NULL,
  `writer` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `news`
--

INSERT INTO `news` (`news_id`, `text`, `title`, `release_date`, `picPath`, `writer`) VALUES
(21, 'Willkommen zu einer exquisiten Reise durch das aufregende Nachtleben unseres Hotels, wo jede Nacht zu einem unvergesslichen Erlebnis wird. Tauchen Sie ein in die pulsierende Energie, die unsere einladende Trinkbar durchströmt, und lassen Sie sich von einer breiten Palette erfrischender Getränke verführen, die Ihren Abend zu etwas Besonderem machen.\r\nIn unseren stilvollen Räumlichkeiten erwartet Sie eine Atmosphäre der Eleganz und Gelas-senheit. Hier, inmitten eines gepflegten Ambientes, können Sie sich auf eine reichhaltige Auswahl exotischer Cocktails und erlesener Weine freuen, die von unseren erfahrenen Barkeepern mit Liebe zum Detail zubereitet werden. Ganz gleich, ob Sie einen klassischen Martini, einen erfrischenden Mojito oder einen vollmundigen Rotwein bevorzugen, unsere Getränkekarte ist darauf ausgerichtet, die unterschiedlichsten Geschmackspräferenzen zu bedienen.\r\nUnsere Bar ist nicht nur ein Ort, um Getränke zu genießen, sondern auch ein sozialer Treffpunkt, der dazu einlädt, Kontakte zu knüpfen und gemeinsam unvergessliche Mo-mente zu erleben. Die angenehme Beleuchtung und die sorgfältig ausgewählte Musik schaffen eine entspannte Umgebung, die sich ideal für unterhaltsame Gespräche und an-geregte Begegnungen eignet.\r\nUnsere engagierten Mitarbeiter stehen bereit, um sicherzustellen, dass Ihr Besuch in unse-rer Trinkbar unvergesslich wird. Mit einem herzlichen Lächeln und einer professionellen Einstellung stehen sie Ihnen bei der Auswahl Ihrer Getränke zur Seite, empfehlen Ihnen Spezialitäten und schaffen eine Atmosphäre, die von Gastfreundschaft und Wohlgefühl geprägt ist.\r\nAls Herzstück des Hotelnachtlebens bietet unsere Trinkbar den idealen Ort, um den Tag ausklingen zu lassen oder die Nacht zu beginnen. Ob Sie mit Freunden, Familie oder allei-ne unterwegs sind, hier finden Sie stets eine freundliche Gesellschaft und eine angenehme Umgebung, um Ihren Abend zu genießen.\r\nErleben Sie die Magie einer Nacht, die durch die Kombination aus vorzüglichen Getränken, ansprechendem Ambiente und herzlicher Gastfreundschaft entsteht. Wir laden Sie ein, Teil dieser unvergleichlichen Erfahrung zu werden und freuen uns darauf, Ihnen einen unver-gesslichen Aufenthalt zu bereiten. Lassen Sie sich von der Atmosphäre verzaubern, gön-nen Sie sich einen Moment der Entspannung und machen Sie Ihre Nächte bei uns zu un-vergesslichen Erlebnissen.\r\n', 'Bereit für eine lange Nacht?', '2024-01-14 20:01:07', 'uploads/news/bar.jpg', 23),
(25, 'Heiraten – ein bedeutungsvoller Schritt auf dem Weg zu einer gemeinsamen Zukunft. Im Hotel Tschempern verstehen wir, dass dieser Tag etwas ganz Besonderes sein muss, ein Moment voller Magie und Liebe. Daher bieten wir die perfekte Kulisse für Paare, die von einer märchenhaften Hochzeit träumen.\r\nUnsere Banketträume sind nicht nur Orte für Feiern, sondern Oasen der Romantik. Von zauberhaften Banketten bis hin zu idyllischen Hochzeitsgärten schaffen wir unvergessliche Erlebnisse, die Ihren Tag einzigartig machen. Bei uns steht die Liebe im Mittelpunkt, und wir setzen alles daran, Ihre Hochzeit zu einem unvergesslichen Moment in Ihrem Leben zu machen.\r\nDie Atmosphäre in unserem Hotel ist von einer eleganten Schlichtheit geprägt, die Eleganz und Wärme vereint. Wir verstehen, dass Ihre Hochzeit ein Spiegelbild Ihrer Persönlichkeit sein soll, und deshalb bieten wir flexible Veranstaltungsräume, die sich an Ihre individuel-len Wünsche anpassen lassen. Hier ist Platz für die unterschiedlichsten Visionen – von ei-ner intimen Feier im kleinen Kreis bis hin zu einer größeren Gesellschaft.\r\nUnsere engagierten Mitarbeiter legen großen Wert darauf, Ihnen den herzlichsten Service zu bieten. Vom ersten Gespräch bis zum Tag der Hochzeit stehen wir Ihnen zur Seite, um sicherzustellen, dass jedes Detail sorgfältig geplant ist. Wir verstehen, dass die kleinen Dinge den Unterschied machen, und daher setzen wir alles daran, Ihre Erwartungen zu übertreffen.\r\nIn unserem romantischen Ambiente können Sie den Beginn Ihrer Liebe feiern. Unsere Hochzeitsgärten bieten eine idyllische Kulisse für eine Zeremonie unter freiem Himmel, während unsere Banketträume eine stilvolle Umgebung für den festlichen Teil des Tages schaffen. Die Liebe liegt in den Details, und wir kümmern uns darum, dass diese Details perfekt sind.\r\nUnsere kulinarischen Köstlichkeiten tragen ebenfalls dazu bei, Ihre Hochzeit zu einem Fest der Sinne zu machen. Von exquisiten Menüs bis hin zu sorgfältig ausgewählten Getränken bieten wir eine gastronomische Erfahrung, die Ihre Gäste beeindrucken wird. Unsere Kü-chenchefs arbeiten mit Leidenschaft und Kreativität, um ein Menü zu kreieren, das Ihren individuellen Geschmack widerspiegelt.\r\nFeiern Sie Ihre Liebe in unserem Hotel Tschempern – dem perfekten Setting für Ihren per-fekten Tag. Wir bieten mehr als nur einen Ort für Hochzeiten; wir bieten ein Erlebnis, das Ihre Erwartungen übertrifft. Lassen Sie sich von unserer eleganten Atmosphäre und unse-rem herzlichen Service verzaubern. Wir freuen uns darauf, Teil Ihres unvergesslichen Mo-ments zu sein und Ihre Hochzeit zu einem strahlenden Kapitel in Ihrer Liebesgeschichte zu machen.\r\n\r\n', 'Hochzeitsfeiern auf Hotel Tschempern ', '2024-01-14 20:06:34', 'uploads/news/marriage.jpeg', 1),
(26, 'Frühstück, die wichtigste Mahlzeit des Tages, wird im Hotel Tschempern zu einem wahr-haftigen Genusserlebnis. Unser Hotel lädt Sie ein, den Tag in entspannter Atmosphäre zu beginnen, umgeben von kulinarischen Köstlichkeiten und herzlicher Gastfreundschaft. Entdecken Sie mit uns, warum das Frühstück im Hotel Tschempern weit mehr ist als nur eine Mahlzeit – es ist ein Start in den Tag, der den Ton für unvergessliche Erlebnisse setzt.\r\nDie Morgenstunden im Hotel Tschempern beginnen mit einer Überraschung für die Sinne. Unsere Frühstücksauswahl ist reichhaltig und abwechslungsreich, um jedem Gast eine ge-nussvolle Grundlage für den Tag zu bieten. Von frischen Früchten über knusprige Backwa-ren bis hin zu herzhaften Köstlichkeiten – wir verstehen, dass Vielfalt der Schlüssel zu ei-nem gelungenen Frühstück ist.\r\nUnser Frühstücksbereich strahlt eine einladende Atmosphäre aus. Elegantes Interieur, warme Farben und eine angenehme Beleuchtung schaffen den perfekten Rahmen, um in Ruhe den Tag zu beginnen. Wir legen Wert darauf, dass unser Frühstücksraum nicht nur ein Ort des Essens ist, sondern ein Ort des Wohlfühlens, an dem Sie sich Zeit für sich selbst nehmen können.\r\nDas freundliche und aufmerksame Personal im Hotel Tschempern setzt alles daran, Ihnen einen angenehmen Start in den Tag zu ermöglichen. Wir verstehen, dass der Morgen hek-tisch sein kann, und deshalb stehen wir bereit, um sicherzustellen, dass Sie sich um nichts kümmern müssen. Lassen Sie sich von uns mit einem Lächeln begrüßen und von unserem Service verwöhnen.\r\nEin besonderes Highlight unseres Frühstücksangebots ist die Möglichkeit, regionale Spezi-alitäten zu probieren. Wir legen Wert auf lokale Produkte und arbeiten mit passionierten Lieferanten zusammen, um Ihnen authentische Geschmackserlebnisse zu bieten. Genießen Sie frische Produkte aus der Umgebung und erleben Sie die Vielfalt regionaler kulinari-scher Köstlichkeiten.\r\nDas Frühstück im Hotel Tschempern ist nicht nur eine Mahlzeit, sondern ein genussvoller Start in den Tag, der den Ton für Ihre weiteren Erlebnisse setzt. Egal, ob Sie einen ereignis-reichen Tag voller Aktivitäten oder einen ruhigen Tag der Entspannung planen – ein aus-gewogenes Frühstück bei uns ist der perfekte Auftakt.\r\nTreten Sie ein in die Welt des Genusses und starten Sie Ihren Tag auf besondere Weise im Hotel Tschempern. Unser Frühstück ist weit mehr als nur Essen; es ist ein Erlebnis, das Ihre Sinne anspricht und Ihnen einen gelungenen Start in den Tag garantiert. Wir freuen uns darauf, Sie morgens mit einem Lächeln zu begrüßen und Ihnen einen unvergesslichen Frühstücksgenuss zu bieten.\r\n', 'Ein genussvoller Start in den Tag', '2024-01-14 20:06:58', 'uploads/news/breakfast.jpg', 23);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `person`
--

CREATE TABLE `person` (
  `pers_id` int(32) NOT NULL,
  `salutation` varchar(5) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `tel` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ur_id` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `person`
--

INSERT INTO `person` (`pers_id`, `salutation`, `firstname`, `lastname`, `tel`, `email`, `username`, `password`, `active`, `ur_id`) VALUES
(1, 'Herr', 'Adi', 'Minter', '+43123456789', 'admin@gmail.com', 'admin1', '$2y$10$gPI.7.KMsLGBn.IrsdyV4.Lk0pTxLM2Enlv0YydAVtORO7hOcMSo6', 1, 'a'),
(21, 'Herr', 'Max', 'Mustermann', '+434343434343', 'max1@gmx.at', 'maxi', '$2y$10$vudGHxfxnlZs845Sdd8/L.gKr5jC3VFQsB3oFtXNTvfctQSjaS.Y6', 1, 'u'),
(22, 'Frau', 'Susi', 'Sorglos', '+123123', 'susi1@gmx.at', 'susi', '$2y$10$XOavCxzAC6dgrwJpq.EiHeDg8pyNURWpq.ZbS0St2/dVAy5n0mUMu', 1, 'u'),
(23, 'Herr', 'Artikel', 'Schreiber', '+123123', 'artikel@gmail.com', 'arti', '$2y$10$lkTsshTx9JCTcOuj7EQfLeSFqLVE/fTMxCt5tvMy.xi6rOTaSvDWG', 1, 'a');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservation`
--

CREATE TABLE `reservation` (
  `res_id` int(32) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `breakfast` tinyint(1) NOT NULL,
  `parking` tinyint(1) NOT NULL,
  `pets` tinyint(1) NOT NULL,
  `other` varchar(255) DEFAULT NULL,
  `pers_id` int(32) NOT NULL,
  `room_nr` int(32) NOT NULL,
  `state_id` varchar(2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `reservation`
--

INSERT INTO `reservation` (`res_id`, `date_from`, `date_to`, `breakfast`, `parking`, `pets`, `other`, `pers_id`, `room_nr`, `state_id`, `price`, `timestamp`) VALUES
(49, '2024-01-07', '2024-01-14', 1, 1, 0, '', 1, 100, 'b', 742.00, '2024-01-14 22:07:23'),
(50, '2024-01-06', '2024-01-20', 1, 1, 0, '', 1, 101, 'b', 1484.00, '2024-01-14 22:07:42'),
(51, '2024-01-10', '2024-01-17', 0, 0, 1, 'Hund', 21, 102, 'n', 717.50, '2024-01-14 22:08:11'),
(52, '2024-01-05', '2024-01-12', 0, 1, 0, '', 21, 200, 's', 1235.50, '2024-01-14 22:08:28'),
(53, '2024-01-07', '2024-01-21', 1, 1, 1, 'Hamster', 22, 201, 's', 2779.00, '2024-01-14 22:08:57'),
(54, '2024-01-05', '2024-01-26', 1, 0, 0, '', 22, 202, 'n', 3769.50, '2024-01-14 22:09:13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reservation_state`
--

CREATE TABLE `reservation_state` (
  `state_id` varchar(2) NOT NULL,
  `description` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `reservation_state`
--

INSERT INTO `reservation_state` (`state_id`, `description`) VALUES
('b', 'bestätigt'),
('n', 'neu'),
('s', 'storniert');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `room`
--

CREATE TABLE `room` (
  `room_nr` int(32) NOT NULL,
  `type` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `room`
--

INSERT INTO `room` (`room_nr`, `type`) VALUES
(300, 'ds'),
(301, 'ds'),
(200, 'dz'),
(201, 'dz'),
(202, 'dz'),
(100, 'ez'),
(101, 'ez'),
(102, 'ez');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `room_type`
--

CREATE TABLE `room_type` (
  `rt_id` varchar(2) NOT NULL,
  `numPerson` int(2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(32) NOT NULL,
  `filePath` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `room_type`
--

INSERT INTO `room_type` (`rt_id`, `numPerson`, `price`, `description`, `filePath`) VALUES
('ds', 2, 250.00, 'Deluxe Suite', '/images/deluxe.jpg'),
('dz', 2, 170.00, 'Doppelzimmer', '/images/doppelzimmer.jpg'),
('ez', 1, 90.00, 'Einzelzimmer', '/images/einzelzimmer.jpg');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_roles`
--

CREATE TABLE `user_roles` (
  `ur_id` varchar(1) NOT NULL,
  `description` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `user_roles`
--

INSERT INTO `user_roles` (`ur_id`, `description`) VALUES
('a', 'Admin'),
('u', 'Benutzer');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `extras`
--
ALTER TABLE `extras`
  ADD PRIMARY KEY (`extras_id`);

--
-- Indizes für die Tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `fk_news_person` (`writer`);

--
-- Indizes für die Tabelle `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`pers_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_person_userroles` (`ur_id`);

--
-- Indizes für die Tabelle `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`res_id`),
  ADD KEY `fk_reservation_room` (`room_nr`),
  ADD KEY `fk_reservation_user` (`pers_id`),
  ADD KEY `fk_reservation_state` (`state_id`);

--
-- Indizes für die Tabelle `reservation_state`
--
ALTER TABLE `reservation_state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indizes für die Tabelle `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_nr`),
  ADD KEY `fk_room_roomtype` (`type`);

--
-- Indizes für die Tabelle `room_type`
--
ALTER TABLE `room_type`
  ADD PRIMARY KEY (`rt_id`);

--
-- Indizes für die Tabelle `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`ur_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `extras`
--
ALTER TABLE `extras`
  MODIFY `extras_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT für Tabelle `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT für Tabelle `person`
--
ALTER TABLE `person`
  MODIFY `pers_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `reservation`
--
ALTER TABLE `reservation`
  MODIFY `res_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `fk_news_person` FOREIGN KEY (`writer`) REFERENCES `person` (`pers_id`);

--
-- Constraints der Tabelle `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `fk_person_userroles` FOREIGN KEY (`ur_id`) REFERENCES `user_roles` (`ur_id`);

--
-- Constraints der Tabelle `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_reservationState` FOREIGN KEY (`room_nr`) REFERENCES `room` (`room_nr`),
  ADD CONSTRAINT `fk_reservation_state` FOREIGN KEY (`state_id`) REFERENCES `reservation_state` (`state_id`),
  ADD CONSTRAINT `fk_reservation_user` FOREIGN KEY (`pers_id`) REFERENCES `person` (`pers_id`);

--
-- Constraints der Tabelle `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `fk_room_roomtype` FOREIGN KEY (`type`) REFERENCES `room_type` (`rt_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
