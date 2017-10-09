-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2017 a las 18:22:23
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vecino_foro`
--
CREATE DATABASE IF NOT EXISTS `vecino_foro` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `vecino_foro`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_activity`
--

CREATE TABLE `gdn_activity` (
  `ActivityID` int(11) NOT NULL,
  `ActivityTypeID` int(11) NOT NULL,
  `NotifyUserID` int(11) NOT NULL DEFAULT '0',
  `ActivityUserID` int(11) DEFAULT NULL,
  `RegardingUserID` int(11) DEFAULT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HeadlineFormat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Story` text COLLATE utf8_unicode_ci,
  `Format` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Route` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RecordType` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RecordID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `Notified` tinyint(4) NOT NULL DEFAULT '0',
  `Emailed` tinyint(4) NOT NULL DEFAULT '0',
  `Data` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_activity`
--

INSERT INTO `gdn_activity` (`ActivityID`, `ActivityTypeID`, `NotifyUserID`, `ActivityUserID`, `RegardingUserID`, `Photo`, `HeadlineFormat`, `Story`, `Format`, `Route`, `RecordType`, `RecordID`, `InsertUserID`, `DateInserted`, `InsertIPAddress`, `DateUpdated`, `Notified`, `Emailed`, `Data`) VALUES
(1, 17, -1, 3, NULL, NULL, '{ActivityUserID,You} ingresado.', '¡Bienvenido a bordo!', NULL, NULL, NULL, NULL, NULL, '2017-10-08 22:51:10', '127.0.0.1', '2017-10-08 23:02:40', 0, 0, 'a:1:{s:15:\"ActivityUserIDs\";a:1:{i:0;i:2;}}'),
(2, 15, -1, 2, 1, NULL, '{RegardingUserID,you} &rarr; {ActivityUserID,you}', 'Ping! An activity post is a public way to talk at someone. When you update your status here, it posts it on your activity feed.', 'Html', NULL, NULL, NULL, 1, '2017-10-08 22:51:19', NULL, '2017-10-08 22:51:19', 0, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_activitycomment`
--

CREATE TABLE `gdn_activitycomment` (
  `ActivityCommentID` int(11) NOT NULL,
  `ActivityID` int(11) NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_activitytype`
--

CREATE TABLE `gdn_activitytype` (
  `ActivityTypeID` int(11) NOT NULL,
  `Name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `AllowComments` tinyint(4) NOT NULL DEFAULT '0',
  `ShowIcon` tinyint(4) NOT NULL DEFAULT '0',
  `ProfileHeadline` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FullHeadline` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RouteCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Notify` tinyint(4) NOT NULL DEFAULT '0',
  `Public` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_activitytype`
--

INSERT INTO `gdn_activitytype` (`ActivityTypeID`, `Name`, `AllowComments`, `ShowIcon`, `ProfileHeadline`, `FullHeadline`, `RouteCode`, `Notify`, `Public`) VALUES
(1, 'SignIn', 0, 0, '%1$s signed in.', '%1$s signed in.', NULL, 0, 1),
(2, 'Join', 1, 0, '%1$s joined.', '%1$s joined.', NULL, 0, 1),
(3, 'JoinInvite', 1, 0, '%1$s accepted %4$s invitation for membership.', '%1$s accepted %4$s invitation for membership.', NULL, 0, 1),
(4, 'JoinApproved', 1, 0, '%1$s approved %4$s membership application.', '%1$s approved %4$s membership application.', NULL, 0, 1),
(5, 'JoinCreated', 1, 0, '%1$s created an account for %3$s.', '%1$s created an account for %3$s.', NULL, 0, 1),
(6, 'AboutUpdate', 1, 0, '%1$s updated %6$s profile.', '%1$s updated %6$s profile.', NULL, 0, 1),
(7, 'WallComment', 1, 1, '%1$s wrote:', '%1$s wrote on %4$s %5$s.', NULL, 0, 1),
(8, 'PictureChange', 1, 0, '%1$s changed %6$s profile picture.', '%1$s changed %6$s profile picture.', NULL, 0, 1),
(9, 'RoleChange', 1, 0, '%1$s changed %4$s permissions.', '%1$s changed %4$s permissions.', NULL, 1, 1),
(10, 'ActivityComment', 0, 1, '%1$s', '%1$s commented on %4$s %8$s.', 'activity', 1, 1),
(11, 'Import', 0, 0, '%1$s imported data.', '%1$s imported data.', NULL, 1, 0),
(12, 'Banned', 0, 0, '%1$s banned %3$s.', '%1$s banned %3$s.', NULL, 0, 1),
(13, 'Unbanned', 0, 0, '%1$s un-banned %3$s.', '%1$s un-banned %3$s.', NULL, 0, 1),
(14, 'Applicant', 0, 0, '%1$s applied for membership.', '%1$s applied for membership.', NULL, 1, 0),
(15, 'WallPost', 1, 1, '%3$s wrote:', '%3$s wrote on %2$s %5$s.', NULL, 0, 1),
(16, 'Default', 0, 0, NULL, NULL, NULL, 0, 1),
(17, 'Registration', 0, 0, NULL, NULL, NULL, 0, 1),
(18, 'Status', 0, 0, NULL, NULL, NULL, 0, 1),
(19, 'Ban', 0, 0, NULL, NULL, NULL, 0, 1),
(20, 'ConversationMessage', 0, 0, '%1$s sent you a %8$s.', '%1$s sent you a %8$s.', 'message', 1, 0),
(21, 'AddedToConversation', 0, 0, '%1$s added %3$s to a %8$s.', '%1$s added %3$s to a %8$s.', 'conversation', 1, 0),
(22, 'NewDiscussion', 0, 0, '%1$s started a %8$s.', '%1$s started a %8$s.', 'discussion', 0, 0),
(23, 'NewComment', 0, 0, '%1$s commented on a discussion.', '%1$s commented on a discussion.', 'discussion', 0, 0),
(24, 'DiscussionComment', 0, 0, '%1$s commented on %4$s %8$s.', '%1$s commented on %4$s %8$s.', 'discussion', 1, 0),
(25, 'DiscussionMention', 0, 0, '%1$s mentioned %3$s in a %8$s.', '%1$s mentioned %3$s in a %8$s.', 'discussion', 1, 0),
(26, 'CommentMention', 0, 0, '%1$s mentioned %3$s in a %8$s.', '%1$s mentioned %3$s in a %8$s.', 'comment', 1, 0),
(27, 'BookmarkComment', 0, 0, '%1$s commented on your %8$s.', '%1$s commented on your %8$s.', 'bookmarked discussion', 1, 0),
(28, 'Discussion', 0, 0, NULL, NULL, NULL, 0, 1),
(29, 'Comment', 0, 0, NULL, NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_analyticslocal`
--

CREATE TABLE `gdn_analyticslocal` (
  `TimeSlot` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `Views` int(11) DEFAULT NULL,
  `EmbedViews` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_attachment`
--

CREATE TABLE `gdn_attachment` (
  `AttachmentID` int(11) NOT NULL,
  `Type` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignID` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignUserID` int(11) NOT NULL,
  `Source` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `SourceID` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `SourceURL` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  `DateInserted` datetime NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_ban`
--

CREATE TABLE `gdn_ban` (
  `BanID` int(11) NOT NULL,
  `BanType` enum('IPAddress','Name','Email') COLLATE utf8_unicode_ci NOT NULL,
  `BanValue` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Notes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CountUsers` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `CountBlockedRegistrations` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_category`
--

CREATE TABLE `gdn_category` (
  `CategoryID` int(11) NOT NULL,
  `ParentCategoryID` int(11) DEFAULT NULL,
  `TreeLeft` int(11) DEFAULT NULL,
  `TreeRight` int(11) DEFAULT NULL,
  `Depth` int(11) DEFAULT NULL,
  `CountDiscussions` int(11) NOT NULL DEFAULT '0',
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `DateMarkedRead` datetime DEFAULT NULL,
  `AllowDiscussions` tinyint(4) NOT NULL DEFAULT '1',
  `Archived` tinyint(4) NOT NULL DEFAULT '0',
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `UrlCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  `CssClass` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PermissionCategoryID` int(11) NOT NULL DEFAULT '-1',
  `PointsCategoryID` int(11) NOT NULL DEFAULT '0',
  `HideAllDiscussions` tinyint(4) NOT NULL DEFAULT '0',
  `DisplayAs` enum('Categories','Discussions','Heading','Default') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Default',
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `LastCommentID` int(11) DEFAULT NULL,
  `LastDiscussionID` int(11) DEFAULT NULL,
  `LastDateInserted` datetime DEFAULT NULL,
  `AllowedDiscussionTypes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DefaultDiscussionType` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_category`
--

INSERT INTO `gdn_category` (`CategoryID`, `ParentCategoryID`, `TreeLeft`, `TreeRight`, `Depth`, `CountDiscussions`, `CountComments`, `DateMarkedRead`, `AllowDiscussions`, `Archived`, `Name`, `UrlCode`, `Description`, `Sort`, `CssClass`, `Photo`, `PermissionCategoryID`, `PointsCategoryID`, `HideAllDiscussions`, `DisplayAs`, `InsertUserID`, `UpdateUserID`, `DateInserted`, `DateUpdated`, `LastCommentID`, `LastDiscussionID`, `LastDateInserted`, `AllowedDiscussionTypes`, `DefaultDiscussionType`) VALUES
(-1, NULL, 1, 4, NULL, 0, 0, NULL, 1, 0, 'Root', 'root', 'Root of category tree. Users should never see this.', NULL, NULL, NULL, -1, 0, 0, 'Default', 1, 1, '2017-10-08 22:51:14', '2017-10-08 22:51:14', NULL, NULL, NULL, NULL, NULL),
(1, -1, 2, 3, 1, 0, 0, NULL, 1, 0, 'General', 'general', 'General discussions', NULL, NULL, NULL, -1, 0, 0, 'Default', 1, 1, '2017-10-08 22:51:14', '2017-10-08 22:51:14', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_comment`
--

CREATE TABLE `gdn_comment` (
  `CommentID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `DeleteUserID` int(11) DEFAULT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime DEFAULT NULL,
  `DateDeleted` datetime DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flag` tinyint(4) NOT NULL DEFAULT '0',
  `Score` float DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_conversation`
--

CREATE TABLE `gdn_conversation` (
  `ConversationID` int(11) NOT NULL,
  `Type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ForeignID` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributors` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FirstMessageID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime DEFAULT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CountMessages` int(11) NOT NULL DEFAULT '0',
  `CountParticipants` int(11) NOT NULL DEFAULT '0',
  `LastMessageID` int(11) DEFAULT NULL,
  `RegardingID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_conversationmessage`
--

CREATE TABLE `gdn_conversationmessage` (
  `MessageID` int(11) NOT NULL,
  `ConversationID` int(11) NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_discussion`
--

CREATE TABLE `gdn_discussion` (
  `DiscussionID` int(11) NOT NULL,
  `Type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ForeignID` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CategoryID` int(11) NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `FirstCommentID` int(11) DEFAULT NULL,
  `LastCommentID` int(11) DEFAULT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` text COLLATE utf8_unicode_ci,
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `CountBookmarks` int(11) DEFAULT NULL,
  `CountViews` int(11) NOT NULL DEFAULT '1',
  `Closed` tinyint(4) NOT NULL DEFAULT '0',
  `Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Sink` tinyint(4) NOT NULL DEFAULT '0',
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateLastComment` datetime DEFAULT NULL,
  `LastCommentUserID` int(11) DEFAULT NULL,
  `Score` float DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  `RegardingID` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_draft`
--

CREATE TABLE `gdn_draft` (
  `DraftID` int(11) NOT NULL,
  `DiscussionID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Closed` tinyint(4) NOT NULL DEFAULT '0',
  `Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Sink` tinyint(4) NOT NULL DEFAULT '0',
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_invitation`
--

CREATE TABLE `gdn_invitation` (
  `InvitationID` int(11) NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RoleIDs` text COLLATE utf8_unicode_ci,
  `Code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `AcceptedUserID` int(11) DEFAULT NULL,
  `DateExpires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_log`
--

CREATE TABLE `gdn_log` (
  `LogID` int(11) NOT NULL,
  `Operation` enum('Delete','Edit','Spam','Moderate','Pending','Ban','Error') COLLATE utf8_unicode_ci NOT NULL,
  `RecordType` enum('Discussion','Comment','User','Registration','Activity','ActivityComment','Configuration','Group') COLLATE utf8_unicode_ci NOT NULL,
  `TransactionLogID` int(11) DEFAULT NULL,
  `RecordID` int(11) DEFAULT NULL,
  `RecordUserID` int(11) DEFAULT NULL,
  `RecordDate` datetime NOT NULL,
  `RecordIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OtherUserIDs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `ParentRecordID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Data` mediumtext COLLATE utf8_unicode_ci,
  `CountGroup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_log`
--

INSERT INTO `gdn_log` (`LogID`, `Operation`, `RecordType`, `TransactionLogID`, `RecordID`, `RecordUserID`, `RecordDate`, `RecordIPAddress`, `InsertUserID`, `DateInserted`, `InsertIPAddress`, `OtherUserIDs`, `DateUpdated`, `ParentRecordID`, `CategoryID`, `Data`, `CountGroup`) VALUES
(1, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 22:51:21', NULL, 2, '2017-10-08 22:51:21', '127.0.0.1', '', NULL, NULL, NULL, 'a:1:{s:4:\"_New\";a:7:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(2, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 22:51:27', NULL, 2, '2017-10-08 22:51:27', '127.0.0.1', '', NULL, NULL, NULL, 'a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:1:{s:9:\"Dashboard\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(3, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 22:52:08', NULL, 2, '2017-10-08 22:52:08', '127.0.0.1', '', NULL, NULL, NULL, 'a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:1:{s:9:\"Dashboard\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:11:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:1:{s:9:\"Dashboard\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(4, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 22:52:19', NULL, 2, '2017-10-08 22:52:19', '127.0.0.1', '', NULL, NULL, NULL, 'a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:11:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:1:{s:9:\"Dashboard\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:11:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:2:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(5, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 22:54:18', NULL, 2, '2017-10-08 22:54:18', '127.0.0.1', '', NULL, NULL, NULL, 'a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:11:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:2:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:2:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(6, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 22:54:21', NULL, 2, '2017-10-08 22:54:21', '127.0.0.1', '', NULL, NULL, NULL, 'a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:2:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:2:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(7, 'Delete', 'Discussion', 7, 1, 1, '2017-10-08 22:51:19', NULL, 2, '2017-10-08 22:56:28', '127.0.0.1', '', NULL, NULL, 1, 'a:28:{s:12:\"DiscussionID\";i:1;s:4:\"Type\";N;s:9:\"ForeignID\";s:4:\"stub\";s:10:\"CategoryID\";i:1;s:12:\"InsertUserID\";i:1;s:12:\"UpdateUserID\";N;s:14:\"FirstCommentID\";N;s:13:\"LastCommentID\";i:1;s:4:\"Name\";s:35:\"BAM! You&rsquo;ve got a sweet forum\";s:4:\"Body\";s:994:\"There&rsquo;s nothing sweeter than a fresh new forum, ready to welcome your community. A Vanilla Forum has all the bits and pieces you need to build an awesome discussion platform customized to your needs. Here&rsquo;s a few tips:\n<ul>\n   <li>Use the <a href=\"/dashboard/settings/gettingstarted\">Getting Started</a> list in the Dashboard to configure your site.</li>\n   <li>Don&rsquo;t use too many categories. We recommend 3-8. Keep it simple!</li>\n   <li>&ldquo;Announce&rdquo; a discussion (click the gear) to stick to the top of the list, and &ldquo;Close&rdquo; it to stop further comments.</li>\n   <li>Use &ldquo;Sink&rdquo; to take attention away from a discussion. New comments will no longer bring it back to the top of the list.</li>\n   <li>Bookmark a discussion (click the star) to get notifications for new comments. You can edit notification settings from your profile.</li>\n</ul>\nGo ahead and edit or delete this discussion, then spread the word to get this place cooking. Cheers!\";s:6:\"Format\";s:4:\"Html\";s:4:\"Tags\";N;s:13:\"CountComments\";i:1;s:14:\"CountBookmarks\";N;s:10:\"CountViews\";i:1;s:6:\"Closed\";i:0;s:8:\"Announce\";i:0;s:4:\"Sink\";i:0;s:12:\"DateInserted\";s:19:\"2017-10-08 22:51:19\";s:11:\"DateUpdated\";N;s:15:\"InsertIPAddress\";N;s:15:\"UpdateIPAddress\";N;s:15:\"DateLastComment\";s:19:\"2017-10-08 22:51:19\";s:17:\"LastCommentUserID\";i:1;s:5:\"Score\";N;s:10:\"Attributes\";N;s:11:\"RegardingID\";N;s:5:\"_Data\";a:1:{s:7:\"Comment\";a:1:{i:0;a:15:{s:9:\"CommentID\";i:1;s:12:\"DiscussionID\";i:1;s:12:\"InsertUserID\";i:1;s:12:\"UpdateUserID\";N;s:12:\"DeleteUserID\";N;s:4:\"Body\";s:340:\"This is the first comment on your site and it&rsquo;s an important one.\n\nDon&rsquo;t see your must-have feature? We keep Vanilla nice and simple by default. Use <b>addons</b> to get the special sauce your community needs.\n\nNot sure which addons to enable? Our favorites are Button Bar and Tagging. They&rsquo;re almost always a great start.\";s:6:\"Format\";s:4:\"Html\";s:12:\"DateInserted\";s:19:\"2017-10-08 22:51:19\";s:11:\"DateDeleted\";N;s:11:\"DateUpdated\";N;s:15:\"InsertIPAddress\";N;s:15:\"UpdateIPAddress\";N;s:4:\"Flag\";i:0;s:5:\"Score\";N;s:10:\"Attributes\";N;}}}}', NULL),
(8, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-08 23:00:07', NULL, 2, '2017-10-08 23:00:07', '127.0.0.1', '', NULL, NULL, NULL, 'a:10:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:2:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:6:{s:12:\"ConfirmEmail\";s:1:\"1\";s:6:\"Method\";s:7:\"Captcha\";s:16:\"InviteExpiration\";s:6:\"1 week\";s:17:\"CaptchaPrivateKey\";s:40:\"6LdVlzMUAAAAADkK6xvI265aM8P0b8e7SbxDF4eS\";s:16:\"CaptchaPublicKey\";s:40:\"6LdVlzMUAAAAABnDdoJhP4b7EkhG7VEhJbDA-4hc\";s:11:\"InviteRoles\";a:5:{i:3;s:1:\"0\";i:4;s:1:\"0\";i:8;s:1:\"0\";i:16;s:1:\"0\";i:32;s:1:\"0\";}}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:3:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";s:12:\"Registration\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(9, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-09 16:17:20', NULL, 2, '2017-10-09 16:17:20', '127.0.0.1', '', NULL, NULL, NULL, 'a:10:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:6:{s:12:\"ConfirmEmail\";s:1:\"1\";s:6:\"Method\";s:7:\"Captcha\";s:16:\"InviteExpiration\";s:6:\"1 week\";s:17:\"CaptchaPrivateKey\";s:40:\"6LdVlzMUAAAAADkK6xvI265aM8P0b8e7SbxDF4eS\";s:16:\"CaptchaPublicKey\";s:40:\"6LdVlzMUAAAAABnDdoJhP4b7EkhG7VEhJbDA-4hc\";s:11:\"InviteRoles\";a:5:{i:3;s:1:\"0\";i:4;s:1:\"0\";i:8;s:1:\"0\";i:16;s:1:\"0\";i:32;s:1:\"0\";}}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:3:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";s:12:\"Registration\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:6:{s:12:\"ConfirmEmail\";s:1:\"1\";s:6:\"Method\";s:7:\"Captcha\";s:16:\"InviteExpiration\";s:6:\"1 week\";s:17:\"CaptchaPrivateKey\";s:40:\"6LdVlzMUAAAAADkK6xvI265aM8P0b8e7SbxDF4eS\";s:16:\"CaptchaPublicKey\";s:40:\"6LdVlzMUAAAAABnDdoJhP4b7EkhG7VEhJbDA-4hc\";s:11:\"InviteRoles\";a:5:{i:3;s:1:\"0\";i:4;s:1:\"0\";i:8;s:1:\"0\";i:16;s:1:\"0\";i:32;s:1:\"0\";}}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:2:{s:14:\"GettingStarted\";a:3:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";s:12:\"Registration\";s:1:\"1\";}s:10:\"Vanillicon\";a:1:{s:4:\"Type\";s:2:\"v2\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL),
(10, 'Edit', 'Configuration', NULL, NULL, NULL, '2017-10-09 16:17:20', NULL, 2, '2017-10-09 16:17:20', '127.0.0.1', '', NULL, NULL, NULL, 'a:10:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:6:{s:12:\"ConfirmEmail\";s:1:\"1\";s:6:\"Method\";s:7:\"Captcha\";s:16:\"InviteExpiration\";s:6:\"1 week\";s:17:\"CaptchaPrivateKey\";s:40:\"6LdVlzMUAAAAADkK6xvI265aM8P0b8e7SbxDF4eS\";s:16:\"CaptchaPublicKey\";s:40:\"6LdVlzMUAAAAABnDdoJhP4b7EkhG7VEhJbDA-4hc\";s:11:\"InviteRoles\";a:5:{i:3;s:1:\"0\";i:4;s:1:\"0\";i:8;s:1:\"0\";i:16;s:1:\"0\";i:32;s:1:\"0\";}}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:2:{s:14:\"GettingStarted\";a:3:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";s:12:\"Registration\";s:1:\"1\";}s:10:\"Vanillicon\";a:1:{s:4:\"Type\";s:2:\"v2\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:4:\"_New\";a:9:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:11:\"vecino_foro\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledLocales\";a:1:{s:5:\"vf_es\";s:2:\"es\";}s:14:\"EnabledPlugins\";a:3:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";s:10:\"vanillicon\";b:1;}s:6:\"Garden\";a:12:{s:5:\"Title\";s:17:\"Foro para vecinos\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:16:\"l86mR4juK9H8ICUN\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:6:{s:12:\"ConfirmEmail\";s:1:\"1\";s:6:\"Method\";s:7:\"Captcha\";s:16:\"InviteExpiration\";s:6:\"1 week\";s:17:\"CaptchaPrivateKey\";s:40:\"6LdVlzMUAAAAADkK6xvI265aM8P0b8e7SbxDF4eS\";s:16:\"CaptchaPublicKey\";s:40:\"6LdVlzMUAAAAABnDdoJhP4b7EkhG7VEhJbDA-4hc\";s:11:\"InviteRoles\";a:5:{i:3;s:1:\"0\";i:4;s:1:\"0\";i:8;s:1:\"0\";i:16;s:1:\"0\";i:32;s:1:\"0\";}}s:5:\"Email\";a:2:{s:11:\"SupportName\";s:17:\"Foro para vecinos\";s:6:\"Format\";s:4:\"text\";}s:12:\"SystemUserID\";s:1:\"1\";s:14:\"InputFormatter\";s:8:\"Markdown\";s:7:\"Version\";s:5:\"2.3.1\";s:4:\"Cdns\";a:1:{s:7:\"Disable\";b:0;}s:16:\"CanProcessImages\";b:1;s:9:\"Installed\";b:1;s:5:\"Theme\";s:11:\"bittersweet\";s:6:\"Locale\";s:2:\"es\";}s:7:\"Plugins\";a:2:{s:14:\"GettingStarted\";a:3:{s:9:\"Dashboard\";s:1:\"1\";s:7:\"Plugins\";s:1:\"1\";s:12:\"Registration\";s:1:\"1\";}s:10:\"Vanillicon\";a:1:{s:4:\"Type\";s:2:\"v2\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:5:\"2.3.1\";}}}', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_media`
--

CREATE TABLE `gdn_media` (
  `MediaID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Size` int(11) NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `ForeignID` int(11) DEFAULT NULL,
  `ForeignTable` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ImageWidth` smallint(5) UNSIGNED DEFAULT NULL,
  `ImageHeight` smallint(5) UNSIGNED DEFAULT NULL,
  `ThumbWidth` smallint(5) UNSIGNED DEFAULT NULL,
  `ThumbHeight` smallint(5) UNSIGNED DEFAULT NULL,
  `ThumbPath` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_message`
--

CREATE TABLE `gdn_message` (
  `MessageID` int(11) NOT NULL,
  `Content` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AllowDismiss` tinyint(4) NOT NULL DEFAULT '1',
  `Enabled` tinyint(4) NOT NULL DEFAULT '1',
  `Application` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `IncludeSubcategories` tinyint(4) NOT NULL DEFAULT '0',
  `AssetTarget` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CssClass` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_permission`
--

CREATE TABLE `gdn_permission` (
  `PermissionID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL DEFAULT '0',
  `JunctionTable` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `JunctionColumn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `JunctionID` int(11) DEFAULT NULL,
  `Garden.Email.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Settings.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Settings.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.SignIn.Allow` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Activity.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Activity.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Profiles.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Profiles.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Curation.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Moderation.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.PersonalInfo.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.AdvancedNotifications.Allow` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Community.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Conversations.Moderation.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Conversations.Conversations.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Approval.Require` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Me` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.View` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Sink` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Close` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Delete` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_permission`
--

INSERT INTO `gdn_permission` (`PermissionID`, `RoleID`, `JunctionTable`, `JunctionColumn`, `JunctionID`, `Garden.Email.View`, `Garden.Settings.Manage`, `Garden.Settings.View`, `Garden.SignIn.Allow`, `Garden.Users.Add`, `Garden.Users.Edit`, `Garden.Users.Delete`, `Garden.Users.Approve`, `Garden.Activity.Delete`, `Garden.Activity.View`, `Garden.Profiles.View`, `Garden.Profiles.Edit`, `Garden.Curation.Manage`, `Garden.Moderation.Manage`, `Garden.PersonalInfo.View`, `Garden.AdvancedNotifications.Allow`, `Garden.Community.Manage`, `Conversations.Moderation.Manage`, `Conversations.Conversations.Add`, `Vanilla.Approval.Require`, `Vanilla.Comments.Me`, `Vanilla.Discussions.View`, `Vanilla.Discussions.Add`, `Vanilla.Discussions.Edit`, `Vanilla.Discussions.Announce`, `Vanilla.Discussions.Sink`, `Vanilla.Discussions.Close`, `Vanilla.Discussions.Delete`, `Vanilla.Comments.Add`, `Vanilla.Comments.Edit`, `Vanilla.Comments.Delete`) VALUES
(1, 0, NULL, NULL, NULL, 3, 2, 2, 3, 2, 2, 2, 2, 2, 3, 3, 3, 2, 2, 2, 2, 2, 2, 3, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 0, 'Category', 'PermissionCategoryID', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 3, 2, 2, 2, 2, 2, 3, 2, 2),
(3, 2, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 2, 'Category', 'PermissionCategoryID', -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 3, NULL, NULL, NULL, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 3, 'Category', 'PermissionCategoryID', -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 4, NULL, NULL, NULL, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 4, 'Category', 'PermissionCategoryID', -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 8, NULL, NULL, NULL, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0),
(10, 8, 'Category', 'PermissionCategoryID', -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0),
(11, 32, NULL, NULL, NULL, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(12, 32, 'Category', 'PermissionCategoryID', -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(13, 16, NULL, NULL, NULL, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(14, 16, 'Category', 'PermissionCategoryID', -1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_regarding`
--

CREATE TABLE `gdn_regarding` (
  `RegardingID` int(11) NOT NULL,
  `Type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `ForeignType` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignID` int(11) NOT NULL,
  `OriginalContent` text COLLATE utf8_unicode_ci,
  `ParentType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `ForeignURL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Comment` text COLLATE utf8_unicode_ci NOT NULL,
  `Reports` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_role`
--

CREATE TABLE `gdn_role` (
  `RoleID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Type` enum('guest','unconfirmed','applicant','member','moderator','administrator') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  `Deletable` tinyint(4) NOT NULL DEFAULT '1',
  `CanSession` tinyint(4) NOT NULL DEFAULT '1',
  `PersonalInfo` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_role`
--

INSERT INTO `gdn_role` (`RoleID`, `Name`, `Description`, `Type`, `Sort`, `Deletable`, `CanSession`, `PersonalInfo`) VALUES
(2, 'Guest', 'Guests can only view content. Anyone browsing the site who is not signed in is considered to be a \"Guest\".', 'guest', 1, 0, 0, 0),
(3, 'Unconfirmed', 'Users must confirm their emails before becoming full members. They get assigned to this role.', 'unconfirmed', 2, 0, 1, 0),
(4, 'Applicant', 'Users who have applied for membership, but have not yet been accepted. They have the same permissions as guests.', 'applicant', 3, 0, 1, 0),
(8, 'Member', 'Members can participate in discussions.', 'member', 4, 1, 1, 0),
(16, 'Administrator', 'Administrators have permission to do anything.', 'administrator', 6, 1, 1, 0),
(32, 'Moderator', 'Moderators have permission to edit most content.', 'moderator', 5, 1, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_session`
--

CREATE TABLE `gdn_session` (
  `SessionID` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` int(11) NOT NULL DEFAULT '0',
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `TransientKey` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `Attributes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_spammer`
--

CREATE TABLE `gdn_spammer` (
  `UserID` int(11) NOT NULL,
  `CountSpam` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `CountDeletedSpam` smallint(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_tag`
--

CREATE TABLE `gdn_tag` (
  `TagID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `FullName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ParentTagID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `CategoryID` int(11) NOT NULL DEFAULT '-1',
  `CountDiscussions` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_tagdiscussion`
--

CREATE TABLE `gdn_tagdiscussion` (
  `TagID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `DateInserted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_user`
--

CREATE TABLE `gdn_user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varbinary(100) NOT NULL,
  `HashMethod` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Location` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `About` text COLLATE utf8_unicode_ci,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ShowEmail` tinyint(4) NOT NULL DEFAULT '0',
  `Gender` enum('u','m','f') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'u',
  `CountVisits` int(11) NOT NULL DEFAULT '0',
  `CountInvitations` int(11) NOT NULL DEFAULT '0',
  `CountNotifications` int(11) DEFAULT NULL,
  `InviteUserID` int(11) DEFAULT NULL,
  `DiscoveryText` text COLLATE utf8_unicode_ci,
  `Preferences` text COLLATE utf8_unicode_ci,
  `Permissions` text COLLATE utf8_unicode_ci,
  `Attributes` text COLLATE utf8_unicode_ci,
  `DateSetInvitations` datetime DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `DateFirstVisit` datetime DEFAULT NULL,
  `DateLastActive` datetime DEFAULT NULL,
  `LastIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AllIPAddresses` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HourOffset` int(11) NOT NULL DEFAULT '0',
  `Score` float DEFAULT NULL,
  `Admin` tinyint(4) NOT NULL DEFAULT '0',
  `Confirmed` tinyint(4) NOT NULL DEFAULT '1',
  `Verified` tinyint(4) NOT NULL DEFAULT '0',
  `Banned` tinyint(4) NOT NULL DEFAULT '0',
  `Deleted` tinyint(4) NOT NULL DEFAULT '0',
  `Points` int(11) NOT NULL DEFAULT '0',
  `CountUnreadConversations` int(11) DEFAULT NULL,
  `CountDiscussions` int(11) DEFAULT NULL,
  `CountUnreadDiscussions` int(11) DEFAULT NULL,
  `CountComments` int(11) DEFAULT NULL,
  `CountDrafts` int(11) DEFAULT NULL,
  `CountBookmarks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_user`
--

INSERT INTO `gdn_user` (`UserID`, `Name`, `Password`, `HashMethod`, `Photo`, `Title`, `Location`, `About`, `Email`, `ShowEmail`, `Gender`, `CountVisits`, `CountInvitations`, `CountNotifications`, `InviteUserID`, `DiscoveryText`, `Preferences`, `Permissions`, `Attributes`, `DateSetInvitations`, `DateOfBirth`, `DateFirstVisit`, `DateLastActive`, `LastIPAddress`, `AllIPAddresses`, `DateInserted`, `InsertIPAddress`, `DateUpdated`, `UpdateIPAddress`, `HourOffset`, `Score`, `Admin`, `Confirmed`, `Verified`, `Banned`, `Deleted`, `Points`, `CountUnreadConversations`, `CountDiscussions`, `CountUnreadDiscussions`, `CountComments`, `CountDrafts`, `CountBookmarks`) VALUES
(1, 'System', 0x4352474330544c4658485a344f424c564c564231, 'Random', 'http://127.0.0.1/Portal_del_Vecino/Portal_del_Vecino/public_html/modulos/foro/applications/dashboard/design/images/usericon.png', NULL, NULL, NULL, 'system@example.com', 0, 'u', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-10-08 22:51:02', NULL, NULL, NULL, 0, NULL, 2, 1, 0, 0, 0, 0, NULL, 0, NULL, NULL, NULL, NULL),
(2, 'admin', 0x24326124303824554c3431686256776b30554b342f7950545a395576754c6d3844396439444f7943596e683250567a327741447062776f6143343632, 'Vanilla', NULL, NULL, NULL, NULL, 'matiasignaciomellado@hotmail.com', 0, 'u', 1, 0, NULL, NULL, NULL, 'a:2:{s:16:\"PreviewThemeName\";s:0:\"\";s:18:\"PreviewThemeFolder\";s:0:\"\";}', 'a:0:{}', 'a:3:{s:12:\"TransientKey\";s:16:\"poeKVnQ5X2jXZ7Ap\";s:16:\"LastLoginAttempt\";i:1507565312;s:9:\"LoginRate\";i:1;}', NULL, '1975-09-16 00:00:00', '2017-10-08 22:51:10', '2017-10-09 16:08:32', '127.0.0.1', '127.0.0.1', '2017-10-08 22:51:10', '127.0.0.1', '2017-10-08 22:51:10', NULL, -3, NULL, 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'usuario', 0x2432612430382474716378376444376241723457686e697633352e70755466594c556f436f5641713738546d4a7a537058345343362e536451425557, 'Vanilla', NULL, NULL, NULL, NULL, 'matiasignaciomellado@hotmail.cl', 0, 'm', 1, 0, NULL, NULL, NULL, NULL, '', 'a:4:{s:8:\"EmailKey\";s:8:\"3DX8HOKN\";s:12:\"TransientKey\";s:16:\"E5IZc30hiZbYEqC7\";s:16:\"LastLoginAttempt\";i:1507565197;s:9:\"LoginRate\";i:1;}', NULL, NULL, '2017-10-08 23:02:38', '2017-10-09 16:06:37', '127.0.0.1', '127.0.0.1', '2017-10-08 23:02:38', '127.0.0.1', NULL, NULL, -3, NULL, 0, 0, 0, 0, 0, 0, NULL, 0, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userauthentication`
--

CREATE TABLE `gdn_userauthentication` (
  `ForeignUserKey` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ProviderKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userauthenticationnonce`
--

CREATE TABLE `gdn_userauthenticationnonce` (
  `Nonce` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userauthenticationprovider`
--

CREATE TABLE `gdn_userauthenticationprovider` (
  `AuthenticationKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `AuthenticationSchemeAlias` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `URL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AssociationSecret` text COLLATE utf8_unicode_ci,
  `AssociationHashMethod` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AuthenticateUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RegisterUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SignInUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SignOutUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PasswordUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProfileUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  `Active` tinyint(4) NOT NULL DEFAULT '1',
  `IsDefault` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userauthenticationtoken`
--

CREATE TABLE `gdn_userauthenticationtoken` (
  `Token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ProviderKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignUserKey` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TokenSecret` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `TokenType` enum('request','access') COLLATE utf8_unicode_ci NOT NULL,
  `Authorized` tinyint(4) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Lifetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_usercategory`
--

CREATE TABLE `gdn_usercategory` (
  `UserID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `DateMarkedRead` datetime DEFAULT NULL,
  `Unfollow` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_usercomment`
--

CREATE TABLE `gdn_usercomment` (
  `UserID` int(11) NOT NULL,
  `CommentID` int(11) NOT NULL,
  `Score` float DEFAULT NULL,
  `DateLastViewed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userconversation`
--

CREATE TABLE `gdn_userconversation` (
  `UserID` int(11) NOT NULL,
  `ConversationID` int(11) NOT NULL,
  `CountReadMessages` int(11) NOT NULL DEFAULT '0',
  `LastMessageID` int(11) DEFAULT NULL,
  `DateLastViewed` datetime DEFAULT NULL,
  `DateCleared` datetime DEFAULT NULL,
  `Bookmarked` tinyint(4) NOT NULL DEFAULT '0',
  `Deleted` tinyint(4) NOT NULL DEFAULT '0',
  `DateConversationUpdated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userdiscussion`
--

CREATE TABLE `gdn_userdiscussion` (
  `UserID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  `Score` float DEFAULT NULL,
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `DateLastViewed` datetime DEFAULT NULL,
  `Dismissed` tinyint(4) NOT NULL DEFAULT '0',
  `Bookmarked` tinyint(4) NOT NULL DEFAULT '0',
  `Participated` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_usermerge`
--

CREATE TABLE `gdn_usermerge` (
  `MergeID` int(11) NOT NULL,
  `OldUserID` int(11) NOT NULL,
  `NewUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_usermergeitem`
--

CREATE TABLE `gdn_usermergeitem` (
  `MergeID` int(11) NOT NULL,
  `Table` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Column` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `RecordID` int(11) NOT NULL,
  `OldUserID` int(11) NOT NULL,
  `NewUserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_usermeta`
--

CREATE TABLE `gdn_usermeta` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Value` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userpoints`
--

CREATE TABLE `gdn_userpoints` (
  `SlotType` enum('d','w','m','y','a') COLLATE utf8_unicode_ci NOT NULL,
  `TimeSlot` datetime NOT NULL,
  `Source` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Total',
  `CategoryID` int(11) NOT NULL DEFAULT '0',
  `UserID` int(11) NOT NULL,
  `Points` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gdn_userrole`
--

CREATE TABLE `gdn_userrole` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `gdn_userrole`
--

INSERT INTO `gdn_userrole` (`UserID`, `RoleID`) VALUES
(2, 16),
(3, 3),
(3, 8);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gdn_activity`
--
ALTER TABLE `gdn_activity`
  ADD PRIMARY KEY (`ActivityID`),
  ADD KEY `IX_Activity_Notify` (`NotifyUserID`,`Notified`),
  ADD KEY `IX_Activity_Recent` (`NotifyUserID`,`DateUpdated`),
  ADD KEY `IX_Activity_Feed` (`NotifyUserID`,`ActivityUserID`,`DateUpdated`),
  ADD KEY `IX_Activity_DateUpdated` (`DateUpdated`),
  ADD KEY `FK_Activity_InsertUserID` (`InsertUserID`);

--
-- Indices de la tabla `gdn_activitycomment`
--
ALTER TABLE `gdn_activitycomment`
  ADD PRIMARY KEY (`ActivityCommentID`),
  ADD KEY `FK_ActivityComment_ActivityID` (`ActivityID`);

--
-- Indices de la tabla `gdn_activitytype`
--
ALTER TABLE `gdn_activitytype`
  ADD PRIMARY KEY (`ActivityTypeID`);

--
-- Indices de la tabla `gdn_analyticslocal`
--
ALTER TABLE `gdn_analyticslocal`
  ADD UNIQUE KEY `UX_AnalyticsLocal` (`TimeSlot`);

--
-- Indices de la tabla `gdn_attachment`
--
ALTER TABLE `gdn_attachment`
  ADD PRIMARY KEY (`AttachmentID`),
  ADD KEY `IX_Attachment_ForeignID` (`ForeignID`),
  ADD KEY `FK_Attachment_ForeignUserID` (`ForeignUserID`),
  ADD KEY `FK_Attachment_InsertUserID` (`InsertUserID`);

--
-- Indices de la tabla `gdn_ban`
--
ALTER TABLE `gdn_ban`
  ADD PRIMARY KEY (`BanID`),
  ADD UNIQUE KEY `UX_Ban` (`BanType`,`BanValue`);

--
-- Indices de la tabla `gdn_category`
--
ALTER TABLE `gdn_category`
  ADD PRIMARY KEY (`CategoryID`),
  ADD KEY `FK_Category_InsertUserID` (`InsertUserID`);

--
-- Indices de la tabla `gdn_comment`
--
ALTER TABLE `gdn_comment`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `IX_Comment_1` (`DiscussionID`,`DateInserted`),
  ADD KEY `IX_Comment_DateInserted` (`DateInserted`),
  ADD KEY `FK_Comment_InsertUserID` (`InsertUserID`);
ALTER TABLE `gdn_comment` ADD FULLTEXT KEY `TX_Comment` (`Body`);

--
-- Indices de la tabla `gdn_conversation`
--
ALTER TABLE `gdn_conversation`
  ADD PRIMARY KEY (`ConversationID`),
  ADD KEY `IX_Conversation_Type` (`Type`),
  ADD KEY `IX_Conversation_RegardingID` (`RegardingID`),
  ADD KEY `FK_Conversation_FirstMessageID` (`FirstMessageID`),
  ADD KEY `FK_Conversation_InsertUserID` (`InsertUserID`),
  ADD KEY `FK_Conversation_DateInserted` (`DateInserted`),
  ADD KEY `FK_Conversation_UpdateUserID` (`UpdateUserID`);

--
-- Indices de la tabla `gdn_conversationmessage`
--
ALTER TABLE `gdn_conversationmessage`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `FK_ConversationMessage_ConversationID` (`ConversationID`),
  ADD KEY `FK_ConversationMessage_InsertUserID` (`InsertUserID`);

--
-- Indices de la tabla `gdn_discussion`
--
ALTER TABLE `gdn_discussion`
  ADD PRIMARY KEY (`DiscussionID`),
  ADD KEY `IX_Discussion_Type` (`Type`),
  ADD KEY `IX_Discussion_ForeignID` (`ForeignID`),
  ADD KEY `IX_Discussion_DateInserted` (`DateInserted`),
  ADD KEY `IX_Discussion_DateLastComment` (`DateLastComment`),
  ADD KEY `IX_Discussion_RegardingID` (`RegardingID`),
  ADD KEY `IX_Discussion_CategoryPages` (`CategoryID`,`DateLastComment`),
  ADD KEY `IX_Discussion_CategoryInserted` (`CategoryID`,`DateInserted`),
  ADD KEY `FK_Discussion_InsertUserID` (`InsertUserID`);
ALTER TABLE `gdn_discussion` ADD FULLTEXT KEY `TX_Discussion` (`Name`,`Body`);

--
-- Indices de la tabla `gdn_draft`
--
ALTER TABLE `gdn_draft`
  ADD PRIMARY KEY (`DraftID`),
  ADD KEY `FK_Draft_DiscussionID` (`DiscussionID`),
  ADD KEY `FK_Draft_CategoryID` (`CategoryID`),
  ADD KEY `FK_Draft_InsertUserID` (`InsertUserID`);

--
-- Indices de la tabla `gdn_invitation`
--
ALTER TABLE `gdn_invitation`
  ADD PRIMARY KEY (`InvitationID`),
  ADD UNIQUE KEY `UX_Invitation` (`Code`),
  ADD KEY `IX_Invitation_Email` (`Email`),
  ADD KEY `IX_Invitation_userdate` (`InsertUserID`,`DateInserted`);

--
-- Indices de la tabla `gdn_log`
--
ALTER TABLE `gdn_log`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `IX_Log_Operation` (`Operation`),
  ADD KEY `IX_Log_RecordType` (`RecordType`),
  ADD KEY `IX_Log_RecordID` (`RecordID`),
  ADD KEY `IX_Log_RecordUserID` (`RecordUserID`),
  ADD KEY `IX_Log_RecordIPAddress` (`RecordIPAddress`),
  ADD KEY `IX_Log_DateInserted` (`DateInserted`),
  ADD KEY `IX_Log_ParentRecordID` (`ParentRecordID`),
  ADD KEY `FK_Log_CategoryID` (`CategoryID`);

--
-- Indices de la tabla `gdn_media`
--
ALTER TABLE `gdn_media`
  ADD PRIMARY KEY (`MediaID`),
  ADD KEY `IX_Media_Foreign` (`ForeignID`,`ForeignTable`);

--
-- Indices de la tabla `gdn_message`
--
ALTER TABLE `gdn_message`
  ADD PRIMARY KEY (`MessageID`);

--
-- Indices de la tabla `gdn_permission`
--
ALTER TABLE `gdn_permission`
  ADD PRIMARY KEY (`PermissionID`),
  ADD KEY `FK_Permission_RoleID` (`RoleID`);

--
-- Indices de la tabla `gdn_regarding`
--
ALTER TABLE `gdn_regarding`
  ADD PRIMARY KEY (`RegardingID`),
  ADD KEY `FK_Regarding_Type` (`Type`);

--
-- Indices de la tabla `gdn_role`
--
ALTER TABLE `gdn_role`
  ADD PRIMARY KEY (`RoleID`);

--
-- Indices de la tabla `gdn_session`
--
ALTER TABLE `gdn_session`
  ADD PRIMARY KEY (`SessionID`);

--
-- Indices de la tabla `gdn_spammer`
--
ALTER TABLE `gdn_spammer`
  ADD PRIMARY KEY (`UserID`);

--
-- Indices de la tabla `gdn_tag`
--
ALTER TABLE `gdn_tag`
  ADD PRIMARY KEY (`TagID`),
  ADD UNIQUE KEY `UX_Tag` (`Name`,`CategoryID`),
  ADD KEY `IX_Tag_FullName` (`FullName`),
  ADD KEY `IX_Tag_Type` (`Type`),
  ADD KEY `FK_Tag_ParentTagID` (`ParentTagID`),
  ADD KEY `FK_Tag_InsertUserID` (`InsertUserID`);

--
-- Indices de la tabla `gdn_tagdiscussion`
--
ALTER TABLE `gdn_tagdiscussion`
  ADD PRIMARY KEY (`TagID`,`DiscussionID`),
  ADD KEY `IX_TagDiscussion_CategoryID` (`CategoryID`);

--
-- Indices de la tabla `gdn_user`
--
ALTER TABLE `gdn_user`
  ADD PRIMARY KEY (`UserID`),
  ADD KEY `FK_User_Name` (`Name`),
  ADD KEY `IX_User_Email` (`Email`),
  ADD KEY `IX_User_DateLastActive` (`DateLastActive`),
  ADD KEY `IX_User_DateInserted` (`DateInserted`);

--
-- Indices de la tabla `gdn_userauthentication`
--
ALTER TABLE `gdn_userauthentication`
  ADD PRIMARY KEY (`ForeignUserKey`,`ProviderKey`),
  ADD KEY `FK_UserAuthentication_UserID` (`UserID`);

--
-- Indices de la tabla `gdn_userauthenticationnonce`
--
ALTER TABLE `gdn_userauthenticationnonce`
  ADD PRIMARY KEY (`Nonce`);

--
-- Indices de la tabla `gdn_userauthenticationprovider`
--
ALTER TABLE `gdn_userauthenticationprovider`
  ADD PRIMARY KEY (`AuthenticationKey`);

--
-- Indices de la tabla `gdn_userauthenticationtoken`
--
ALTER TABLE `gdn_userauthenticationtoken`
  ADD PRIMARY KEY (`Token`,`ProviderKey`);

--
-- Indices de la tabla `gdn_usercategory`
--
ALTER TABLE `gdn_usercategory`
  ADD PRIMARY KEY (`UserID`,`CategoryID`);

--
-- Indices de la tabla `gdn_usercomment`
--
ALTER TABLE `gdn_usercomment`
  ADD PRIMARY KEY (`UserID`,`CommentID`);

--
-- Indices de la tabla `gdn_userconversation`
--
ALTER TABLE `gdn_userconversation`
  ADD PRIMARY KEY (`UserID`,`ConversationID`),
  ADD KEY `IX_UserConversation_Inbox` (`UserID`,`Deleted`,`DateConversationUpdated`),
  ADD KEY `FK_UserConversation_ConversationID` (`ConversationID`);

--
-- Indices de la tabla `gdn_userdiscussion`
--
ALTER TABLE `gdn_userdiscussion`
  ADD PRIMARY KEY (`UserID`,`DiscussionID`),
  ADD KEY `FK_UserDiscussion_DiscussionID` (`DiscussionID`);

--
-- Indices de la tabla `gdn_usermerge`
--
ALTER TABLE `gdn_usermerge`
  ADD PRIMARY KEY (`MergeID`),
  ADD KEY `FK_UserMerge_OldUserID` (`OldUserID`),
  ADD KEY `FK_UserMerge_NewUserID` (`NewUserID`);

--
-- Indices de la tabla `gdn_usermergeitem`
--
ALTER TABLE `gdn_usermergeitem`
  ADD KEY `FK_UserMergeItem_MergeID` (`MergeID`);

--
-- Indices de la tabla `gdn_usermeta`
--
ALTER TABLE `gdn_usermeta`
  ADD PRIMARY KEY (`UserID`,`Name`),
  ADD KEY `IX_UserMeta_Name` (`Name`);

--
-- Indices de la tabla `gdn_userpoints`
--
ALTER TABLE `gdn_userpoints`
  ADD PRIMARY KEY (`SlotType`,`TimeSlot`,`Source`,`CategoryID`,`UserID`);

--
-- Indices de la tabla `gdn_userrole`
--
ALTER TABLE `gdn_userrole`
  ADD PRIMARY KEY (`UserID`,`RoleID`),
  ADD KEY `IX_UserRole_RoleID` (`RoleID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gdn_activity`
--
ALTER TABLE `gdn_activity`
  MODIFY `ActivityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `gdn_activitycomment`
--
ALTER TABLE `gdn_activitycomment`
  MODIFY `ActivityCommentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_activitytype`
--
ALTER TABLE `gdn_activitytype`
  MODIFY `ActivityTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `gdn_attachment`
--
ALTER TABLE `gdn_attachment`
  MODIFY `AttachmentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_ban`
--
ALTER TABLE `gdn_ban`
  MODIFY `BanID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_category`
--
ALTER TABLE `gdn_category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `gdn_comment`
--
ALTER TABLE `gdn_comment`
  MODIFY `CommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `gdn_conversation`
--
ALTER TABLE `gdn_conversation`
  MODIFY `ConversationID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_conversationmessage`
--
ALTER TABLE `gdn_conversationmessage`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_discussion`
--
ALTER TABLE `gdn_discussion`
  MODIFY `DiscussionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `gdn_draft`
--
ALTER TABLE `gdn_draft`
  MODIFY `DraftID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_invitation`
--
ALTER TABLE `gdn_invitation`
  MODIFY `InvitationID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_log`
--
ALTER TABLE `gdn_log`
  MODIFY `LogID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `gdn_media`
--
ALTER TABLE `gdn_media`
  MODIFY `MediaID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_message`
--
ALTER TABLE `gdn_message`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_permission`
--
ALTER TABLE `gdn_permission`
  MODIFY `PermissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `gdn_regarding`
--
ALTER TABLE `gdn_regarding`
  MODIFY `RegardingID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_role`
--
ALTER TABLE `gdn_role`
  MODIFY `RoleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `gdn_tag`
--
ALTER TABLE `gdn_tag`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `gdn_user`
--
ALTER TABLE `gdn_user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `gdn_usermerge`
--
ALTER TABLE `gdn_usermerge`
  MODIFY `MergeID` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
