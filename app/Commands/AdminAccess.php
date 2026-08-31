<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AdminAccess extends BaseCommand
{
    protected $group = 'HiredNext';
    protected $name = 'admin:access';
    protected $description = 'List HiredNext admin-capable accounts or reset one account to a temporary password.';
    protected $usage = 'admin:access [username-or-email]';
    protected $arguments = [
        'username-or-email' => 'Optional. If supplied, resets that admin-capable account to a generated temporary password.',
    ];

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        if (!$db->tableExists('users')) {
            CLI::error('The users table does not exist.');
            return;
        }

        $identifier = trim((string)($params[0] ?? ''));
        $roles = ['admin', 'manager', 'recruiter'];

        if ($identifier === '') {
            $rows = $db->table('users')
                ->select('id, username, email, name, role, status')
                ->whereIn('role', $roles)
                ->orderBy('role', 'ASC')
                ->orderBy('username', 'ASC')
                ->get()
                ->getResultArray();

            if (!$rows) {
                CLI::write('No admin-capable HiredNext users found.', 'yellow');
                return;
            }

            CLI::write('HIREDNEXT ADMIN-CAPABLE ACCOUNTS', 'green');
            CLI::write(str_repeat('-', 100));
            CLI::write(sprintf('%-6s %-22s %-32s %-20s %-12s %-10s', 'ID', 'USERNAME', 'EMAIL', 'NAME', 'ROLE', 'STATUS'));
            CLI::write(str_repeat('-', 100));
            foreach ($rows as $row) {
                CLI::write(sprintf(
                    '%-6s %-22s %-32s %-20s %-12s %-10s',
                    (string)($row['id'] ?? ''),
                    mb_strimwidth((string)($row['username'] ?? ''), 0, 21, '…'),
                    mb_strimwidth((string)($row['email'] ?? ''), 0, 31, '…'),
                    mb_strimwidth((string)($row['name'] ?? ''), 0, 19, '…'),
                    (string)($row['role'] ?? ''),
                    (string)($row['status'] ?? '')
                ));
            }
            CLI::write(str_repeat('-', 100));
            CLI::write('To reset one account: php spark admin:access <username-or-email>');
            return;
        }

        $builder = $db->table('users');
        $builder->groupStart()
            ->where('username', $identifier)
            ->orWhere('email', $identifier)
            ->groupEnd()
            ->whereIn('role', $roles);
        $user = $builder->get()->getRowArray();

        if (!$user) {
            CLI::error('No admin-capable account matches: ' . $identifier);
            return;
        }

        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
        $random = '';
        for ($i = 0; $i < 14; $i++) {
            $random .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        $temporaryPassword = 'HN!' . $random;

        $update = [
            'password' => password_hash($temporaryPassword, PASSWORD_DEFAULT),
            'status' => 'active',
        ];

        $fields = $db->getFieldNames('users');
        if (in_array('updated_at', $fields, true)) {
            $update['updated_at'] = date('Y-m-d H:i:s');
        }

        $db->table('users')->where('id', (int)$user['id'])->update($update);

        CLI::write('ADMIN ACCESS RESET', 'green');
        CLI::write('Username: ' . ($user['username'] ?? ''));
        CLI::write('Email: ' . ($user['email'] ?? ''));
        CLI::write('Role: ' . ($user['role'] ?? ''));
        CLI::write('Temporary password: ' . $temporaryPassword, 'yellow');
        CLI::write('Login: https://hirednext.net/admin/cv-reviews');
        CLI::write('Use the temporary password once, then change the account password from the HiredNext admin account settings.');
        CLI::write('Do not paste the temporary password into chat or store it in GitHub.', 'yellow');
    }
}
