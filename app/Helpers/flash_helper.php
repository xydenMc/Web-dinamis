<?php

if (! function_exists('flash_message')) {
    /**
     * Returns flashdata as a single displayable string.
     *
     * This intentionally flattens nested arrays, so malformed/legacy flashdata
     * cannot reach esc() as an array and trigger an "Array to string conversion"
     * warning.
     */
    function flash_message(string $key, string $separator = ' '): string
    {
        $flatten = static function ($value) use (&$flatten): array {
            if ($value === null) {
                return [];
            }

            if (is_array($value)) {
                $parts = [];
                foreach ($value as $item) {
                    array_push($parts, ...$flatten($item));
                }

                return $parts;
            }

            if (is_bool($value)) {
                return [$value ? 'true' : 'false'];
            }

            if (is_scalar($value) || $value instanceof \Stringable) {
                return [(string) $value];
            }

            return [];
        };

        return implode($separator, $flatten(session()->getFlashdata($key)));
    }
}
