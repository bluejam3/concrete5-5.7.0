<?php

namespace Concrete\Core\Asset;

use URL;
use Localization;

class JavascriptLocalizedAsset extends JavascriptAsset
{
    /**
     * @var bool
     */
    protected $assetSupportsMinification = false;

    /**
     * @return string
     */
    public function getAssetType()
    {
        return 'javascript-localized';
    }

    public function getOutputAssetType()
    {
        return 'javascript';
    }

    public function getAssetURL()
    {
        return (string) URL::to($this->assetURL);
    }

    /**
     * @return string
     */
    public function getAssetHashKey()
    {
        return $this->assetURL.'::'.Localization::activeLocale();
    }

    public function isAssetLocal()
    {
        return false;
    }

    /**
     * @return string|null
     */
    public function getAssetContents()
    {
        return parent::getAssetContentsByRoute($this->assetURL);
    }
}
