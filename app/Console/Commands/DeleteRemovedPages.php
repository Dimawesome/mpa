<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class DeleteRemovedPages
 *
 * @package App\Console\Commands
 */
class DeleteRemovedPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'page:delete-removed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete removed pages';

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
        $now = Carbon::now();

        DB::table($this->table)
            ->where('is_deleted', '=', 1)
            ->whereNotBetween('updated_at', [$now->startOfMonth()->toDateString(), $now->endOfMonth()->toDateString()])
            ->delete();

        $this->info('Removed pages deleted.');
    }
}
