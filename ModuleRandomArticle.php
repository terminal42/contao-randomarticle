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
 * @version    $Id$
 */

 
class ModuleRandomArticle extends Module
{
	/**
	 * Tempalte
	 */
	protected $strTemplate = 'mod_randomarticle';


	public function generate()
	{		
		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### RANDOM ARTICLE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = $this->Environment->script.'?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}
		
		if (!file_exists(TL_ROOT . '/system/modules/frontend/ModuleArticle.php'))
		{
			$this->log('Class ModuleArticle does not exist', 'ModuleRandomArticle compile()', TL_ERROR);
			return '';
		}

		return parent::generate();
	}


	/**
	 * Generate module
	 */
	protected function compile()
	{
		global $objPage;
		
		if (!strlen($this->inColumn))
		{
			$this->inColumn = 'main';
		}
		
		switch( $this->randomArticle )
		{
			// Keep the whole session
			case '2':
				if ($_SESSION['MOD_RANDOMARTICLE'][$this->id]['article'] > 0)
				{
					$objArticle = $this->Database->prepare("SELECT tl_article.*, tl_page.id AS page_id, tl_page.alias AS page_alias FROM tl_article LEFT OUTER JOIN tl_page ON tl_article.pid=tl_page.id WHERE tl_article.id=?")
												 ->limit(1)
												 ->execute($_SESSION['MOD_RANDOMARTICLE'][$this->id]['article']);
												 
					break;
				}
				
			// Keep a number of times
			case '1':
				if ($_SESSION['MOD_RANDOMARTICLE'][$this->id]['article'] > 0 && $this->keepArticle > 0 && $this->keepArticle > $_SESSION['MOD_RANDOMARTICLE'][$this->id]['count'])
				{
					$objArticle = $this->Database->prepare("SELECT tl_article.*, tl_page.id AS page_id, tl_page.alias AS page_alias FROM tl_article LEFT OUTER JOIN tl_page ON tl_article.pid=tl_page.id WHERE tl_article.id=?")
												 ->limit(1)
												 ->execute($_SESSION['MOD_RANDOMARTICLE'][$this->id]['article']);
					break;
				}
			
			default:
				$_SESSION['MOD_RANDOMARTICLE'][$this->id]['count'] = 0;
				$objArticle = $this->Database->prepare("SELECT tl_article.*, tl_page.id AS page_id, tl_page.alias AS page_alias FROM tl_article LEFT OUTER JOIN tl_page ON tl_article.pid=tl_page.id WHERE tl_article.pid=? AND tl_article.inColumn=? " . ((is_array($GLOBALS['RANDOMARTICLES']) && count($GLOBALS['RANDOMARTICLES'])) ? ' AND tl_article.id NOT IN (' . implode(',', $GLOBALS['RANDOMARTICLES']) . ') ' : '') . "AND (tl_article.start=? OR tl_article.start<?) AND (tl_article.stop=? OR tl_article.stop>?)" . (!BE_USER_LOGGED_IN ? ' AND tl_article.published=?' : '') . " ORDER BY RAND()")
											 ->limit(1)
											 ->execute($this->rootPage, $this->inColumn, '', time(), '', time(), 1);
		}


		if ($objArticle->numRows < 1)
		{
			return;
		}
		
		$_SESSION['MOD_RANDOMARTICLE'][$this->id]['article'] = $objArticle->id;
		$_SESSION['MOD_RANDOMARTICLE'][$this->id]['count'] = strlen($_SESSION['MOD_RANDOMARTICLE'][$this->id]['count']) ? ($_SESSION['MOD_RANDOMARTICLE'][$this->id]['count']+1) : 1;
		$GLOBALS['RANDOMARTICLES'][] = $objArticle->id;

		// Print article as PDF
		if ($this->Input->get('pdf') == $objArticle->id)
		{
			$this->printArticleAsPdf($objArticle);
		}

		$objArticle->headline = $objArticle->title;
		$objArticle->showTeaser = $this->showTeaser;
		$objArticle->multiMode = $this->showTeaser ? true : false;

		$objArticle = new ModuleArticle($objArticle, $this->inColumn);
		$objArticle->cssID = $this->cssID;
		$objArticle->space = $this->space;
		
		// Overwrite article url
		$pageAlias = $objPage->alias;
		$pageId = $objPage->id;
		$objPage->alias = $objArticle->page_alias;
		$objPage->id = $objArticle->page_id;
		
		// Parse article
		$this->Template->article = $objArticle->generate();
		
		// Reset page options
		$objPage->alias = $pageAlias;
		$objPage->id = $pageId;
	}
}

 