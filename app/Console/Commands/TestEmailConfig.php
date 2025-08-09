<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\EmailService;

class TestEmailConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : Email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration by sending a test email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $emailService = new EmailService();
        
        $this->info("Testing email configuration...");
        $this->info("Sending test email to: {$email}");
        
        if ($emailService->testEmailConfiguration($email)) {
            $this->info("✓ Test email sent successfully!");
            $this->info("Check the inbox for {$email}");
        } else {
            $this->error("✗ Failed to send test email");
            $this->error("Please check your email configuration and logs for more details");
        }
        
        // Display current email configuration
        $this->info("\nCurrent Email Configuration:");
        $this->line("MAIL_MAILER: " . config('mail.default'));
        $this->line("MAIL_HOST: " . config('mail.mailers.smtp.host'));
        $this->line("MAIL_PORT: " . config('mail.mailers.smtp.port'));
        $this->line("MAIL_USERNAME: " . config('mail.mailers.smtp.username'));
        $this->line("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        $this->line("MAIL_FROM_NAME: " . config('mail.from.name'));
        
        return Command::SUCCESS;
    }
}