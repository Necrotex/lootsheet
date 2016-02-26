<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert(
            [

                //corp cut
                [
                    'key'   => 'corp_cut',
                    'name'  => 'Corp Cut %',
                    'value' => '0.3',
                    'type'  => 'corp_cut'
                ],

                //ship points
                [
                    'key'   => 'points_nemesis',
                    'name'  => 'Ship Points Nemesis',
                    'value' => '7',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_purifier',
                    'name'  => 'Ship Points Purifier',
                    'value' => '7',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_manticore',
                    'name'  => 'Ship Points Manticore',
                    'value' => '7',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_hound',
                    'name'  => 'Ship Points Hound',
                    'value' => '7',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_vagur',
                    'name'  => 'Ship Points Vagur',
                    'value' => '2',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_paladin',
                    'name'  => 'Ship Points Paladin',
                    'value' => '2',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_golem',
                    'name'  => 'Ship Points Golem',
                    'value' => '2',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_kronos',
                    'name'  => 'Ship Points Kronos',
                    'value' => '7',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_archon',
                    'name'  => 'Ship Points Archon',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_thanatos',
                    'name'  => 'Ship Points Thanatos',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_chimera',
                    'name'  => 'Ship Points Chimera',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_nidhoggur',
                    'name'  => 'Ship Points Nidhoggur',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_naglfar',
                    'name'  => 'Ship Points Naglfar',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_phoenix',
                    'name'  => 'Ship Points Phoenix',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_moros',
                    'name'  => 'Ship Points Moros',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],
                [
                    'key'   => 'points_revelation',
                    'name'  => 'Ship Points Revelation',
                    'value' => '0.5',
                    'type'  => 'ship_points'
                ],

                //Role Points
                [
                    'key'   => 'points_defanger',
                    'name'  => 'Role Points Defanger',
                    'value' => '1',
                    'type'  => 'role_points'
                ],
                [
                    'key'   => 'points_bomber',
                    'name'  => 'Role Points Bomber',
                    'value' => '7',
                    'type'  => 'role_points'
                ],
                [
                    'key'   => 'points_clearer',
                    'name'  => 'Role Points Clearer',
                    'value' => '2',
                    'type'  => 'role_points'
                ],
                [
                    'key'   => 'points_escalator',
                    'name'  => 'Role Points Escalator',
                    'value' => '0.5',
                    'type'  => 'role_points'
                ],
                [
                    'key'   => 'points_bookmarker',
                    'name'  => 'Role Points Bookmarker',
                    'value' => '0.5',
                    'type'  => 'role_points'
                ]
            ]
        );

    }
}
