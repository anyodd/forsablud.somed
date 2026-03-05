<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DeploymentController extends Controller
{
    /**
     * Handle the GitHub webhook.
     */
    public function githubWebhook(Request $request)
    {
        $signature = $request->header('X-Hub-Signature-256');
        $payload = $request->getContent();
        $secret = config('services.github.webhook_secret') ?? env('GITHUB_WEBHOOK_SECRET');

        if (!$signature || !$this->validateSignature($signature, $payload, $secret)) {
            Log::warning('GitHub Webhook: Invalid signature');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $event = $request->header('X-GitHub-Event');
        Log::info("GitHub Webhook: Received event: $event");

        if ($event === 'push') {
            $this->deploy();
        }

        return response()->json(['message' => 'Webhook processed']);
    }

    /**
     * Validate the GitHub signature.
     */
    private function validateSignature($signature, $payload, $secret)
    {
        if (!$secret) {
            Log::error('GitHub Webhook: Secret not configured');
            return false;
        }

        $expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);
        return hash_equals($expected, $signature);
    }

    /**
     * Execute the deployment commands.
     */
    private function deploy()
    {
        Log::info('GitHub Webhook: Starting deployment...');

        $commands = [
            'cd ' . base_path(),
            'git pull origin master 2>&1',
            'composer install --no-interaction --prefer-dist --optimize-autoloader 2>&1',
            'php artisan migrate --force 2>&1',
            'php artisan optimize 2>&1',
        ];

        $output = [];
        foreach ($commands as $command) {
            $result = shell_exec($command);
            $output[] = "Command: $command\nOutput: $result";
            Log::info("GitHub Webhook executed: $command");
        }

        Log::info('GitHub Webhook: Deployment finished.', ['output' => $output]);
    }
}
