<?php

namespace Test\HomeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class HomeBundle extends Bundle
{
    public function boot() {
        parent::boot();
        
        $router = $this->container->get('router');
        $eventDispatcher = $this->container->get('event_dispatcher');
        
        $eventDispatcher->addListener(
            SitemapPopulateEvent::onSitemapPopulate,
            function (SitemapPopulateEvent $event) use ($router) {
                $url = $router->generate('somepage', array('name' => 'Master'), true);
                
                $event->getGenerator()->addUrl(
                    new UrlConcrete(
                        $url,
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );
            }
        );
    }
}
