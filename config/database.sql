-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `showTeaser` char(1) NOT NULL default '',
  `randomArticle` char(1) NOT NULL default '',
  `keepArticle` varchar(3) NOT NULL default '',
  `numberOfArticles` smallint(5) unsigned NOT NULL default '1',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

