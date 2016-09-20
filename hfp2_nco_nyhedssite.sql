-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Vært: 127.0.0.1
-- Genereringstid: 20. 09 2016 kl. 14:30:06
-- Serverversion: 5.6.16
-- PHP-version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hfp2_nco_nyhedssite`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `category_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Data dump for tabellen `categories`
--

INSERT INTO `categories` (`category_id`, `category_title`, `category_description`) VALUES
(1, 'Indland', 'Dette er indlands nyhederne'),
(2, 'Sport', 'Her kommer alle sports nyhederne'),
(3, 'Gaming TilbehÃ¸r', 'Gaming nyheder...'),
(4, 'Udland', 'Nyheder fra det store udland'),
(12, 'Kultur', 'Det er smart med alt den kultur...');

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `category_editors`
--

CREATE TABLE IF NOT EXISTS `category_editors` (
  `fk_users_id` int(11) NOT NULL,
  `fk_categories_id` int(11) NOT NULL,
  KEY `fk_users_id` (`fk_users_id`),
  KEY `fk_categories_id` (`fk_categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Data dump for tabellen `category_editors`
--

INSERT INTO `category_editors` (`fk_users_id`, `fk_categories_id`) VALUES
(1, 1),
(9, 3),
(10, 3),
(9, 4),
(1, 4),
(12, 12),
(10, 12),
(12, 2),
(10, 2),
(1, 2),
(12, 1);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `news_content` text COLLATE utf8_unicode_ci NOT NULL,
  `news_postdate` datetime NOT NULL,
  `fk_users_id` int(11) NOT NULL,
  `fk_categories_id` int(11) NOT NULL,
  PRIMARY KEY (`news_id`),
  KEY `fk_users_id` (`fk_users_id`),
  KEY `fk_categories_id` (`fk_categories_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=40 ;

--
-- Data dump for tabellen `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_content`, `news_postdate`, `fk_users_id`, `fk_categories_id`) VALUES
(1, 'Vivamus posuere mattis sagittis. ', 'Sed viverra dolor nec pellentesque volutpat. Praesent vehicula magna et ligula varius consectetur. In sed turpis sed nunc rutrum bibendum. In dapibus aliquet arcu sed tincidunt. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut eget facilisis ipsum. Nullam sodales nisi urna, in condimentum quam ornare at. Mauris eleifend facilisis risus eu dignissim. Quisque viverra ante non pellentesque sollicitudin. Sed sit amet lectus ac lectus molestie consequat. Aliquam euismod arcu nec sem tempor consequat. Mauris rhoncus aliquam imperdiet.', '2013-01-02 06:25:39', 2, 1),
(2, 'Pellentesque euismod', 'Sed tristique pulvinar lacus, ac lacinia tortor mollis vel. Pellentesque euismod, diam sit amet dapibus euismod, nunc lectus feugiat tellus, nec eleifend augue arcu eget justo. Vivamus lacus ligula, mollis vitae accumsan at, fermentum eu diam. Aliquam et libero enim. Integer sollicitudin non nibh et convallis. Donec tincidunt cursus mi faucibus placerat. Mauris ultricies posuere fringilla. In hac habitasse platea dictumst.', '2013-01-08 12:10:22', 2, 2),
(3, 'Aliquam scelerisque', 'Pellentesque eu nulla gravida, lobortis velit ac, rhoncus sapien. Sed vel ligula sem. Morbi sed est et risus gravida ullamcorper. Aliquam scelerisque magna nulla, vitae sodales libero interdum eget. Maecenas sed magna euismod, fringilla risus et, fringilla orci. Integer vel odio augue. Curabitur pretium sapien et egestas elementum. Vivamus tincidunt justo luctus, malesuada odio semper, ultricies lorem. Fusce volutpat dapibus ultrices.', '2013-01-23 13:48:17', 10, 4),
(4, 'Aenean tincidunt gravida orci', 'Duis mattis eget nulla nec tincidunt. In hac habitasse platea dictumst. Aenean tincidunt gravida orci, vitae ultricies ante molestie at. Duis varius eleifend mollis. Aliquam a lacinia tortor. Sed ut tellus a lacus tempus aliquet sit amet id tortor. Vestibulum quis molestie ante, sit amet rhoncus erat. Cras velit nulla, condimentum sed volutpat eget, hendrerit non enim. Mauris nec pulvinar purus. Nam vitae tincidunt leo. Maecenas non arcu a velit suscipit porta.', '2013-01-31 02:14:22', 2, 1),
(5, 'Vestibulum commodo', 'Nunc sed lectus et eros consequat ullamcorper. Fusce at risus tempor magna sodales iaculis. Aliquam hendrerit sapien lectus, at rutrum lectus hendrerit ac. Nam vitae magna quis eros porta tristique. Vestibulum commodo, sapien vel pulvinar pellentesque, mi lorem pulvinar arcu, sed dictum ligula ipsum ac diam. Nam quis euismod nibh. Duis justo lacus, faucibus eget pellentesque sed, dignissim sed ligula. Nunc eleifend cursus dui, vitae mollis metus fringilla sed. Nunc vitae orci non dui ornare convallis. Phasellus iaculis id ligula non pretium. Morbi quis sagittis urna, id sodales mi. Suspendisse sed metus non nisi volutpat iaculis vitae a neque. Donec lacinia porta interdum. Fusce sodales elit eu rhoncus fringilla. In venenatis massa id sem sagittis, nec molestie neque lobortis.', '2013-02-02 20:08:37', 2, 1),
(6, 'Maecenas interdum', 'Vestibulum congue neque sed felis iaculis tincidunt malesuada non felis. Morbi interdum adipiscing iaculis. Phasellus eu felis et justo viverra dapibus. Maecenas interdum, massa eu malesuada fringilla, erat elit consequat diam, bibendum rhoncus arcu sapien sed dolor. Cras consequat enim sed enim tempor consectetur. In nibh sapien, volutpat ornare congue volutpat, posuere quis risus. Donec quis felis euismod massa aliquet tempus in vel turpis. Aliquam eu magna dolor. Duis at nunc sapien. Aliquam commodo ipsum eu dui cursus, eget sollicitudin quam lacinia. Sed sit amet ligula dui.', '2013-02-11 09:18:57', 1, 3),
(7, 'Nunc faucibus ipsum', 'Nunc faucibus ipsum faucibus eleifend auctor. Nullam et sem molestie, suscipit nunc luctus, vulputate magna. Maecenas id nisi nisi. Nulla mollis, orci eu pulvinar eleifend, diam urna lobortis lectus, sed dictum risus nulla non enim. Mauris in porta tellus. Suspendisse faucibus dapibus metus nec ultrices. Praesent orci ante, vulputate ut tristique vel, blandit vitae leo. Curabitur vestibulum ac libero vitae vestibulum. Nam nec mi arcu. Nam justo mi, blandit quis arcu ac, auctor aliquam orci. Suspendisse placerat laoreet massa nec fringilla. Nam laoreet tortor eu rhoncus sollicitudin. Cras nec urna turpis.', '2013-02-21 18:22:38', 9, 3),
(8, 'Donec quam tortor', 'Suspendisse fermentum dui nec posuere dictum. Donec posuere faucibus placerat. Ut a fermentum lorem, sit amet laoreet metus. Aliquam rutrum urna vitae velit porttitor sodales. Donec quam tortor, mattis ut tortor eu, posuere malesuada erat. Donec in tortor sit amet lacus tempor venenatis. Donec sit amet tortor vitae magna gravida dictum. Sed vitae facilisis nisi, nec egestas ligula. Donec volutpat porta cursus. Nullam porta dignissim cursus. Etiam vel magna elit.', '2013-03-02 10:15:22', 10, 4),
(9, 'Nulla mattis lorem sit amet', 'Fusce ac tempus nisi. Maecenas viverra iaculis est ut gravida. In bibendum pulvinar nunc at pretium. Nulla mattis lorem sit amet leo imperdiet consectetur. Duis et varius magna. Aenean enim diam, feugiat laoreet justo ac, hendrerit lacinia nulla. Sed vestibulum ornare consectetur. Sed vitae nibh eu leo porta malesuada in non neque. Nam augue velit, commodo quis urna nec, vestibulum pharetra erat. Vestibulum ac scelerisque arcu, sed ornare sapien. Ut sed erat felis. Fusce ipsum magna, scelerisque iaculis mattis eu, luctus at est. Etiam quam enim, consequat accumsan metus ut, lacinia vulputate ante. Nullam purus leo, semper vitae libero vitae, viverra consectetur lorem. Integer iaculis ac felis eget imperdiet. Etiam tincidunt aliquam quam, vel tristique lectus.', '2013-03-12 07:15:40', 9, 1),
(10, 'Donec bibendum vitae nunc eu dictum', 'Morbi sit amet porttitor diam. Donec bibendum vitae nunc eu dictum. In vel elit orci. Donec placerat interdum leo vitae porttitor. Nam eu arcu libero. Proin purus massa, imperdiet ac velit quis, pretium cursus diam. Nullam mi nulla, pulvinar eget felis ac, cursus convallis dolor. Phasellus varius fermentum aliquam. Suspendisse sodales ultrices feugiat. Vestibulum eu risus blandit dolor dictum consectetur in in magna. Proin nec dictum erat.', '2013-03-26 15:41:04', 1, 1),
(11, 'Fusce non', 'Maecenas vel erat tristique, suscipit velit quis, malesuada odio. Suspendisse varius fermentum nisi nec tempor. Phasellus nec volutpat dui. Quisque leo tellus, rhoncus eu molestie non, ullamcorper in nulla. Fusce non vestibulum odio, sed pulvinar risus. Vestibulum lacinia at quam in ullamcorper. Quisque eget sem a velit dapibus sodales.', '2013-04-02 12:35:56', 11, 3),
(12, 'Proin quis ligula varius', 'Proin in fringilla nunc. Proin quis ligula varius, pharetra quam in, elementum turpis. In hac habitasse platea dictumst. Pellentesque feugiat faucibus orci, eu pulvinar elit dapibus sed. Curabitur et iaculis diam. Sed porta vulputate congue. Fusce et orci lobortis, vulputate velit ut, lacinia est. Cras eget ante tristique, fermentum nulla quis, rhoncus ligula. Quisque imperdiet porta mollis. Morbi quis fringilla nisi. Cras venenatis diam eu augue vestibulum feugiat. Duis pellentesque sed augue sit amet pellentesque. Fusce eget enim nec justo ultricies ultrices facilisis vel diam. Donec at porta nisi. Quisque ut nisl lectus.', '2013-04-11 14:06:39', 2, 3),
(13, 'Nam et semper turpi', 'Fusce luctus ac augue a hendrerit. Nam et semper turpis. Donec vehicula magna dui. Donec sit amet nibh a purus bibendum feugiat. Maecenas condimentum velit ut eros ultrices consequat. Curabitur aliquet convallis mi quis imperdiet. Integer sodales ut felis et sagittis. Vivamus convallis felis nunc, ut vestibulum mi pulvinar eget. Proin condimentum quam ac felis fringilla volutpat. Suspendisse elementum purus ac tempor mollis. Nam vulputate et mauris ut laoreet. Vivamus ornare risus sem, in hendrerit velit volutpat et. In elementum est iaculis scelerisque mattis. Vivamus pharetra, eros in imperdiet venenatis, eros ipsum pellentesque mauris, eu cursus turpis augue vel erat.', '2013-04-20 19:59:30', 12, 1),
(14, 'Quisque at orci sed', 'Quisque at orci sed nulla congue elementum. Maecenas pharetra arcu a elementum malesuada. Sed vehicula est ut neque eleifend, pulvinar laoreet nisi vestibulum. Vivamus interdum ipsum tellus, et convallis sem rutrum eu. Nulla id leo vitae est posuere pharetra et nec nunc. Proin sagittis nec nulla in volutpat. Ut facilisis mi vel leo mattis, a porta sem interdum. Nulla malesuada ornare massa. Proin sapien mauris, lacinia ut porta nec, dignissim eget tortor. In et ornare ligula.', '2013-04-29 14:23:41', 10, 2),
(15, 'Aenean ornare ligula porttitor ante sagittis', 'Fusce elementum diam consectetur nulla dictum, non consequat nibh eleifend. Aenean ornare ligula porttitor ante sagittis, sed adipiscing dolor pulvinar. Duis turpis neque, adipiscing vel elit et, pellentesque consectetur elit. Quisque pellentesque scelerisque mi, sed dignissim dolor dictum ac. Sed a risus placerat, semper mi blandit, accumsan nulla. Duis non egestas turpis, ac convallis mauris. Etiam non est at nisl tincidunt accumsan. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Integer euismod purus non risus sollicitudin, ut feugiat arcu tempus.', '2013-05-07 11:53:46', 2, 4),
(16, 'Duis faucibus quam', 'Vestibulum vestibulum orci dui, non pulvinar neque imperdiet quis. Duis faucibus quam metus. Integer libero sem, ultrices nec molestie eu, eleifend et quam. Nulla aliquet ligula turpis, vitae rhoncus ligula scelerisque quis. Morbi eget adipiscing tortor. Donec nec lorem non lorem consectetur commodo non et metus. Pellentesque commodo arcu ut est mollis auctor.', '2013-05-14 03:23:52', 12, 2),
(17, ' Phasellus tincidunt metus', 'Pellentesque ornare sem non convallis sagittis. Duis auctor eget augue ac vulputate. Phasellus tincidunt metus quis elit molestie, et varius enim varius. In ut commodo nisl. Praesent semper mi sed consectetur sagittis. Pellentesque vehicula quis erat quis sollicitudin. Ut luctus libero sed sodales blandit. Suspendisse id interdum sem, id sagittis nunc. Suspendisse porttitor aliquet justo, sollicitudin ultricies enim dapibus sed. Morbi ut lorem interdum, tempus eros eu, congue dolor. Nulla et euismod lacus. Vestibulum a mollis ante. Etiam accumsan tempor nibh nec tincidunt.', '2013-05-25 14:23:57', 9, 2),
(18, 'Integer sagittis', 'Integer sagittis, erat at faucibus placerat, massa nunc euismod ante, nec vehicula elit nisi sed diam. Morbi quis erat arcu. Nunc aliquet mi a blandit tincidunt. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas vehicula consequat metus et scelerisque. Vivamus congue, ligula venenatis laoreet bibendum, magna tellus cursus enim, nec eleifend dolor risus in mi. Aliquam mattis enim eget tellus pretium feugiat. Maecenas dapibus nulla nec urna commodo tristique. Praesent semper consectetur sapien eu scelerisque. Nam auctor dictum dolor eget ultricies.', '2013-06-04 04:11:44', 11, 2),
(19, 'Vestibulum dapibus sapien', 'Vivamus cursus erat in eleifend commodo. Vestibulum dapibus sapien in ante venenatis, quis mattis enim lobortis. Sed pellentesque massa quis sagittis convallis. Cras ullamcorper rutrum lectus, et dapibus turpis porttitor non. Duis consequat non urna vitae auctor. Cras scelerisque ante sapien. Donec bibendum diam tellus, a sagittis turpis pellentesque nec. Curabitur dictum rutrum odio nec pharetra. Curabitur a interdum mauris. Pellentesque dignissim nisi lacus, vitae aliquet velit tincidunt in.', '2013-06-12 22:52:01', 1, 3),
(20, 'Aenean aliquam tincidunt', 'Etiam egestas risus eleifend sodales iaculis. Aenean sollicitudin nunc eget urna molestie euismod. Aenean aliquam tincidunt tempor. Vivamus imperdiet feugiat nisi, a posuere eros viverra eget. Ut sodales, velit lacinia varius cursus, arcu enim ullamcorper est, nec ultrices orci dolor at neque. Nullam tempus ullamcorper eleifend. Suspendisse tincidunt vestibulum urna, adipiscing commodo arcu auctor at. Cras euismod rhoncus lorem ac euismod.', '2013-06-22 08:35:45', 2, 2),
(21, 'Proin varius nisl eu', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin varius nisl eu elementum egestas. Praesent tempor justo non elit volutpat, et varius metus vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec et ante egestas, commodo lectus a, dictum nisl. Aliquam luctus hendrerit purus, luctus pretium tortor tincidunt id. Donec nibh libero, pellentesque id eleifend sit amet, sagittis vitae mi. Ut elementum consequat urna, in dictum libero varius vel. Nunc odio velit, laoreet in diam a, vestibulum venenatis arcu. Proin iaculis interdum lacus, at vestibulum lacus viverra a. Etiam faucibus elementum lacinia.', '2013-07-03 07:25:58', 2, 3),
(22, 'Nam elit dui', 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam elit dui, laoreet quis blandit id, interdum nec diam. Aliquam commodo vehicula ultrices. Quisque ac turpis erat. Nullam iaculis, elit elementum ornare hendrerit, ipsum risus lobortis dui, ut pharetra ipsum lacus a libero. Quisque vehicula lectus lorem, at consectetur neque semper nec. Maecenas aliquet adipiscing velit eu ullamcorper. Fusce facilisis risus ac turpis dictum, vel aliquam risus porttitor. Pellentesque libero arcu, posuere quis condimentum ac, blandit vel tortor. Nulla facilisi. Nullam tincidunt neque magna, at malesuada erat rhoncus at.', '2013-07-16 10:50:15', 10, 2),
(23, 'Suspendisse nibh diam', 'Ut eget tortor vitae ante aliquet imperdiet. Sed sit amet felis sed justo posuere tincidunt. Suspendisse nibh diam, cursus vitae leo ut, porttitor feugiat lorem. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam vitae nisi urna. Sed blandit consequat viverra. Sed vel pharetra diam.', '2013-07-23 08:42:48', 12, 4),
(24, 'Praesent vitae elit', 'Mauris scelerisque leo pretium dolor gravida porttitor. Praesent vitae elit massa. Vestibulum tristique, magna ut ultrices aliquam, quam velit dignissim turpis, eu elementum tellus augue quis nunc. Nulla facilisi. Nam aliquet at purus a commodo. Praesent tristique, nunc vitae malesuada dapibus, lorem dolor fringilla elit, ut facilisis ligula ipsum nec enim. Pellentesque blandit faucibus libero vel mollis. Fusce aliquet tristique sem vitae consequat. Sed eget dignissim tellus, sit amet eleifend nisl. Ut eleifend ut augue et ullamcorper. Nulla ipsum justo, cursus quis interdum vel, viverra in turpis. Praesent at interdum tortor. Etiam et rutrum elit. Praesent ac leo vel nisi scelerisque dictum. Suspendisse auctor pellentesque pulvinar.', '2013-08-02 15:15:36', 11, 4),
(25, 'Fusce laoreet egestas', 'Curabitur a libero lorem. Vivamus id tempus sem. Sed eu nulla turpis. Etiam et commodo mi, nec interdum ipsum. Quisque vulputate, lectus quis feugiat vulputate, metus mi venenatis metus, vel semper mauris lorem vitae leo. Fusce laoreet egestas iaculis. Vestibulum ac vehicula ante, et commodo nunc. Nunc porta convallis velit, quis suscipit ante. Phasellus non mi vitae nulla ornare consectetur sed et risus. Integer elementum sed metus ac sodales. Aenean semper, lectus vitae elementum commodo, metus massa sagittis metus, at adipiscing diam erat non nunc. Nulla placerat nibh id eros feugiat feugiat. Phasellus turpis justo, rutrum porttitor diam at, interdum laoreet augue.', '2013-08-11 13:35:25', 10, 4),
(26, 'Suspendisse mattis', 'Nam interdum, est accumsan condimentum rhoncus, nisi metus viverra ligula, eget eleifend dolor urna feugiat eros. Suspendisse mattis placerat viverra. Quisque varius lectus eu blandit tempus. Nulla rhoncus placerat purus, a tristique sem tempor quis. Nulla vitae volutpat nunc. Aliquam hendrerit ultricies velit. Ut condimentum lectus nisl, vitae cursus leo lobortis a. Nulla aliquet eros ut felis rhoncus, vitae laoreet urna pulvinar. Vivamus posuere mattis sagittis.', '2013-08-23 21:07:54', 1, 3),
(28, 'Integer pharetra posuere', 'Curabitur cursus bibendum semper. Sed molestie lectus eleifend libero commodo suscipit. Vivamus erat ligula, malesuada mollis massa a, volutpat posuere mauris. Nulla sollicitudin sed neque a convallis. Sed at augue gravida, condimentum massa eget, dapibus enim. Suspendisse sit amet lacinia felis. Integer pharetra posuere quam, eget imperdiet magna. In accumsan gravida velit, eget molestie purus rhoncus sed.', '2013-08-30 15:07:01', 2, 3),
(29, 'Fusce non', 'Maecenas vel erat tristique, suscipit velit quis, malesuada odio. Suspendisse varius fermentum nisi nec tempor. Phasellus nec volutpat dui. Quisque leo tellus, rhoncus eu molestie non, ullamcorper in nulla. Fusce non vestibulum odio, sed pulvinar risus. Vestibulum lacinia at quam in ullamcorper. Quisque eget sem a velit dapibus sodales.', '2013-09-02 07:15:48', 2, 3),
(30, 'Maecenas interdum', 'Vestibulum congue neque sed felis iaculis tincidunt malesuada non felis. Morbi interdum adipiscing iaculis. Phasellus eu felis et justo viverra dapibus. Maecenas interdum, massa eu malesuada fringilla, erat elit consequat diam, bibendum rhoncus arcu sapien sed dolor. Cras consequat enim sed enim tempor consectetur. In nibh sapien, volutpat ornare congue volutpat, posuere quis risus. Donec quis felis euismod massa aliquet tempus in vel turpis. Aliquam eu magna dolor. Duis at nunc sapien. Aliquam commodo ipsum eu dui cursus, eget sollicitudin quam lacinia. Sed sit amet ligula dui.', '2013-09-13 21:30:09', 2, 3),
(31, 'Proin varius nisl eu', 'Praesent tempor justo non elit volutpat, et varius metus vestibulum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Donec et ante egestas, commodo lectus a, dictum nisl. Aliquam luctus hendrerit purus, luctus pretium tortor tincidunt id. Donec nibh libero, pellentesque id eleifend sit amet, sagittis vitae mi. Ut elementum consequat urna, in dictum libero varius vel. Nunc odio velit, laoreet in diam a, vestibulum venenatis arcu. Proin iaculis interdum lacus, at vestibulum lacus viverra a. Etiam faucibus elementum lacinia.', '2013-09-17 14:30:26', 2, 3),
(32, 'Maecenas interdum', 'Morbi interdum adipiscing iaculis. Phasellus eu felis et justo viverra dapibus. Maecenas interdum, massa eu malesuada fringilla, erat elit consequat diam, bibendum rhoncus arcu sapien sed dolor. Cras consequat enim sed enim tempor consectetur. In nibh sapien, volutpat ornare congue volutpat, posuere quis risus. Donec quis felis euismod massa aliquet tempus in vel turpis. Aliquam eu magna dolor. Duis at nunc sapien. Aliquam commodo ipsum eu dui cursus, eget sollicitudin quam lacinia. Sed sit amet ligula dui.', '2013-09-17 14:30:51', 2, 3),
(35, 'Etiam et commodo mi', 'Pellentesque eu nulla gravida, lobortis velit ac, rhoncus sapien. Sed vel ligula sem. Morbi sed est et risus gravida ullamcorper. Aliquam scelerisque magna nulla, vitae sodales libero interdum eget. Maecenas sed magna euismod, fringilla risus et, fringilla orci. Integer vel odio augue. Curabitur pretium sapien et egestas elementum. Vivamus tincidunt justo luctus, malesuada odio semper, ultricies lorem. Fusce volutpat dapibus ultrices.', '2013-09-20 12:11:03', 2, 4),
(37, 'gtfdasvfca', '<p>acsasdasfas</p>\r\n', '2016-09-20 13:45:13', 10, 3),
(38, 'dsfsd fds fsd f', '<p>&nbsp;fdsfds fds fds fsd</p>\r\n', '2016-09-20 13:45:18', 10, 3),
(39, ' fdsf sd fsd fsd ', '<p>f sdfsd fds fd sfds</p>\r\n', '2016-09-20 13:45:25', 10, 3);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `role_access` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Data dump for tabellen `roles`
--

INSERT INTO `roles` (`role_id`, `role_title`, `role_access`) VALUES
(1, 'Bruger', 1),
(2, 'Administrator', 100),
(3, 'Redakt&oslash;r', 10);

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fk_roles_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `fk_roles_id` (`fk_roles_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Data dump for tabellen `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `fk_roles_id`) VALUES
(1, 'Albert Andersen', '$2y$10$qMSz73Yun3mN.EeGz7pP8uWkA2emNODBLfbZABZErDGyhCy/mGrS6', 'aa@cmk-dynamisk-web.dk', 3),
(2, 'Benny Boss', '$2y$10$V7myeBPayIbZiNzim9j/be2JQggZez.hRxGudu5RbS4/ixsPDEIv.', 'bb@cmk-dynamisk-web.dk', 2),
(9, 'Carl Carstensen', '$2y$10$EWcni5jUmkqohlNXUidvFuHPNYSPY1ChfVYJwiN3/QJkpu9jcyLMS', 'cc@cmk-dynamisk-web.dk', 3),
(10, 'Dan Donaldson', '$2y$10$aK1qDZGvAC9LfEc8i5Vsf.SJKh9WRH05g6lkNM/oFTv3BV7Jq4OVq', 'dd@cmk-dynamisk-web.dk', 3),
(11, 'Egon Erikson', '$2y$10$GbaYnl5BbzjfyNcAlEmJmuVKAKar0nqrBK1FApjmymgMsyyy1kSqW', 'ee@cmk-dynamisk-web.dk', 2),
(12, 'Finn Fransen', '$2y$10$QpzFds.TXgUxET8v7BpTj.xSYWfDjSTcSXTemUVIrIWInYSp4.8t.', 'ff@cmk-dynamisk-web.dk', 3),
(13, 'Jens Jensen', '$2y$10$xKt7bIELfTGmtv9FcB.Fn.Jw4PrKpqwGN0m0MuWpr1AUso8ivc8u2', 'jj@cmk-dynamisk-web.dk', 1),
(15, 'Gert Gantt', '$2y$10$TM5awajp.jUg.989hS.YjOH84wVa8798kD8fqAcn1YsWfLEas1jQ.', 'gg@cmk-dynamisk-web.dk', 1);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `category_editors`
--
ALTER TABLE `category_editors`
  ADD CONSTRAINT `category_editors_ibfk_1` FOREIGN KEY (`fk_users_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_editors_ibfk_2` FOREIGN KEY (`fk_categories_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Begrænsninger for tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`fk_users_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`fk_categories_id`) REFERENCES `categories` (`category_id`);

--
-- Begrænsninger for tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`fk_roles_id`) REFERENCES `roles` (`role_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
