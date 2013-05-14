-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `BgSlider_slideTime` int(9) unsigned NOT NULL default '0',
  `BgSlider_waitTime` int(9) unsigned NOT NULL default '0',
  `BgSlider_showNav` char(1) NOT NULL default '',
  `BgSlider_autoplay` char(1) NOT NULL default '1',
  `BgSlider_slideAfterLoad` char(1) NOT NULL default '1',
  `BgSlider_proportional` char(1) NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
