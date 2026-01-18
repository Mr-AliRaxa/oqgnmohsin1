<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;

class MailConfigServiceProvider extends ServiceProvider
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
        // Only configure if the smtp_settings table exists and we're not in console
        if (Schema::hasTable('smtp_settings')) {
            try {
                // Get the active SMTP setting
                $smtpSetting = SmtpSetting::where('is_active', true)->first();

                if ($smtpSetting) {
                    // Decrypt the password
                    $password = Crypt::decryptString($smtpSetting->password);

                    // Configure mail settings dynamically
                    Config::set('mail.default', 'smtp');
                    Config::set('mail.mailers.smtp', [
                        'transport' => 'smtp',
                        'host' => $smtpSetting->host,
                        'port' => $smtpSetting->port,
                        'encryption' => $smtpSetting->encryption,
                        'username' => $smtpSetting->username,
                        'password' => $password,
                        'timeout' => null,
                    ]);

                    Config::set('mail.from', [
                        'address' => $smtpSetting->from_address,
                        'name' => $smtpSetting->from_name,
                    ]);
                }
            } catch (\Exception $e) {
                // Silently fail if there's an error (e.g., during migration)
                // This prevents the application from breaking
            }
        }
    }
}
