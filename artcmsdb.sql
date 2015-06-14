-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2015 at 09:07 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `artcmsdb3`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `url` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `subtitle` varchar(500) NOT NULL,
  `body` mediumtext,
  `remarks` varchar(500) NOT NULL,
  `meta_tags` varchar(200) NOT NULL,
  `privacy` int(11) NOT NULL,
  `atype` int(11) NOT NULL,
  `date_inserted` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `uid`, `category_id`, `url`, `title`, `subtitle`, `body`, `remarks`, `meta_tags`, `privacy`, `atype`, `date_inserted`, `date_updated`, `state`) VALUES
(1, 1, 2, 'home', 'ArticulateCMS', 'an Open Source Content Management System platform for publishing text contents', '<p style=\\"text-align: justify; width: auto;\\">ArticulateCMS is a simple  text-based Open Source Content Management System platform powered by  ArticulatePHP framework and MySQL database engine in  Model-View-Controller (MVC) web development architecture.</p>\r\n<p style=\\"text-align: justify; width: auto;\\">It\\''s main components are  Smarty - a template engine, PHP Data Objects (PDO) extension to manage  the MySQL database connection, JQuery for JavaScript functionalities,  and FCKeditor - the WYSIWYG content editing tool. It supports page  caching, publishing of blogs, articles, and searching for contents. It  is designed to be simple, robust, flexible, scalable, portable, secured  and search engine optimized witha rich PHP function and class library.</p>\r\n<div style=\\"width: 98%;\\">\r\n<h3>System Requirements</h3>\r\n<div>\r\n<ul>\r\n    <ul>\r\n        <li>Windows/Linux/MAC Operating System Server</li>\r\n    </ul>\r\n    <ul>\r\n        <li>PHP  5.0 or higher</li>\r\n    </ul>\r\n    <ul>\r\n        <li>MySQL Sever(default)</li>\r\n    </ul>\r\n    <ul>\r\n        <li>All  modern Web browsers with JavaScript support enabled</li>\r\n    </ul>\r\n</ul>\r\n</div>\r\n<h3>Features</h3>\r\n<p><strong>Document management: </strong><br />\r\nIt can provide a means of managing the life cycle of a document from  initial creation time, through revisions, publication and document  destruction.<br />\r\n<br />\r\n<strong>Workflow management:</strong><br />\r\nWorkflow is the process of creating cycles of sequential and parallel  tasks that must be accomplished in the CMS. ArticulateCMS has an admin  panel that takes care of the work flow management.<br />\r\n<br />\r\n<strong>Web standards upgrades:</strong></p>\r\n<p>Each individual component can be updated regularly that include new  feature sets and keep the system up to current web standards.</p>\r\n<p><strong>Scalable feature sets:</strong><br />\r\nPlug-ins or modules can be easily installed to extend an existing site\\''s  functionality.</p>\r\n<p><strong>Easily editable content:</strong><br />\r\nContent is separate from the visual presentation, and so it is easier  and quicker to edit and manipulate. It includes a WYSIWYG editing tool,  FCK editor allowing non-technical individuals to create and edit  content.</p>\r\n<p><strong>Versatile database support: </strong><br />\r\nArticulateCMS supports the use of any database engine by virtue of the  use of PDO extension. For example, SQLite, Oracle etc.</p>\r\n<p><strong>Search Engine optimized URL:</strong><br />\r\nAll URLs in ArticulateCMS are search engine optimized.</p>\r\n</div>', 'ArticulateCMS is a simple text-based Open Source Content Management System platform powered by ArticulatePHP framework and MySQL database engine', 'Articulate CMS, Content Management System, platform , publishing, text, contents, search engine optimization,pdo, seo, php framework, mysql, simple design, admin panel, secured, user friendly, caching', 0, 0, '2010-03-11 04:33:30', '2015-03-10 08:50:54', 0),
(2, 1, 1, 'lorem_Ipsum', 'Lorem Ipsum', '', '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.&lt;/p&gt;\r\n&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim  veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea  commodo consequat. Duis aute irure dolor in reprehenderit in voluptate  velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint  occaecat cupidatat non proident, sunt in culpa qui officia deserunt  mollit anim id est laborum.&lt;/p&gt;', '', '', 0, 0, '2010-03-11 04:36:04', '2015-03-10 08:50:54', 0),
(3, 1, 1, 'test', 'A title for this article would be This', 'A nice subtitle', '&lt;h1&gt;&amp;nbsp;This is a disaster&lt;/h1&gt;\r\n&lt;p&gt;We tried to work our way throught this mess but we realised that there has been a commotion in the house and a lot of things were stolen. We are very for the loss. It\\''s been a while and there were many visitors here in last few days. This is very upsetting, and yet we are hopeful that thing will get sorted out by itself.&lt;/p&gt;\r\n&lt;p&gt;Regards&lt;/p&gt;', '', '', 0, 0, '2015-02-16 17:37:20', '2015-03-10 08:50:56', 0),
(6, 1, 2, 'ArtWebApp', 'My Baby Dragon', 'Dragon snaps', '&lt;div class=&quot;f kv _SWb&quot; style=&quot;color: rgb(128, 128, 128); height: 17px; line-height: 16px; font-family: arial, sans-serif; font-size: small; white-space: nowrap;&quot;&gt;&lt;cite class=&quot;_Rm&quot; style=&quot;color: rgb(0, 102, 33); font-style: normal; font-size: 14px;&quot;&gt;www.cricbuzz.com/...&lt;b&gt;cricket&lt;/b&gt;.../ban-&lt;b&gt;vs&lt;/b&gt;-afg-7th-match-pool-a-icc-&lt;b&gt;cricket&lt;/b&gt;-...&lt;/cite&gt;\r\n&lt;div class=&quot;action-menu ab_ctl&quot; style=&quot;display: inline; position: relative; margin: 0px 3px; vertical-align: middle; -webkit-user-select: none;&quot;&gt;&lt;a class=&quot;_Fmb ab_button&quot; href=&quot;https://www.google.com.bd/search?q=Afghanistan+vs+Bangladesh+cricket&amp;amp;hl=en&amp;amp;ei=vS7jVPSlPIadugT9vYDwCA#&quot; id=&quot;am-b4&quot; aria-label=&quot;Result details&quot; aria-expanded=&quot;false&quot; aria-haspopup=&quot;true&quot; role=&quot;button&quot; jsaction=&quot;ab.tdd;keydown:ab.hbke;keypress:ab.mskpe&quot; data-ved=&quot;0CCsQ7B0wBA&quot; style=&quot;border-radius: 0px; cursor: default; font-size: 11px; font-weight: bold; height: 12px; line-height: 27px; margin: 0px; min-width: 0px; padding: 0px; text-align: center; -webkit-transition: none; transition: none; -webkit-user-select: none; border: 0px; color: rgb(128, 128, 128); box-shadow: 0px 0px 0px 0px; filter: none; width: 13px; text-decoration: none; display: inline-block; background-image: none;&quot;&gt;&lt;/a&gt;\r\n&lt;div class=&quot;action-menu-panel ab_dropdown&quot; role=&quot;menu&quot; tabindex=&quot;-1&quot; jsaction=&quot;keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue&quot; data-ved=&quot;0CCwQqR8wBA&quot; style=&quot;border: 1px solid rgba(0, 0, 0, 0.2); font-size: 13px; padding: 0px; position: absolute; right: auto; top: 12px; z-index: 3; -webkit-transition: opacity 0.218s; transition: opacity 0.218s; -webkit-box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; left: 0px; visibility: hidden; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;&quot;&gt;\r\n&lt;ul style=&quot;margin: 0px; padding: 0px; border: 0px;&quot;&gt;\r\n    &lt;li class=&quot;action-menu-item ab_dropdownitem&quot; role=&quot;menuitem&quot; style=&quot;line-height: 1.2; margin: 0px; padding: 0px; border: 0px; list-style: none; -webkit-user-select: none; cursor: pointer;&quot;&gt;&amp;nbsp;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;f slp&quot; style=&quot;color: rgb(128, 128, 128); font-family: arial, sans-serif; font-size: small; line-height: 18px;&quot;&gt;&amp;nbsp;&lt;/div&gt;\r\n&lt;p&gt;&lt;span class=&quot;st&quot; style=&quot;line-height: 1.4; word-wrap: break-word; color: rgb(84, 84, 84); font-family: arial, sans-serif; font-size: small;&quot;&gt;&lt;span class=&quot;f&quot; style=&quot;color: rgb(128, 128, 128);&quot;&gt;32 mins ago -&amp;nbsp;&lt;/span&gt;Follow&amp;nbsp;&lt;span style=&quot;font-weight: bold;&quot;&gt;Bangladesh vs Afghanistan&lt;/span&gt;, 7th Match, Pool A at Canberra with live&amp;nbsp;&lt;span style=&quot;font-weight: bold;&quot;&gt;Cricket&lt;/span&gt;&amp;nbsp;score, ball by ball commentary, highlights, updates&amp;nbsp;...&lt;/span&gt;&lt;/p&gt;\r\n&lt;div class=&quot;_cwc&quot; data-ved=&quot;0CC8QpwYwBA&quot; style=&quot;color: rgb(102, 102, 102); display: table; white-space: nowrap; margin: 5px 0px; font-family: arial, sans-serif; font-size: small; line-height: 18px;&quot;&gt;\r\n&lt;div class=&quot;_sgd&quot; style=&quot;display: table-row; vertical-align: top;&quot;&gt;\r\n&lt;div class=&quot;_qgd&quot; style=&quot;display: table-cell;&quot;&gt;Wed, Feb 18&lt;/div&gt;\r\n&lt;div class=&quot;_pgd&quot; title=&quot;Bangladesh vs Afghanistan, 7th Match Pool A , ICC Cricket World Cup 2015&quot; data-ved=&quot;0CDAQrwYoADAE&quot; style=&quot;display: table-cell; padding-left: 15px; vertical-align: top;&quot;&gt;&lt;a class=&quot;fl&quot; href=&quot;http://www.cricbuzz.com/live-cricket-scores/12861/ban-vs-afg-7th-match-pool-a-icc-cricket-world-cup-2015&quot; style=&quot;text-decoration: none; color: rgb(26, 13, 171); cursor: pointer;&quot;&gt;Bangladesh vs Afghanistan ...&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=&quot;_pgd&quot; style=&quot;display: table-cell; padding-left: 15px; vertical-align: top;&quot;&gt;\r\n&lt;p&gt;:&lt;/p&gt;\r\n&lt;p&gt;Manuka Oval, Canberra&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;www.cricbuzz.com/...&lt;/span&gt;&lt;b style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;cricket&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;.../ban-&lt;/span&gt;&lt;b style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;vs&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;-afg-7th-match-pool-a-icc-&lt;/span&gt;&lt;b style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;cricket&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;-...&lt;/span&gt;&lt;/p&gt;\r\n&lt;div class=&quot;f kv _SWb&quot; style=&quot;color: rgb(128, 128, 128); height: 17px; line-height: 16px;&quot;&gt;\r\n&lt;div class=&quot;action-menu ab_ctl&quot; style=&quot;display: inline; position: relative; margin: 0px 3px; vertical-align: middle; -webkit-user-select: none;&quot;&gt;&lt;a class=&quot;_Fmb ab_button&quot; href=&quot;https://www.google.com.bd/search?q=Afghanistan+vs+Bangladesh+cricket&amp;amp;hl=en&amp;amp;ei=vS7jVPSlPIadugT9vYDwCA#&quot; id=&quot;am-b4&quot; aria-label=&quot;Result details&quot; aria-expanded=&quot;false&quot; aria-haspopup=&quot;true&quot; role=&quot;button&quot; jsaction=&quot;ab.tdd;keydown:ab.hbke;keypress:ab.mskpe&quot; data-ved=&quot;0CCsQ7B0wBA&quot; style=&quot;border-radius: 0px; cursor: default; font-size: 11px; font-weight: bold; height: 12px; line-height: 27px; margin: 0px; min-width: 0px; padding: 0px; text-align: center; -webkit-transition: none; transition: none; -webkit-user-select: none; border: 0px; color: rgb(128, 128, 128); box-shadow: 0px 0px 0px 0px; filter: none; width: 13px; text-decoration: none; display: inline-block; background-image: none;&quot;&gt;&lt;/a&gt;\r\n&lt;div class=&quot;action-menu-panel ab_dropdown&quot; role=&quot;menu&quot; tabindex=&quot;-1&quot; jsaction=&quot;keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue&quot; data-ved=&quot;0CCwQqR8wBA&quot; style=&quot;border: 1px solid rgba(0, 0, 0, 0.2); font-size: 13px; padding: 0px; position: absolute; right: auto; top: 12px; z-index: 3; -webkit-transition: opacity 0.218s; transition: opacity 0.218s; -webkit-box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; left: 0px; visibility: hidden; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;&quot;&gt;\r\n&lt;ul style=&quot;margin: 0px; padding: 0px; border: 0px;&quot;&gt;\r\n    &lt;li class=&quot;action-menu-item ab_dropdownitem&quot; role=&quot;menuitem&quot; style=&quot;line-height: 1.2; margin: 0px; padding: 0px; border: 0px; list-style: none; -webkit-user-select: none; cursor: pointer;&quot;&gt;&amp;nbsp;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;f slp&quot; style=&quot;color: rgb(128, 128, 128); white-space: normal;&quot;&gt;&amp;nbsp;&lt;/div&gt;\r\n&lt;span class=&quot;st&quot; style=&quot;line-height: 1.4; word-wrap: break-word; color: rgb(84, 84, 84); white-space: normal;&quot;&gt;&lt;span class=&quot;f&quot; style=&quot;color: rgb(128, 128, 128);&quot;&gt;32 mins ago -&amp;nbsp;&lt;/span&gt;Follow&amp;nbsp;&lt;span style=&quot;font-weight: bold;&quot;&gt;Bangladesh vs Afghanistan&lt;/span&gt;, 7th Match, Pool A at Canberra with live&amp;nbsp;&lt;span style=&quot;font-weight: bold;&quot;&gt;Cricket&lt;/span&gt;&amp;nbsp;score, ball by ball commentary, highlights, updates&amp;nbsp;...&lt;/span&gt;\r\n&lt;div class=&quot;_cwc&quot; data-ved=&quot;0CC8QpwYwBA&quot; style=&quot;display: table; margin: 5px 0px;&quot;&gt;\r\n&lt;div class=&quot;_sgd&quot; style=&quot;display: table-row; vertical-align: top;&quot;&gt;\r\n&lt;div class=&quot;_qgd&quot; style=&quot;display: table-cell;&quot;&gt;Wed, Feb 18&lt;/div&gt;\r\n&lt;div class=&quot;_pgd&quot; title=&quot;Bangladesh vs Afghanistan, 7th Match Pool A , ICC Cricket World Cup 2015&quot; data-ved=&quot;0CDAQrwYoADAE&quot; style=&quot;display: table-cell; padding-left: 15px; vertical-align: top;&quot;&gt;&lt;a class=&quot;fl&quot; href=&quot;http://www.cricbuzz.com/live-cricket-scores/12861/ban-vs-afg-7th-match-pool-a-icc-cricket-world-cup-2015&quot; style=&quot;text-decoration: none; color: rgb(26, 13, 171); cursor: pointer;&quot;&gt;Bangladesh vs Afghanistan ...&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=&quot;_pgd&quot; style=&quot;display: table-cell; padding-left: 15px; vertical-align: top;&quot;&gt;: Manuka Oval, Canberra&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;www.cricbuzz.com/...&lt;/span&gt;&lt;b style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;cricket&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;.../ban-&lt;/span&gt;&lt;b style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;vs&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;-afg-7th-match-pool-a-icc-&lt;/span&gt;&lt;b style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;cricket&lt;/b&gt;&lt;span style=&quot;color: rgb(0, 102, 33); font-size: 14px; line-height: 16px;&quot;&gt;-...&lt;/span&gt;\r\n&lt;div class=&quot;f kv _SWb&quot; style=&quot;color: rgb(128, 128, 128); height: 17px; line-height: 16px;&quot;&gt;\r\n&lt;div class=&quot;action-menu ab_ctl&quot; style=&quot;display: inline; position: relative; margin: 0px 3px; vertical-align: middle; -webkit-user-select: none;&quot;&gt;&lt;a class=&quot;_Fmb ab_button&quot; href=&quot;https://www.google.com.bd/search?q=Afghanistan+vs+Bangladesh+cricket&amp;amp;hl=en&amp;amp;ei=vS7jVPSlPIadugT9vYDwCA#&quot; id=&quot;am-b4&quot; aria-label=&quot;Result details&quot; aria-expanded=&quot;false&quot; aria-haspopup=&quot;true&quot; role=&quot;button&quot; jsaction=&quot;ab.tdd;keydown:ab.hbke;keypress:ab.mskpe&quot; data-ved=&quot;0CCsQ7B0wBA&quot; style=&quot;border-radius: 0px; cursor: default; font-size: 11px; font-weight: bold; height: 12px; line-height: 27px; margin: 0px; min-width: 0px; padding: 0px; text-align: center; -webkit-transition: none; transition: none; -webkit-user-select: none; border: 0px; color: rgb(128, 128, 128); box-shadow: 0px 0px 0px 0px; filter: none; width: 13px; text-decoration: none; display: inline-block; background-image: none;&quot;&gt;&lt;/a&gt;\r\n&lt;div class=&quot;action-menu-panel ab_dropdown&quot; role=&quot;menu&quot; tabindex=&quot;-1&quot; jsaction=&quot;keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue&quot; data-ved=&quot;0CCwQqR8wBA&quot; style=&quot;border: 1px solid rgba(0, 0, 0, 0.2); font-size: 13px; padding: 0px; position: absolute; right: auto; top: 12px; z-index: 3; -webkit-transition: opacity 0.218s; transition: opacity 0.218s; -webkit-box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; box-shadow: rgba(0, 0, 0, 0.2) 0px 2px 4px; left: 0px; visibility: hidden; background-image: initial; background-attachment: initial; background-size: initial; background-origin: initial; background-clip: initial; background-position: initial; background-repeat: initial;&quot;&gt;\r\n&lt;ul style=&quot;margin: 0px; padding: 0px; border: 0px;&quot;&gt;\r\n    &lt;li class=&quot;action-menu-item ab_dropdownitem&quot; role=&quot;menuitem&quot; style=&quot;line-height: 1.2; margin: 0px; padding: 0px; border: 0px; list-style: none; -webkit-user-select: none; cursor: pointer;&quot;&gt;&amp;nbsp;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;div class=&quot;f slp&quot; style=&quot;color: rgb(128, 128, 128); white-space: normal;&quot;&gt;&amp;nbsp;&lt;/div&gt;\r\n&lt;span class=&quot;st&quot; style=&quot;line-height: 1.4; word-wrap: break-word; color: rgb(84, 84, 84); white-space: normal;&quot;&gt;&lt;span class=&quot;f&quot; style=&quot;color: rgb(128, 128, 128);&quot;&gt;32 mins ago -&amp;nbsp;&lt;/span&gt;Follow&amp;nbsp;&lt;span style=&quot;font-weight: bold;&quot;&gt;Bangladesh vs Afghanistan&lt;/span&gt;, 7th Match, Pool A at Canberra with live&amp;nbsp;&lt;span style=&quot;font-weight: bold;&quot;&gt;Cricket&lt;/span&gt;&amp;nbsp;score, ball by ball commentary, highlights, updates&amp;nbsp;...&lt;/span&gt;\r\n&lt;div class=&quot;_cwc&quot; data-ved=&quot;0CC8QpwYwBA&quot; style=&quot;display: table; margin: 5px 0px;&quot;&gt;\r\n&lt;div class=&quot;_sgd&quot; style=&quot;display: table-row; vertical-align: top;&quot;&gt;\r\n&lt;div class=&quot;_qgd&quot; style=&quot;display: table-cell;&quot;&gt;Wed, Feb 18&lt;/div&gt;\r\n&lt;div class=&quot;_pgd&quot; title=&quot;Bangladesh vs Afghanistan, 7th Match Pool A , ICC Cricket World Cup 2015&quot; data-ved=&quot;0CDAQrwYoADAE&quot; style=&quot;display: table-cell; padding-left: 15px; vertical-align: top;&quot;&gt;&lt;a class=&quot;fl&quot; href=&quot;http://www.cricbuzz.com/live-cricket-scores/12861/ban-vs-afg-7th-match-pool-a-icc-cricket-world-cup-2015&quot; style=&quot;text-decoration: none; color: rgb(26, 13, 171); cursor: pointer;&quot;&gt;Bangladesh vs Afghanistan ...&lt;/a&gt;&lt;/div&gt;\r\n&lt;div class=&quot;_pgd&quot; style=&quot;display: table-cell; padding-left: 15px; vertical-align: top;&quot;&gt;: Manuka Oval, Canberra&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;', '', '', 0, 0, '2015-02-17 13:17:50', '2015-03-10 08:50:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(11) NOT NULL,
  `catname` varchar(50) NOT NULL,
  `mtype` int(11) NOT NULL,
  `date_inserted` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `catname`, `mtype`, `date_inserted`, `date_updated`, `state`) VALUES
(1, 'Page', 1, '2010-03-11 04:32:01', '2015-03-10 09:05:39', 0),
(2, 'Children', 1, '2015-02-16 17:30:40', '2015-03-10 08:50:35', 0),
(3, 'Horror', 1, '2015-02-16 17:33:16', '2015-03-10 08:50:39', 0),
(4, 'Old days', 1, '2015-02-16 17:33:51', '2015-03-10 08:50:42', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `date_ofbirth` date DEFAULT NULL,
  `validator` varchar(42) DEFAULT NULL,
  `utype` int(11) NOT NULL,
  `ustatus` int(11) NOT NULL,
  `date_lastlogin` datetime DEFAULT NULL,
  `date_inserted` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `state` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `firstname`, `lastname`, `gender`, `date_ofbirth`, `validator`, `utype`, `ustatus`, `date_lastlogin`, `date_inserted`, `date_updated`, `state`) VALUES
(1, 'admin', 'admin', 'admin', 'user', 'm', '2010-03-01', '632667547e7cd3e0466547863e1207a8c0c0c549', 1, 1, '2015-03-09 18:36:14', '2010-03-11 04:22:24', '2010-03-11 04:22:24', 0),
(2, 'tasneem@bitmascot.com', '123456', 's', 'sfgfsg', 'm', '2015-02-17', 'be461a0cd1fda052a69c3fd94f8cf5f6f86afa34', 0, 1, '2015-02-17 14:15:34', '2015-02-17 13:26:04', '2015-03-10 09:05:14', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `em_index` (`url`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `em_index` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
