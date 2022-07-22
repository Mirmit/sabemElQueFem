<?php

namespace App\Block;

use App\Enum\UserRolesEnum;
use App\Repository\TimeRegisterRepository;
use App\Repository\UserRepository;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

class VisualizationBlockService extends AbstractBlockService
{
    private TimeRegisterRepository $timeRegisterRepository;
    private UserRepository $userRepository;

    public function __construct(Environment $twig, TimeRegisterRepository $timeRegisterRepository, UserRepository $userRepository)
    {
        parent::__construct($twig);
        $this->timeRegisterRepository = $timeRegisterRepository;
        $this->userRepository = $userRepository;
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
        $weeklyData = array_reverse($this->timeRegisterRepository->getTotalHoursInvoiceableGroupedByWeek());
        $user1 = $this->userRepository->find(4);
        $user2 = $this->userRepository->find(5);
        $monthlyInvoiceableHours1 = $this->timeRegisterRepository->getTotalHoursInvoiceableGroupedByMonthAndUser($user1);
        $monthlyInvoiceableHours2 = $this->timeRegisterRepository->getTotalHoursInvoiceableGroupedByMonthAndUser($user2);
        $monthlyInvoiceableProject = $this->timeRegisterRepository->getTotalHoursGroupedByMonthAndProject();
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
                'weeklyData' => $weeklyData,
                'monthlyUser1' => $monthlyInvoiceableHours1,
                'monthlyUser2' => $monthlyInvoiceableHours2,
                'monthlyProject' => $monthlyInvoiceableProject,
            ),
            $response
        );
    }
}
