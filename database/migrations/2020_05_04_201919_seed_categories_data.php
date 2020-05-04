
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class SeedCategoriesData extends Migration
{
    public function up()
    {
        $categories = [
            [
            'name' => '娱乐'
            ],
            [
            'name' => '音乐'
            ],
            [
            'name' => '舞蹈'
            ],
            [
            'name' => '生活'
            ],
            [
            'name' => '科技'
            ],
            [
            'name' => 'VLOG'
            ],
            [
            'name' => '鬼畜'
            ],
            [
            'name' => '游戏'
            ],
            [
            'name' => '番剧'
            ],
            [
            'name' => '影视'
            ],
            ];
        DB::table('categories')->insert($categories); }
    public function down()
    {
        DB::table('categories')->truncate(); }
}
