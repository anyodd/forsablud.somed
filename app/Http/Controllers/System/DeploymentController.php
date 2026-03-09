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
        Log::info('GitHub Webhook: Request received');
        $signature = $request->header('X-Hub-Signature-256') ?: $request->header('X-Hub-Signature');
        $payload = $request->getContent();
        $secret = config('services.github.webhook_secret') ?? env('GITHUB_WEBHOOK_SECRET');

        if (!$signature) {
            Log::warning('GitHub Webhook: No signature header found');
            return response()->json(['message' => 'No signature header'], 403);
        }

        if (!$this->validateSignature($signature, $payload, $secret)) {
            Log::warning('GitHub Webhook: Signature mismatch');
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

        if (strpos($signature, 'sha256=') === 0) {
            $expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);
        } else {
            $expected = 'sha1=' . hash_hmac('sha1', $payload, $secret);
        }

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
