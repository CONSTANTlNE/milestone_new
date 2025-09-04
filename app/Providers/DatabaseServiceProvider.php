<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 🔹 GIN Index (good for JSONB, arrays, full-text search)
        Blueprint::macro('ginIndex', function ($column, $name = null, $ops = 'jsonb_path_ops') {
            $table = $this->getTable();
            $indexName = $name ?? $table . '_' . $column . '_gin_index';
            DB::statement("CREATE INDEX {$indexName} ON {$table} USING gin ({$column} {$ops})");
        });

        Blueprint::macro('dropGinIndex', function ($column, $name = null) {
            $table = $this->getTable();
            $indexName = $name ?? $table . '_' . $column . '_gin_index';
            DB::statement("DROP INDEX IF EXISTS {$indexName}");
        });

        // 🔹 GiST Index (good for ranges, trigram, geometric, JSONB)
        Blueprint::macro('gistIndex', function ($column, $name = null) {
            $table = $this->getTable();
            $indexName = $name ?? $table . '_' . $column . '_gist_index';
            DB::statement("CREATE INDEX {$indexName} ON {$table} USING gist ({$column})");
        });

        // 🔹 Expression Index (e.g. JSONB key extraction)
        Blueprint::macro('expressionIndex', function ($expression, $name = null, $using = 'btree') {
            $table = $this->getTable();
            $indexName = $name ?? $table . '_expr_index';
            DB::statement("CREATE INDEX {$indexName} ON {$table} USING {$using} ({$expression})");
        });
    }
}
