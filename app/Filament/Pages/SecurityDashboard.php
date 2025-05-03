<?php

namespace App\Filament\Pages;

use App\Models\PaymentMethod;
use App\Services\Security\PBKDF2Service;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class SecurityDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    protected static string $view = 'filament.pages.security-dashboard';

    protected static ?string $navigationLabel = 'Keamanan Data';

    protected static ?string $title = 'Dashboard Keamanan Data';

    protected static ?int $navigationSort = 2;

    public function getViewData(): array
    {
        return [
            'encryptedMethodsCount' => PaymentMethod::count(),
            'enhancedEncryptedCount' => PaymentMethod::whereNotNull('cvv_enhanced')->count(),
            'dbSize' => $this->getDatabaseSize(),
            'encryptionAlgorithms' => [
                [
                    'name' => 'AES-256-CBC',
                    'keySize' => '256 bit',
                    'description' => 'Enkripsi standar menggunakan AES-256 dengan mode CBC',
                    'usedFor' => 'Detail kartu, alamat pengguna',
                    'strength' => 'Tinggi',
                ],
                [
                    'name' => 'PBKDF2 + AES-256',
                    'keySize' => '256 bit dengan derivasi 10,000 iterasi',
                    'description' => 'Key-derivation function dengan 10,000 iterasi dan salt unik per data',
                    'usedFor' => 'Data sangat sensitif (CVV)',
                    'strength' => 'Sangat Tinggi',
                ],
            ],
            'securityStats' => [
                'totalEncrypted' => DB::table('payment_methods')->count() + DB::table('users')->where('payment_info', '!=', null)->count(),
                'pbkdf2Protected' => DB::table('payment_methods')->whereNotNull('cvv_enhanced')->count(),
                'averageStrength' => 'Tinggi (AES-256 + PBKDF2)',
            ],
        ];
    }

    /**
     * Get the database size in MB
     */
    private function getDatabaseSize(): string
    {
        $connection = config('database.default');
        $database = config("database.connections.{$connection}.database");

        if ($connection === 'mysql') {
            try {
                $result = DB::select("SELECT
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size
                    FROM information_schema.TABLES
                    WHERE table_schema = ?", [$database]);

                return number_format($result[0]->size, 2) . ' MB';
            } catch (\Exception $e) {
                return 'N/A';
            }
        } elseif ($connection === 'sqlite') {
            try {
                $path = DB::connection()->getDatabaseName();
                if (file_exists($path)) {
                    return number_format(filesize($path) / 1024 / 1024, 2) . ' MB';
                }
            } catch (\Exception $e) {
                // Ignore
            }
        }

        return 'N/A';
    }
}
