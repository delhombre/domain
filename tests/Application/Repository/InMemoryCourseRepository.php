<?php

declare(strict_types=1);

namespace IncentiveFactory\Domain\Tests\Application\Repository;

use DateTimeImmutable;
use IncentiveFactory\Domain\Course\Course;
use IncentiveFactory\Domain\Course\CourseGateway;
use IncentiveFactory\Domain\Course\Level;
use IncentiveFactory\Domain\Shared\Entity\TrainingInterface;
use Symfony\Component\Uid\Ulid;

final class InMemoryCourseRepository implements CourseGateway
{
    /**
     * @var array<string, Course>
     */
    public array $courses = [];

    public function __construct()
    {
        $this->init();
    }

    public static function createCourse(int $index, string $ulid, TrainingInterface $training): Course
    {
        return Course::create(
            id: Ulid::fromString($ulid),
            publishedAt: new DateTimeImmutable('2021-01-01 00:00:00'),
            name: sprintf('Course %d', $index),
            excerpt: 'Excerpt',
            content: 'Content',
            slug: sprintf('course-%d', $index),
            image: 'image.png',
            video: 'https://youtu.be/ABCDEFGH',
            thread: ['tweet'],
            level: Level::Easy,
            training: $training
        );
    }

    public function init(): void
    {
        $this->courses = [
            '01GBYMQQK3TY08FEVA0GTJ4QZM' => self::createCourse(1, '01GBYMQQK3TY08FEVA0GTJ4QZM', InMemoryTrainingRepository::createTraining(1, '01GBWW5FJJ0G3YK3RJM6VWBZBG')),
            '01GBYN0SWAMB7N272PW7G1VDF0' => self::createCourse(2, '01GBYN0SWAMB7N272PW7G1VDF0', InMemoryTrainingRepository::createTraining(1, '01GBWW5FJJ0G3YK3RJM6VWBZBG')),
            '01GBYN0XFWE0HSS8TT5YNXVH6W' => self::createCourse(3, '01GBYN0XFWE0HSS8TT5YNXVH6W', InMemoryTrainingRepository::createTraining(1, '01GBWW5JHNPEXD8S0J5HPT97S2')),
            '01GBYN103WP1WEGMKHHB2GMPE8' => self::createCourse(4, '01GBYN103WP1WEGMKHHB2GMPE8', InMemoryTrainingRepository::createTraining(1, '01GBWW5JHNPEXD8S0J5HPT97S2')),
            '01GBYN142CCSYD738NWKD15MN5' => self::createCourse(5, '01GBYN142CCSYD738NWKD15MN5', InMemoryTrainingRepository::createTraining(1, '01GBWW96THK59QHW3XESM56RJH')),
            '01GBYN16VCBNZN51D1Z401V2TG' => self::createCourse(6, '01GBYN16VCBNZN51D1Z401V2TG', InMemoryTrainingRepository::createTraining(1, '01GBWW96THK59QHW3XESM56RJH')),
        ];
    }

    public function getCourseBySlug(string $slug): ?Course
    {
        foreach ($this->courses as $course) {
            if ($course->slug() === $slug) {
                return $course;
            }
        }

        return null;
    }
}
