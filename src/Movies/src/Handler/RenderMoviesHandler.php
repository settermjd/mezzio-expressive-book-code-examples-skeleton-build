<?php

namespace Movies\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Router\RouterInterface;
use Mezzio\Template\TemplateRendererInterface;
use Movies\Services\Database\MovieTable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class RenderMoviesHandler
 * @package Movies\Middleware
 */
class RenderMoviesHandler implements RequestHandlerInterface
{
    /**
     * @var array|\Traversable
     */
    private $movieData;

    /** @var RouterInterface  */
    private $router;

    /** @var TemplateRendererInterface  */
    private $template;

    /**
     * RenderMoviesHandler constructor.
     * @param $movieData
     * @param RouterInterface $router
     * @param TemplateRendererInterface $template
     */
    public function __construct(
        MovieTable $movieData,
        RouterInterface $router,
        TemplateRendererInterface $template
    ) {
        $this->movieData = $movieData;
        $this->router   = $router;
        $this->template = $template;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $data = [
            'movies' => $this->movieData->fetchAll()
        ];

        $html = $this->template->render(
            'movies::render-movies',
            $data
        );

        return new HtmlResponse($html);
    }
}
