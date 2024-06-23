<?php

namespace dipto0079\DatabaseExporter\Console\Commands;

use Illuminate\Console\Command;
use ZipArchive;

class ExportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the database and zip it.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST', '127.0.0.1');
        $storagePath = storage_path('app/backup.sql');
        $zipPath = storage_path('app/backup.zip');

        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$storagePath}";

        exec($command);

        if (file_exists($storagePath)) {
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                $zip->addFile($storagePath, 'backup.sql');
                $zip->close();

                unlink($storagePath);

                $this->info('Database exported and zipped successfully.');
            } else {
                $this->error('Failed to create zip file.');
            }
        } else {
            $this->error('Failed to export the database.');
        }
    }
}
