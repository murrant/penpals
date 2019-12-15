<?php

namespace App\Providers;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerMacros()
    {
        Blueprint::macro('dropDefaultConstraint', function (string $column) {
            $connection = Schema::getConnection();
            if ($connection->getDriverName() === 'sqlsrv') {
                $query = sprintf(
                    'SELECT OBJECT_NAME([default_object_id]) AS name ' .
                    'FROM SYS.COLUMNS ' .
                    "WHERE [object_id] = OBJECT_ID('[dbo].[%s]') AND [name] = '%s'",
                    $this->getTable(),
                    $column
                );
                $result = $connection->selectOne($query);
                $constraint = new Index($result->name, [$column]);
                $connection->getDoctrineSchemaManager()->dropConstraint($constraint, $this->getTable());
            }
        });
    }
}
