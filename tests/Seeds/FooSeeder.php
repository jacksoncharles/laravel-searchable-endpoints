<?php

use Phinx\Seed\AbstractSeed;

class FooSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = array(
          array(
              'body'        => 'foo',
              'created_at'  => date('Y-m-d H:i:s')
          )
        );

        $foos = $this->table('foos');
        $foos->insert($data)
              ->save();

        $faker = Faker\Factory::create();
        $data = [];
        for ($i = 0; $i < 10; $i++) {
          $data[] = [
              'body'            => $faker->word(),
              'created_at'       => date('Y-m-d H:i:s')
          ];
          echo "inserted\n";
        }

        $this->insert('foobars', $data)->save();              
    }
}
