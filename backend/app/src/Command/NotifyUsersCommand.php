<?php

namespace App\Command;

use App\Entity\UserFilter;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class NotifyUsersCommand extends Command
{
    protected static $defaultName = 'app:notify-users';

    private EntityManagerInterface $entityManager;
    private MailerInterface $mailer;

    public function __construct(EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filters = $this->entityManager->getRepository(UserFilter::class)->findAll();

        foreach ($filters as $filter) {
            $user = $filter->getUser();
            $criteria = $filter->getFilters();

            // Example: Match criteria (simplified)
            $events = $this->entityManager->getRepository(Event::class)->findBy($criteria);

            if (count($events) > 0) {
                $eventTitles = array_map(fn($event) => $event->getTitle(), $events);

                $email = (new Email())
                    ->from('no-reply@example.com')
                    ->to($user->getEmail())
                    ->subject('New Events Matching Your Filters')
                    ->text('Matching Events: ' . implode(', ', $eventTitles));

                $this->mailer->send($email);

                $output->writeln("Notification sent to {$user->getEmail()}");
            }
        }

        return Command::SUCCESS;
    }
}
