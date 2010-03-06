<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Andreas Schempp 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['randomArticle']			= array('Zufallsmodus', 'Diese Einstellung gilt pro Modul und pro Besucher.');
$GLOBALS['TL_LANG']['tl_module']['keepArticle']				= array('Artikel beibehalten', 'Geben Sie an wie viele Seitenaufrufe derselbe Artikel gezeigt werden soll.');
$GLOBALS['TL_LANG']['tl_module']['showTeaser']				= array('Teasertext anzeigen', 'Den Teasertext anstatt des Artikels gefolgt von einem "Weiterlesen..." Link anzeigen.');


/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_module']['randomArticle_ref']['']	= 'Bei jedem Seitenaufruf einen Artikel zufällig auswählen';
$GLOBALS['TL_LANG']['tl_module']['randomArticle_ref']['1']	= 'Den Zufallsartikel für eine Anzahl Seitenaufrufe beibehalten';
$GLOBALS['TL_LANG']['tl_module']['randomArticle_ref']['2']	= 'Denselben Artikel während der gesamten Session beibehalten';