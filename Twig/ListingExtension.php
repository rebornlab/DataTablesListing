<?php

/**
 * Created by PhpStorm.
 * User: pawel
 * Date: 22.07.14
 * Time: 09:25
 */

namespace PawelLen\DataTablesListing\Twig;

use PawelLen\DataTablesListing\ListingView;
use PawelLen\DataTablesListing\Renderer\ListingRendererInterface;


class ListingExtension extends \Twig_Extension
{

    /**
     * @var \Twig_Environment
     */
    protected $environment;

    /**
     * @var ListingRendererInterface
     */
    protected $renderer;



    /**
     * @param ListingRendererInterface $renderer
     */
    public function __construct(ListingRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }


    /**
     * @param \Twig_Environment $environment
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
        $this->renderer->initRuntime($environment);
    }


    /**
     * @return array|\Twig_Function[]
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('render_listing', array($this, 'renderListing'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('render_listing_assets', array($this, 'renderListingAssets'), array('is_safe' => array('html'))),
        );
    }



    /**
     * @param ListingView $listingView
     * @return string
     */
    public function renderListing(ListingView $listingView, $template = null)
    {
        $this->renderer->load($template ?: $listingView->getTemplateReference());
        return $this->renderer->renderListing($listingView);
    }


    /**
     * @return string
     */
    public function renderListingAssets()
    {
        static $isRendered = false;

        if (!$isRendered) {
            $isRendered = true;

            return $this->renderer->renderListingAssets();
        }

        return '<!-- Listing assets already rendered -->';
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'listing_extension';
    }

}
