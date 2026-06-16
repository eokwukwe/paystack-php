<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Support;

final class Arr
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function dropNulls(array $data): array
    {
        return array_filter($data, static fn ($value): bool => $value !== null);
    }

    /**
     * @param  mixed  $value
     */
    public static function boolToString($value): mixed
    {
        return is_bool($value) ? ($value ? 'true' : 'false') : $value;
    }
}
