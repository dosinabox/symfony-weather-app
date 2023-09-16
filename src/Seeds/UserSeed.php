<?php

namespace App\Seeds;

use Evotodi\SeedBundle\Command\Seed;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class UserSeed extends Seed
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    /**
     * Return the name of your seed
     */
    public static function seedName(): string
    {
        /**
         * The seed won't load if this is not set
         * The resulting command will be seed:user
         */
        return 'user';
    }

    /**
     * Optional ordering of the seed load/unload.
     * Seeds are loaded/unloaded in ascending order starting from 0.
     * Multiple seeds with the same order are randomly loaded.
     */
    public static function getOrder(): int
    {
        return 0;
    }

    /**
     * The load method is called when loading a seed
     */
    public function load(InputInterface $input, OutputInterface $output): int
    {
        $users = [
            [
                'firstName' => 'Admin',
                'lastName' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'password123',
                'roles' => ['ROLE_ADMIN'],
            ],
        ];

        foreach ($users as $user){
            $userRepo = new User();
            $userRepo->setFirstName($user['firstName']);
            $userRepo->setLastName($user['lastName']);
            $userRepo->setEmail($user['email']);
            $userRepo->setRoles($user['roles']);
            $userRepo->setPassword($user['password']);
            $this->entityManager->persist($userRepo);
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        /**
         * Must return an exit code.
         * A value other than 0 or Command::SUCCESS is considered a failed seed load/unload.
         */
        return 0;
    }

    /**
     * The unload method is called when unloading a seed
     */
    public function unload(InputInterface $input, OutputInterface $output): int
    {
        //Clear the table
        $this->entityManager->getConnection()->exec('DELETE FROM user');

        /**
         * Must return an exit code.
         * A value other than 0 or Command::SUCCESS is considered a failed seed load/unload.
         */
        return 0;
    }
}
