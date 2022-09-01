<?php

declare(strict_types=1);

namespace IncentiveFactory\Game\Tests\Application\Repository;

use DateTimeImmutable;
use IncentiveFactory\Game\Path\Path;
use IncentiveFactory\Game\Path\PathGateway;
use IncentiveFactory\Game\Path\Player;
use IncentiveFactory\Game\Path\Training;
use IncentiveFactory\Game\Path\TrainingGateway;
use IncentiveFactory\Game\Shared\Entity\PlayerInterface;
use Symfony\Component\Uid\Ulid;

final class InMemoryPathRepository implements PathGateway
{
    /**
     * @var array<string, Path>
     */
    public array $paths = [];

    public function __construct(private TrainingGateway $trainingGateway)
    {
        $this->init();
    }

    public function init(): void
    {
        $this->paths = [
            '01GBXF8ATAE03HY5ZC3ES90122' => Path::create(
                id: Ulid::fromString('01GBXF8ATAE03HY5ZC3ES90122'),
                player: Player::create(Ulid::fromString('01GBJK7XV3YXQ51EHN9G5DAMYN')),
                training: $this->trainingGateway->trainings['01GBWW5FJJ0G3YK3RJM6VWBZBG'],
                beganAt: new DateTimeImmutable('2021-01-01 00:00:00')
            ),
            '01GBXF8EPC06PV81J70Z0ACKCC' => Path::create(
                id: Ulid::fromString('01GBXF8EPC06PV81J70Z0ACKCC'),
                player: Player::create(Ulid::fromString('01GBJK7XV3YXQ51EHN9G5DAMYN')),
                training: $this->trainingGateway->trainings['01GBWW5JHNPEXD8S0J5HPT97S2'],
                beganAt: new DateTimeImmutable('2021-01-01 00:00:00')
            ),
        ];
    }

    public function begin(Path $path): void
    {
        $this->paths[(string) $path->id()] = $path;
    }

    public function hasAlreadyBegan(PlayerInterface $player, Training $training): bool
    {
        foreach ($this->paths as $path) {
            if ($path->player()->id()->equals($player->id()) && $path->training()->id()->equals($training->id())) {
                return true;
            }
        }

        return false;
    }

    public function findByPlayer(PlayerInterface $player): array
    {
        $paths = [];
        foreach ($this->paths as $path) {
            if ($path->player()->id()->equals($player->id())) {
                $paths[] = $path;
            }
        }

        return $paths;
    }
}
