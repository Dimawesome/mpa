<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class DeleteEmptyPages
 *
 * @package App\Console\Commands
 */
class DeleteEmptyPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:delete-empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete automatically generated pages';

    /**
     * @var string
     */
    protected string $table = 'pages';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        DB::table($this->table)
            ->whereColumn('created_at', 'updated_at')
            ->where('title', '=', null)
            ->where('created_at', '>', Carbon::now()->addHours(3))
            ->delete();

        $this->info('Empty page and modal records deleted.');
    }
}
