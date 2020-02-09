<?php

namespace Concrete\Core\Page\Theme\GridFramework\Type;

use Concrete\Core\Block\Block;
use Concrete\Core\Page\Theme\GridFramework\GridFramework;
use Illuminate\Support\Str;

class Bootstrap3 extends GridFramework
{

    const GRID_CONTAINER_FIXED = 1;
    const GRID_CONTAINER_FLUID = 2;

    public function supportsNesting()
    {
        return true;
    }

    public function getPageThemeGridFrameworkName()
    {
        return t('Twitter Bootstrap');
    }

    public function getPageThemeGridFrameworkRowStartHTML()
    {
        return '<div class="row">';
    }

    public function getPageThemeGridFrameworkRowEndHTML()
    {
        return '</div>';
    }

    public function getGridFrameworkContainerTypes(): array
    {
        return [
            self::GRID_CONTAINER_DISABLED => t('No grid container'),
            self::GRID_CONTAINER_FIXED => t('Fixed width'),
            self::GRID_CONTAINER_FLUID => t('Fluid width'),
        ];
    }

    /**
     * @param int $gridContainerOption
     * @param \Concrete\Core\Block\Block|\Concrete\Core\Block\BlockType\BlockType $block
     * @return string
     */
    public function getPageThemeGridFrameworkContainerStartHTML(int $gridContainerOption, $block)
    {
        if ($gridContainerOption == self::GRID_CONTAINER_FLUID) {
            $container = 'container-fluid';
        } elseif ($gridContainerOption == self::GRID_CONTAINER_FIXED) {
            $container = 'container';
        } else {
            $container = '';
        }

        $blockType = 'ccm-block-type-' . Str::slug($block->getBlockTypeHandle());
        if ($block instanceof Block && $block->getBlockFilename()) {
            // Add template class if the block has a custom template.
            $template = pathinfo($block->getBlockFilename(), PATHINFO_FILENAME);
            $template = ' ccm-block-template-' . Str::slug($template);
        } else {
            $template = '';
        }
        return "<div class=\"{$container} {$blockType}{$template}\">";
    }

    /**
     * @param int $gridContainerOption
     * @param \Concrete\Core\Block\Block|\Concrete\Core\Block\BlockType\BlockType $block
     * @return string
     */
    public function getPageThemeGridFrameworkContainerEndHTML(int $gridContainerOption, $block)
    {
        return '</div>';
    }

    public function getPageThemeGridFrameworkColumnClasses()
    {
        $columns = array(
            'col-sm-1',
            'col-sm-2',
            'col-sm-3',
            'col-sm-4',
            'col-sm-5',
            'col-sm-6',
            'col-sm-7',
            'col-sm-8',
            'col-sm-9',
            'col-sm-10',
            'col-sm-11',
            'col-sm-12',
        );

        return $columns;
    }

    public function getPageThemeGridFrameworkColumnOffsetClasses()
    {
        $offsets = array(
            'col-sm-offset-1',
            'col-sm-offset-2',
            'col-sm-offset-3',
            'col-sm-offset-4',
            'col-sm-offset-5',
            'col-sm-offset-6',
            'col-sm-offset-7',
            'col-sm-offset-8',
            'col-sm-offset-9',
            'col-sm-offset-10',
            'col-sm-offset-11',
            'col-sm-offset-12',
        );

        return $offsets;
    }

    public function getPageThemeGridFrameworkColumnAdditionalClasses()
    {
        return '';
    }

    public function getPageThemeGridFrameworkColumnOffsetAdditionalClasses()
    {
        return '';
    }

    public function getPageThemeGridFrameworkHideOnExtraSmallDeviceClass()
    {
        return 'hidden-xs';
    }

    public function getPageThemeGridFrameworkHideOnSmallDeviceClass()
    {
        return 'hidden-sm';
    }

    public function getPageThemeGridFrameworkHideOnMediumDeviceClass()
    {
        return 'hidden-md';
    }

    public function getPageThemeGridFrameworkHideOnLargeDeviceClass()
    {
        return 'hidden-lg';
    }
}
