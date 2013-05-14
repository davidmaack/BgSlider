<?php

/**
 * BgSlider
 *
 * A mootools based fullscreen background slider with fade effect for Contao 3.
 *
 * @copyright 4ward.media 2012 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 * @licence LGPL
 */


class BgSlider extends Module
{

	protected $strTemplate = 'mod_BgSlider';


	/**
	 * Generate the BgSlider
	 *
	 * @return string
	 */
	public function generate()
	{

		if (TL_MODE == 'BE')
		{
			$objTemplate = new BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### BG Slider ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = $this->Environment->script.'?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		$this->multiSRC = deserialize($this->multiSRC);
		// Return if there are no files
		if (!is_array($this->multiSRC) || empty($this->multiSRC))
		{
			return '';
		}

		return parent::generate();
	}


	/**
	 * Compile the current element
	 */
	protected function compile()
	{

		// add ID and cssClass to the script
		if(!is_array($this->cssID)) $this->cssID = array('','');
		$this->Template->domID = $this->cssID[0];
		$this->Template->cssClass = $this->cssID[1];

		$images = array();
		$objFiles = $this->objFiles;

		// Get all images
		foreach ($this->multiSRC as $strFile)
		{
			// Continue if the files has been processed or does not exist
			if (isset($images[$strFile]) || !file_exists(TL_ROOT . '/' . $strFile))
			{
				continue;
			}
            
            //folders
            if (is_dir(TL_ROOT . '/' . $strFile))
            {
                $arrSubfiles = scan(TL_ROOT. '/'. $strFile);
                
				if (empty($arrSubfiles))
				{
					continue;
				}

				foreach ($arrSubfiles as $subFile)
				{
					// Skip subfolders
					if (is_dir(TL_ROOT . '/'. $strFile . '/' . $subFile))
					{
						continue;
					}

					$objFile = new File( $strFile . '/' . $subFile);
                    
					if (!$objFile->isGdImage)
					{
						continue;
					}

					// Add the image
					$images[$strFile . '/' . $subFile] = array('path'=>$strFile . '/' . $subFile, 'name'=>$objFile->basename, 'height'=>$objFile->height, 'width'=>$objFile->width);
				}
            }
            //Files
            else
            {
                $objFile = new File($strFile);

				if (!$objFile->isGdImage)
				{
					continue;
				}

				// Add the image
                $images[$strFile] = array('path'=>$strFile , 'name'=>$objFile->basename, 'height'=>$objFile->height, 'width'=>$objFile->width);
            }

		}
        
        // change keys to int;
        foreach($images as $img)
		{
			$tmp = array_pop($images);
			array_unshift($images, $tmp);
		}

		// move the image with the alias to the front
		foreach($images as $img)
		{
			$tmp = array_pop($images);
			array_unshift($images, $tmp);
			if(preg_match("~".preg_quote($GLOBALS['objPage']->alias)."\.[a-z]+$~", $tmp['path']))
			{
				break;
			}
		}
        
		$this->Template->images = $images;
	}
}