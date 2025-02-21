<?php

namespace SerhiiKorniienko\Reportify;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ReportifyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-reportify')
            ->hasConfigFile('reportify')
            ->hasMigration('create_reportify_table')
            ->runsMigrations();
    }
}
