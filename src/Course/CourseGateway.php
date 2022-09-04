<?php

declare(strict_types=1);

namespace IncentiveFactory\Domain\Course;

use IncentiveFactory\Domain\Shared\Gateway;

/**
 * @template-extends Gateway<Course>
 */
interface CourseGateway extends Gateway
{
    public function getCourseBySlug(string $slug): ?Course;
}
