<?php

namespace App\Install;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class Database
{
    public function setup($data)
    {
        $this->checkDatabaseConnection($data);
        $this->setEnvVariables($data);
        $this->migrateDatabase();
    }

    private function checkDatabaseConnection($data)
    {
        $this->setupDatabaseConnectionConfig($data);
        $driver = env('DB_CONNECTION', 'mysql');
        DB::connection($driver)->getPdo();
    }

    private function setupDatabaseConnectionConfig($data)
    {
        $driver = env('DB_CONNECTION', 'mysql');
        config([
            "database.connections.{$driver}.host" => $data->host,
            "database.connections.{$driver}.port" => $data->post,
            "database.connections.{$driver}.database" => $data->name,
            "database.connections.{$driver}.username" => $data->username,
            "database.connections.{$driver}.password" => $data->password,
        ]);
        DB::connection($driver)->reconnect();
    }

    private function setEnvVariables($data)
    {
        $env = DotenvEditor::load();
        $env->autoBackup(false);

        $env->setKey('DB_HOST', $data->host);
        $env->setKey('DB_PORT', $data->post);
        $env->setKey('DB_DATABASE', $data->name);
        $env->setKey('DB_USERNAME', $data->username);
        $env->setKey('DB_PASSWORD', $data->password);
        $env->setKey('LICENSE_KEY', $data->license_key);
        $env->save();
    }

    private function migrateDatabase()
    {
        Artisan::call('migrate:fresh', ['--force' => true,'--seed' => true]);
    }
}
