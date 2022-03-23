<?php

namespace App\Block;

use App\Repository\TimeRegisterRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class VisualizationBlockService extends AbstractBlockService
{
    private TimeRegisterRepository $timeRegisterRepository;

    public function __construct(Environment $twig, TimeRegisterRepository $timeRegisterRepository)
    {
        parent::__construct($twig);
        $this->timeRegisterRepository = $timeRegisterRepository;
    }

    public function configureSettings(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'url' => false,
            'title' => 'Insert the rss title',
            'template' => 'admin/block/visualization.html.twig',
        ]);
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null): Response
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $data = $this->timeRegisterRepository->getTotalHoursGroupedByInvoiceableAndDate();
        $weeklyData = $this->timeRegisterRepository->getTotalHoursInvoiceableGroupedByWeek();

        $backgroundColor = 'bg-green';
        $content = '<h3><i class="fa fa-check-circle-o" aria-hidden="true"></i></h3><p>Aquí hi anirà un gràfic de barres</p>';

        return $this->renderResponse(
            $blockContext->getTemplate(),
            array(
                'block' => $blockContext->getBlock(),
                'settings' => $settings,
                'title' => 'Notificacions',
                'background' => $backgroundColor,
                'content' => $content,
                'data' => $data,
                'weeklyData' => $weeklyData
            ),
            $response
        );
    }
}
