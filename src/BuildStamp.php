<?php

namespace Frietzakje\Ui;

/**
 * Builds the suite-wide build stamp shown in every app's footer / error page,
 * e.g. "v3.28.0 · UI · e3ad64e" — the app version, the app's two-letter code,
 * and the short commit SHA. This makes a version reported by a user unambiguous
 * about which suite app it came from (they all share one design).
 */
class BuildStamp
{
    /**
     * The full stamp for the current app. Any part that cannot be resolved is
     * omitted cleanly, so "v3.28.0 · UI" is valid when no commit is baked in
     * (e.g. local dev), and an unmapped app just drops the code.
     */
    public static function current(): string
    {
        $version = trim((string) config('app.version'));
        $commit = trim((string) config('app.commit'));

        return implode(' · ', array_filter([
            $version !== '' ? 'v'.$version : null,
            self::code(),
            $commit !== '' ? $commit : null,
        ]));
    }

    /**
     * The current app's two-letter code from the central map
     * (config/frietzakje-ui.php → 'codes'), keyed off FRIETZAKJE_APP.
     * Null when the app is unset or has no mapped code.
     */
    public static function code(): ?string
    {
        $app = config('frietzakje-ui.app');

        if (! is_string($app) || $app === '') {
            return null;
        }

        $code = config('frietzakje-ui.codes.'.$app);

        return is_string($code) && $code !== '' ? $code : null;
    }
}
