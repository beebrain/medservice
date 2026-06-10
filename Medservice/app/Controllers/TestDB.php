<?php

namespace App\Controllers;

class TestDB extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $output = "=== Database Connection Test ===\n\n";

        try {
            // Test connection
            $output .= "Testing connection...\n";
            $db->initialize();

            // Get database info
            $output .= "✓ Connected successfully!\n\n";
            $output .= "Database Details:\n";
            $output .= "- Hostname: " . $db->hostname . "\n";
            $output .= "- Username: " . $db->username . "\n";
            $output .= "- Database: " . $db->database . "\n";
            $output .= "- Driver: " . $db->DBDriver . "\n";
            $output .= "- Port: " . $db->port . "\n\n";

            // Test query - show tables
            $query = $db->query("SHOW TABLES");
            $tables = $query->getResult();

            $output .= "Tables in database '" . $db->database . "':\n";
            if (count($tables) > 0) {
                foreach ($tables as $table) {
                    $tableName = array_values((array)$table)[0];
                    $output .= "- " . $tableName . "\n";
                }
            } else {
                $output .= "No tables found.\n";
            }

            $output .= "\n✓ Database connection is working properly!\n";

        } catch (\Exception $e) {
            $output .= "✗ Connection failed!\n\n";
            $output .= "Error: " . $e->getMessage() . "\n";
        }

        return '<pre>' . htmlspecialchars($output) . '</pre>';
    }
}
